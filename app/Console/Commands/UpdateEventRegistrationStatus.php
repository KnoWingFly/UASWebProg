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
            if ($event->registration_start && $event->registration_end) {
                $registrationStart = Carbon::parse($event->registration_start)->subHours(7);  
                $registrationEnd = Carbon::parse($event->registration_end)->subHours(7);  

                if ($currentDateTime->gte($registrationStart) && $currentDateTime->lte($registrationEnd)) {
                    $event->registration_status = 'open';
                } else {
                    $event->registration_status = 'closed';
                }
            } else {
                $event->registration_status = 'closed';
            }

            $event->save();
        }

        $this->info('Event registration statuses have been updated successfully.');
    }
}
