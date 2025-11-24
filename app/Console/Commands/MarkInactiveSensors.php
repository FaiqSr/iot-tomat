<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sensor;
use Carbon\Carbon;

class MarkInactiveSensors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sensors:mark-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark sensors as inactive if no data received within the last minute';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Running sensor inactivity check...');

        $threshold = Carbon::now('Asia/Jakarta')->subMinute();

        // Mark sensors as inactive where last_seen_at is older than threshold
        $affected = Sensor::where('status', 'active')
            ->where(function ($q) use ($threshold) {
                $q->whereNull('last_seen_at')
                  ->orWhere('last_seen_at', '<', $threshold);
            })->update(['status' => 'inactive']);

        $this->info("Marked {$affected} sensors as inactive.");

        return Command::SUCCESS;
    }
}
