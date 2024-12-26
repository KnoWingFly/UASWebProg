<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityHistory;
use App\Models\Achievement;
use App\Models\Event;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Updated to use pivot table relationship
        $userActivities = $user->activityHistories()->latest()->get();

        return view('user.dashboard', compact('user', 'userActivities'));
    }

    public function events()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $events = Event::with('participants')->latest()->paginate(12);

        try {
            Artisan::call('events:update-registration-status');
        } catch (\Exception $e) {
            // Log the error but don't let it break the page
            \Log::error('Failed to update event registration status: ' . $e->getMessage());
        }

        return view('user.events.view-event', compact('events', 'user'));
    }

    public function eventdetails($event_id)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $event = Event::findOrFail($event_id);
        if (!$event) {
            return redirect()->route('user.events')->with('error', 'Event not found.');
        }

        $registrationStatus = $user->eventUsers()->where('event_id', $event->id)->first();

        return view('user.events.event-details', compact('event', 'registrationStatus'));
    }

    public function participate(Event $event)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if event exists and is valid
        if (!$event || !$event->exists) {
            return redirect()->route('user.events')
                ->with('error', 'Invalid event specified.');
        }

        // Check existing registration
        if ($user->eventUsers()->where('event_id', $event->id)->exists()) {
            return redirect()->route('user.event.details', $event->id)
                ->with('error', 'You are already registered for this event.');
        }

        // Load participants relationship and check count
        $participantsCount = $event->participants()->count();

        if ($participantsCount >= $event->participant_limit) {
            return redirect()->route('user.event.details', $event->id)
                ->with('error', 'This event has reached its participant limit.');
        }

        try {
            $event->participants()->attach($user->id);
            return redirect()->route('user.event.details', $event->id)
                ->with('success', 'You have successfully registered for this event.');
        } catch (\Exception $e) {
            \Log::error('Failed to register user for event: ' . $e->getMessage());
            return redirect()->route('user.event.details', $event->id)
                ->with('error', 'An error occurred while registering for the event. Please try again.');
        }
    }

    public function registerEvent($event_id)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $event = Event::find($event_id);
        if (!$event) {
            return redirect()->route('user.events')
                ->with('error', 'The event does not exist.');
        }

        if ($user->eventUsers()->where('event_id', $event->id)->exists()) {
            return redirect()->route('user.event.details', $event->id)
                ->with('error', 'You are already registered for this event.');
        }

        if (!$event->registration_status) {
            return redirect()->route('user.event.details', $event->id)
                ->with('error', 'Registration for this event is closed.');
        }

        // Use participants() relationship method instead of accessing participants directly
        if ($event->participants()->count() >= $event->participant_limit) {
            return redirect()->route('user.event.details', $event->id)
                ->with('error', 'This event has reached its participant limit.');
        }

        try {
            // Attach the user with explicit timestamps
            $event->participants()->attach($user->id, [
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('user.event.details', $event->id)
                ->with('success', 'You have successfully registered for this event.');
        } catch (\Exception $e) {
            \Log::error('Failed to register user for event: ' . $e->getMessage());
            return redirect()->route('user.event.details', $event->id)
                ->with('error', 'An error occurred while registering for the event. Please try again.');
        }
    }

    public function cancelRegistration($eventId)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $event = Event::findOrFail($eventId);
        if (!$event) {
            return redirect()->route('user.events')
                ->with('error', 'Event not found.');
        }

        if (!$user->eventUsers()->where('event_id', $event->id)->exists()) {
            return redirect()->route('user.event.details', ['event_id' => $eventId])
                ->with('error', 'You are not registered for this event.');
        }

        try {
            $user->eventUsers()->detach($event->id);
            return redirect()->route('user.event.details', ['event_id' => $eventId])
                ->with('success', 'Registration canceled successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to cancel event registration: ' . $e->getMessage());
            return redirect()->route('user.event.details', ['event_id' => $eventId])
                ->with('error', 'An error occurred while canceling your registration. Please try again.');
        }
    }

    public function profile()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $userActivities = $user->activityHistories()->latest()->paginate(10);
        $participatedEvents = $user->eventUsers()->with('event')->latest()->paginate(6);

        return view('user.profile.index', compact('user',  'userActivities', 'participatedEvents'));
    }
}