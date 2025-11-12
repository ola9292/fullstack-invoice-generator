<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PricingController extends Controller
{
    public function pricing()
    {
        return Inertia::render('Plans');
    }

    public function checkout(Request $request, $name)
    {
        // dd($name);
        if ($name == 'free') {
            return to_route('poll.index');
        }
        // dd($name);
        $plan = Plan::where('name', $name)->first();
        $plan_price = $plan->stripe_price_id;

        // dd($request->all());
        return $request->user()
            ->newSubscription('default', $plan_price)
            ->allowPromotionCodes()
            ->checkout([
                'success_url' => route('checkout.success'),
                'cancel_url' => route('checkout.cancel'),
            ]);
    }

    public function success(Request $request)
    {
        return Inertia::render('CheckoutSuccess');
    }

    public function cancel(Request $request)
    {
        return Inertia::render('CheckoutCancel');
    }
}
