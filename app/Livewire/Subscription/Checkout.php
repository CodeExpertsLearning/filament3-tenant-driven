<?php

namespace App\Livewire\Subscription;

use Livewire\Attributes\{Computed, Layout, On};
use Livewire\Component;

#[Layout('layouts.guest')]
class Checkout extends Component
{
    #[Computed]
    public function user()
    {
        return auth()->user();
    }

    #[On("charge")]
    public function charge($paymentMethod)
    {

        if (!$this->user->subscribed('default'))
            $this->user->newSubscription('default', 'price_1PH4DOLVUytZ8PTC9wKUoD4U')->create($paymentMethod);

        return redirect('/admin');
    }

    public function render()
    {
        return view('livewire.subscription.checkout')
            ->with('intent', $this->user->createSetupIntent());
    }
}
