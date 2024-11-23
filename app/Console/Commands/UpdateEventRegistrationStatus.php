<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;

class UpdateEventRegistrationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:update-registration-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the registration status of events dynamically based on dates.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current time in UTC
        $currentDateTime = Carbon::now();  // UTC time by default

        $events = Event::all();

        foreach ($events as $event) {
            // Check if registration_start and registration_end are valid
            if ($event->registration_start && $event->registration_end) {
                // Parse registration start and end times and subtract 7 hours to convert them to UTC
                $registrationStart = Carbon::parse($event->registration_start)->subHours(7);  // Adjust to UTC by subtracting 7 hours
                $registrationEnd = Carbon::parse($event->registration_end)->subHours(7);  // Adjust to UTC by subtracting 7 hours

                // Check if the current time is between the registration start and end dates (inclusive)
                if ($currentDateTime->gte($registrationStart) && $currentDateTime->lte($registrationEnd)) {
                    // Current time is between start and end date, open registration
                    $event->registration_status = 'open';
                } else {
                    // Otherwise, close registration
                    $event->registration_status = 'closed';
                }
            } else {
                // Default to 'closed' if dates are null
                $event->registration_status = 'closed';
            }

            $event->save();
        }

        $this->info('Event registration statuses have been updated successfully.');
    }
}
