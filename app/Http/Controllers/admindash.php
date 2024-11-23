<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\User;

class admindash extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     */
    public function index()
    {
        $totalUsers = User::count();
        $userUsers = User::where('roles', 'user')->count();
        $pendingUsers = User::where('is_approved', false)->count();

        return view('admin.dashboard', compact('totalUsers', 'userUsers', 'pendingUsers'));
    }

    /**
     * Display a list of users with optional filtering.
     */
    public function manageUsers(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
        }

        // Date filter
        if ($request->has('date_filter')) {
            $dateFilter = $request->date_filter;
            if ($dateFilter == 'today') {
                $query->whereDate('created_at', now()->toDateString());
            } elseif ($dateFilter == 'yesterday') {
                $query->whereDate('created_at', now()->subDay()->toDateString());
            } elseif ($dateFilter == 'last_week') {
                $query->whereBetween('created_at', [now()->subWeek(), now()]);
            } elseif ($dateFilter == 'last_month') {
                $query->whereMonth('created_at', now()->subMonth()->month);
            }
        }

        // Sorting functionality
        // $sortBy = $request->get('sort_by', 'created_at'); 
        // $sortOrder = $request->get('sort_order', 'desc'); 
        // $query->orderBy($sortBy, $sortOrder);

        $users = $query->paginate(10);

        return view('admin.manage-users', compact('users'));
    }

    /**
     * Approve multiple users in bulk.
     */
    public function bulkApprove(Request $request)
    {
        $userIds = json_decode($request->input('userIds'));
        User::whereIn('id', $userIds)->update(['is_approved' => true]);

        return redirect()->route('admin.manage-users')->with('success', 'Selected users have been approved.');
    }

    public function bulkDisapprove(Request $request)
    {
        $userIds = json_decode($request->input('userIds'));
        User::whereIn('id', $userIds)->update(['is_approved' => false]);

        return redirect()->route('admin.manage-users')->with('success', 'Selected users have been disapproved.');
    }

    public function bulkDelete(Request $request)
    {
        $userIds = json_decode($request->input('userIds'));
        User::whereIn('id', $userIds)->delete();

        return redirect()->route('admin.manage-users')->with('success', 'Selected users have been deleted.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.manage-users')->with('success', 'User deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'is_approved' => 'nullable|boolean',
            'roles' => 'required|in:user,admin',
        ]);

        // Update user attributes
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->is_approved = $request->has('is_approved') ? 1 : 0;
        $user->roles = $validatedData['roles'];
        $user->save();

        return redirect()->route('admin.manage-users')->with('success', 'User updated successfully.');
    }

    public function indexEvents()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.manage-events', compact('events'));
    }

    public function createEvent()
    {
        return view('admin.events.create-events');
    }

    private function generateSecureImageName($file)
    {
        $extension = $file->getClientOriginalExtension();
        $randomName = Str::uuid() . '_' . time();
        return $randomName . '.' . $extension;
    }

    private function storeEventBanner($file)
    {
        if (!$file) {
            return null;
        }

        $fileName = $this->generateSecureImageName($file);
        $path = $file->storeAs('events', $fileName, 'public');

        return $path;
    }

    private function deleteEventBanner($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'participant_limit' => 'nullable|integer|min:1',
            'event_start_date' => 'required|date',
            'event_start_time' => 'required',
            'event_end_date' => 'required|date',
            'event_end_time' => 'required',
        ]);

        try {
            $startDateTime = Carbon::parse($request->event_start_date . ' ' . $request->event_start_time);
            $endDateTime = Carbon::parse($request->event_end_date . ' ' . $request->event_end_time);

            if ($endDateTime <= $startDateTime) {
                return back()
                    ->withInput()
                    ->withErrors(['event_end_date' => 'Event end time must be after the start time']);
            }

            $bannerPath = $request->file('banner')->store('events', 'public');

            Event::create([
                'name' => $validated['name'],
                'banner' => $bannerPath,
                'description' => $validated['description'],
                'participant_limit' => $validated['participant_limit'],
                'registration_start' => $startDateTime,
                'registration_end' => $endDateTime,
            ]);

            return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'There was an error creating the event: ' . $e->getMessage());
        }
    }

    public function editEvent(Event $event)
    {
        $event->event_start_date = Carbon::parse($event->registration_start)->format('Y-m-d');
        $event->event_start_time = Carbon::parse($event->registration_start)->format('H:i');
        $event->event_end_date = Carbon::parse($event->registration_end)->format('Y-m-d');
        $event->event_end_time = Carbon::parse($event->registration_end)->format('H:i');

        return view('admin.events.edit-events', compact('event'));
    }

    public function updateEvent(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'participant_limit' => 'nullable|integer|min:1',
            'event_start_date' => 'required|date',
            'event_start_time' => 'required',
            'event_end_date' => 'required|date',
            'event_end_time' => 'required',
        ]);

        try {
            // Parse the event start and end datetime
            $startDateTime = Carbon::parse($request->event_start_date . ' ' . $request->event_start_time);
            $endDateTime = Carbon::parse($request->event_end_date . ' ' . $request->event_end_time);

            // Validate start and end datetime logic
            if ($endDateTime <= $startDateTime) {
                return back()
                    ->withInput()
                    ->withErrors(['event_end_date' => 'Event end time must be after the start time']);
            }

            $bannerPath = $event->banner; // Default to the current banner

            // Handle banner upload if a new file is provided
            if ($request->hasFile('banner')) {
                $newBannerPath = $this->storeEventBanner($request->file('banner'));
                if ($newBannerPath) {
                    $this->deleteEventBanner($event->banner); // Delete the old banner
                    $bannerPath = $newBannerPath; // Update to the new banner
                }
            }

            // Update event with validated data and computed paths
            $event->update([
                'name' => $validated['name'],
                'banner' => $bannerPath,
                'description' => $validated['description'] ?? $event->description,
                'participant_limit' => $validated['participant_limit'] ?? $event->participant_limit,
                'registration_start' => $startDateTime,
                'registration_end' => $endDateTime,
            ]);

            return redirect()
                ->route('admin.events.index')
                ->with('success', 'Event updated successfully.');

        } catch (\Exception $e) {
            // Clean up the new banner if an error occurs during processing
            if (isset($newBannerPath)) {
                $this->deleteEventBanner($newBannerPath);
            }

            return back()
                ->withInput()
                ->with('error', 'There was an error updating the event: ' . $e->getMessage());
        }
    }


    public function deleteEvent(Event $event)
    {
        try {
            $this->deleteEventBanner($event->banner);
            $event->delete();

            return redirect()
                ->route('admin.events.index')
                ->with('success', 'Event deleted successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'There was an error deleting the event. Please try again.');
        }
    }

    public function participants(Event $event)
    {
        // Ensure a relationship exists to fetch participants
        $participants = $event->participants; // Assumes you have a `participants` relationship in the Event model

        // Pass the event and its participants to the view
        return view('admin.events.participants', compact('event', 'participants'));
    }


    public function removeParticipant(Event $event, User $participant)
    {
        $event->participants()->detach($participant->id);
        return redirect()->back()->with('success', 'Participant removed successfully.');
    }


}
