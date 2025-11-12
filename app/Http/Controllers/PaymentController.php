<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function makePayment()
    {
        $user = auth()->user();

        if ($user->payment_status == 1) {
            return redirect()->route('home')->with('message', 'You have already paid!');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $price_id = 'price_1SIxPR1DMC7Ht8eGTYbBuZYS';

        $firstName = 'olamide';
        $lastName = 'abass';

        try {
            $checkoutSession = Session::create([
                'line_items' => [[
                    'price' => $price_id,
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
                'metadata' => [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ],
            ]);

            return Inertia::location($checkoutSession->url);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->query('session_id');
        $session = Session::retrieve($sessionId);
        $metadata = $session->metadata;

        if ($session->payment_status === 'paid') {

            $user = auth()->user();

            $user->update([
                'payment_status' => 1,
            ]);

            return Inertia::render('Invoice/ThankYou', [

            ]);
            // return "🎉 {$metadata->first_name} {$metadata->last_name} successfully donated \${$metadata->amount}.";
        }

        return redirect()->route('cancel');
    }

    public function cancel()
    {
        return '❌ Payment canceled.';
    }
}
