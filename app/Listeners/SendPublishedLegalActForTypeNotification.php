<?php

namespace App\Listeners;

use App\Events\LegalActPublished;
use App\Notifications\LegalActPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPublishedLegalActForTypeNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LegalActPublished  $event
     * @return void
     */
    public function handle(LegalActPublished $event)
    {
        $subscriptions = $event->legalAct->type->subscriptions()->get();
        $legalAct = $event->legalAct;
        $subscriptions->each(fn ($subscription) => $subscription->user->notify(new LegalActPublishedNotification($legalAct)));

        $legalAct->notificated = 1;
        $legalAct->save();

    }

}
