<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Absence;
use App\Models\User;
use Carbon\Carbon;

class UpdateUserStatusCommand extends Command
{
    protected $signature = 'user:update-status';
    protected $description = 'Update user status to ready if absence period is over';

    public function handle()
    {
        $now = Carbon::now();
        $absences = Absence::where('end_date', '<', $now)
            ->where('status', 'approved')
            ->get();

        foreach ($absences as $absence) {
            $user = $absence->user;
            if ($user && $user->status === 'absent') {
                $user->status = 'ready';
                $user->save();
            }
        }
        $this->info('User statuses updated successfully.');
    }
}
