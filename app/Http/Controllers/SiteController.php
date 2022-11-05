<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $plans = Plan::with('features')->get();

        return view('home.index', compact('plans'));
    }

    public function createSession(string $planUrl)
    {
        $plan = Plan::where('url', $planUrl)->first();

        if (!$plan) {
            return redirect()->back();
        }

        session()->put('plan', $plan);

        return redirect()->route('subscriptions.checkout');
    }
}
