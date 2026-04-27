<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('backup:clean-keep {--keep=84 : Number of backups to keep}')]
#[Description('Keep only the last N backups in S3')]
class CleanOldBackups extends Command
{
    public function handle()
    {
        $keep   = (int) $this->option('keep');
        $disk   = Storage::disk('s3');
        $folder = config('app.name');

        // Get all backup zip files sorted oldest first
        $files = collect($disk->files($folder))
            ->filter(fn($f) => str_ends_with($f, '.zip'))
            ->sort()
            ->values();

        $this->info("Found {$files->count()} backups. Keeping last {$keep}.");

        if ($files->count() <= $keep) {
            $this->info("Nothing to delete.");
            return Command::SUCCESS;
        }

        // Delete oldest backups beyond the keep limit
        $toDelete = $files->slice(0, $files->count() - $keep);

        foreach ($toDelete as $file) {
            $disk->delete($file);
            $this->warn("Deleted: {$file}");
        }

        $this->info("Done! Deleted {$toDelete->count()} old backups. {$keep} backups remaining.");

        return Command::SUCCESS;
    }
}
