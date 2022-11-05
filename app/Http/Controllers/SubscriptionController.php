<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        if (auth()->user()->subscribed('default')) {
            return redirect()->route('subscriptions.premium');
        }

        return view('subscriptions.checkout', [
            'intent' => auth()->user()->createSetupIntent(),
            'plan' => session()->get('plan'),
        ]);
    }

    public function store(Request $request)
    {
        $plan = session()->get('plan');

        $request->user()
            ->newSubscription('default', $plan->stripe_id)
            ->create($request->token);

        return redirect()->route('subscriptions.premium');
    }

    public function premium()
    {
        return view('subscriptions.premium');
    }

    public function invoices()
    {
        $invoices = auth()->user()->invoices();

        return view('subscriptions.invoices', compact('invoices'));
    }

    public function downloadInvoice(string $invoiceId)
    {
        return auth()
            ->user()
            ->downloadInvoice($invoiceId, [
                'vendor' => config('app.name'),
                'product' => 'Assinatura VIP'
            ]);
    }

    public function resume()
    {
        auth()->user()->subscription('default')->resume();

        return redirect()->route('subscriptions.invoices');
    }

    public function cancel()
    {
        auth()->user()->subscription('default')->cancel();

        return redirect()->route('subscriptions.invoices');
    }
}
