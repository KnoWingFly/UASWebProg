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
        $currentDateTime = Carbon::now();

        $events = Event::all();

        foreach ($events as $event) {
            // Check if start_date and end_date are valid
            if ($event->start_date && $event->end_date) {
                // Convert to Carbon instances
                $startDate = Carbon::parse($event->start_date);
                $endDate = Carbon::parse($event->end_date);

                // Update registration_status based on current time
                if ($currentDateTime->between($startDate, $endDate)) {
                    $event->registration_status = 'open';
                } else {
                    $event->registration_status = 'closed';
                }
            } else {
                // Default to 'closed' if dates are null
                $event->registration_status = 'closed';
            }

            $event->save();
        }

        $this->info('Event registration statuses have been updated successfully.');

        $this->info("Updating registration statuses...");

        foreach ($events as $event) {
            $this->info("Event ID: {$event->id}, Current Status: {$event->registration_status}");

            if ($event->start_date && $event->end_date) {
                $startDate = Carbon::parse($event->start_date);
                $endDate = Carbon::parse($event->end_date);

                if ($currentDateTime->between($startDate, $endDate)) {
                    $event->registration_status = 'open';
                } else {
                    $event->registration_status = 'closed';
                }
            } else {
                $event->registration_status = 'closed';
            }

            $event->save();

            $this->info("Updated Status: {$event->registration_status}");
        }

        $this->info('Update complete.');
    }
}
