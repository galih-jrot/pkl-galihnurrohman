<?php
namespace App\Listeners;

use App\Listeners\MergeCartListener;
use Illuminate\Auth\Events\Login;

class MergeCartListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // event->user adalah user yang baru login
        $cartService = new \App\Services\CartService();
        $cartService->mergeCartOnLogin();
    }
    protected $listen = [
        Login::class => [
            MergeCartListener::class,
        ],
    ];
}
