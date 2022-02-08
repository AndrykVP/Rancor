<?php

namespace AndrykVP\Rancor\Audit\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use AndrykVP\Rancor\Audit\Models\EntryLog;
use Throwable;

class CleanEntryLogs implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $uniqueFor = 3600;
    public $tries = 5;

    public function handle(): void
    {
        EntryLog::where('created_at', '<', now()->subYear())->delete();
    }

    public function failed(Throwable $exception): void
    {
        Log::channel('rancor')->warning('Error thrown while attempting to clean the scanner entry changelog: ' . $exception);
    }
}