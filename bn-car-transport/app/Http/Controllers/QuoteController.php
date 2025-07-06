<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display quote request form
     */
    public function index()
    {
        return view('quote');
    }

    /**
     * Store quote request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'transport_type' => 'required|in:car,bike,both',
            'vehicle_make' => 'nullable|string|max:255',
            'vehicle_model' => 'nullable|string|max:255',
            'vehicle_year' => 'nullable|string|max:4',
            'vehicle_condition' => 'required|in:running,non_running,damaged',
            'pickup_location' => 'required|string|max:255',
            'pickup_city' => 'required|string|max:255',
            'pickup_state' => 'required|string|max:255',
            'pickup_pincode' => 'required|string|max:10',
            'delivery_location' => 'required|string|max:255',
            'delivery_city' => 'required|string|max:255',
            'delivery_state' => 'required|string|max:255',
            'delivery_pincode' => 'required|string|max:10',
            'pickup_date' => 'nullable|date|after:today',
            'service_type' => 'nullable|in:open_carrier,enclosed_carrier,door_to_door,terminal_to_terminal',
            'additional_requirements' => 'nullable|string|max:1000',
        ]);

        $validated['service_type'] = $validated['service_type'] ?? 'open_carrier';

        QuoteRequest::create($validated);

        return redirect()->route('quote.success')
            ->with('success', 'Quote request submitted successfully! We will contact you soon.');
    }

    /**
     * Display success page
     */
    public function success()
    {
        return view('quote-success');
    }
}
