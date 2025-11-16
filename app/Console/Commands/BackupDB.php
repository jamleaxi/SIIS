<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BackupDB extends Command
{
    protected $signature = 'backup:db';
    protected $description = 'Backup the database to storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::channel('backup')->info("Backup started at " . now()->toDateTimeString());

        $filename = 'siis_db_' . Carbon::now()->format('YmdHis') . '.sql';
        $path = storage_path("app/backups/{$filename}");

        // Ensure the directory exists
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $db = config('database.connections.mysql');

        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg($db['username']),
            $db['password'],
            escapeshellarg($db['host']),
            escapeshellarg($db['database']),
            escapeshellarg($path)
        );

        $result = null;
        $output = null;
        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("Database backup created: {$filename}");
            Log::channel('backup')->info("Backup created: {$filename}");
            // mail on success
            // Mail::raw("Database backup SUCCEEDED: {$filename}", function ($message) {
            //     $message->to('siis@jrmsu.edu.ph')
            //             ->subject('✅ SIIS Database Backup Success');
            // });
        } else {
            $this->error('Database backup failed.');
            Log::channel('backup')->error("Backup failed at " . now()->toDateTimeString());
            // mail on fail
            // Mail::raw("Database backup FAILED at " . now(), function ($message) {
            //     $message->to('siis@jrmsu.edu.ph')
            //             ->subject('❌ SIIS Database Backup Failed');
            // });
        }
    }
}
