<?php

namespace App\Http\Controllers;

class StripeController extends Controller
{
    public function subCheckout()
    {
        return auth()->user()
            ->newSubscription('default', config("stripe.price_id"))
            ->checkout();
    }

    public function billingPortal()
    {
        return auth()->user()?->redirectToBillingPortal();
    }

    public function freeTrialEnd(){
        return view("free-trial-end");
    }
}
