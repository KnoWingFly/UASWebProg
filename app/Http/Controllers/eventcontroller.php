<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class eventcontroller extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index()
    {
        $events = Event::all();

        // Optionally update registration status dynamically
        foreach ($events as $event) {
            $this->updateRegistrationStatus($event);
        }

        return view('admin.events.manage-events', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('admin.events.create-event');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'participant_limit' => 'nullable|integer|min:1',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after:registration_start',
        ]);

        $bannerPath = $request->file('banner')->store('events', 'public');

        $event = Event::create([
            'name' => $validated['name'],
            'banner' => $bannerPath,
            'description' => $validated['description'],
            'participant_limit' => $validated['participant_limit'],
            'registration_start' => Carbon::parse($validated['registration_start']),
            'registration_end' => Carbon::parse($validated['registration_end']),
        ]);

        // Update registration status dynamically
        $this->updateRegistrationStatus($event);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit-event', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'participant_limit' => 'nullable|integer|min:1',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after:registration_start',
        ]);

        // Handle banner upload
        $bannerPath = $event->banner;
        if ($request->hasFile('banner')) {
            $newBannerPath = $request->file('banner')->store('events', 'public');
            if ($newBannerPath) {
                Storage::disk('public')->delete($event->banner); // Delete old banner
                $bannerPath = $newBannerPath;
            }
        }

        $event->update([
            'name' => $validated['name'],
            'banner' => $bannerPath,
            'description' => $validated['description'],
            'participant_limit' => $validated['participant_limit'],
            'registration_start' => Carbon::parse($validated['registration_start']),
            'registration_end' => Carbon::parse($validated['registration_end']),
        ]);

        // Update registration status dynamically
        $this->updateRegistrationStatus($event);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        // Delete event banner
        if ($event->banner) {
            Storage::disk('public')->delete($event->banner);
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Dynamically update the registration status based on the current time.
     */
    private function updateRegistrationStatus(Event $event)
    {
        $now = Carbon::now();

        if ($now->isBefore($event->registration_start)) {
            $event->registration_status = 'closed'; // Before registration starts
        } elseif ($now->isAfter($event->registration_end)) {
            $event->registration_status = 'closed'; // After registration ends
        } else {
            $event->registration_status = 'open'; // During registration
        }

        $event->save();
    }
}
