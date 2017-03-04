<?php

namespace App\Jobs;

use App\User;
use App\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ScrapperController;

class ApproveRequests implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->user->username || !$this->user->pass) return;

        $nicknames = $this->user->followers()
            ->select('follower_username')
            ->where('status', '=', SubscriptionController::STATUS_PENDING_ACTIVE)
            ->get();

        if (!$nicknames) return;

        $nicknames = array_flatten($nicknames->toArray());

        if(count($nicknames) <= 0) return;

        $controller = new ScrapperController();
        $controller->follow($this->user->id, $this->user->username, decrypt($this->user->pass), $nicknames);
    }
}
