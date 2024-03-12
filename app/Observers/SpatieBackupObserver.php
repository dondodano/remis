<?php

namespace App\Observers;

use App\Models\SpatieBackup;

class SpatieBackupObserver
{
    /**
     * Handle the SpatieBackup "created" event.
     */
    public function created(SpatieBackup $spatieBackup): void
    {
        activity()
            ->performedOn($spatieBackup)
            ->log("created a backup")
            ->causedBy(auth()->user());
    }

    /**
     * Handle the SpatieBackup "updated" event.
     */
    public function updated(SpatieBackup $spatieBackup): void
    {
        //
    }

    /**
     * Handle the SpatieBackup "deleted" event.
     */
    public function deleted(SpatieBackup $spatieBackup): void
    {
        if (! $spatieBackup->isForceDeleting())
        {
            activity()
            ->performedOn($spatieBackup)
            ->log("soft deleted a backup")
            ->causedBy(auth()->user());
        }
    }

    /**
     * Handle the SpatieBackup "restored" event.
     */
    public function restored(SpatieBackup $spatieBackup): void
    {
        activity()
            ->performedOn($spatieBackup)
            ->log("restored a backup")
            ->causedBy(auth()->user());
    }

    /**
     * Handle the SpatieBackup "force deleted" event.
     */
    public function forceDeleted(SpatieBackup $spatieBackup): void
    {
        activity()
            ->performedOn($spatieBackup)
            ->log("force deleted a backup")
            ->causedBy(auth()->user());
    }
}
