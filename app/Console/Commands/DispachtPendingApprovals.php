<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Http\Controllers\SubscriptionController;
use App\Jobs\ApproveRequests;

class DispachtPendingApprovals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pendings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch jobs to follow pending users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $usersWithPendingApprobal = User::whereHas('followers', function ($query) {
            $query->where('status', '=', SubscriptionController::STATUS_PENDING_ACTIVE);
        })->get();

        foreach ($usersWithPendingApprobal as $key => $user) {
            dispatch(new ApproveRequests($user));
        }
    }
}
