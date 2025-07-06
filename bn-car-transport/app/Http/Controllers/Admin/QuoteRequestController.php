<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Http\Request;

class QuoteRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = QuoteRequest::with('assignedTo')->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by transport type
        if ($request->filled('transport_type')) {
            $query->where('transport_type', $request->transport_type);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $quoteRequests = $query->paginate(15);

        // Get statistics
        $stats = [
            'total' => QuoteRequest::count(),
            'pending' => QuoteRequest::where('status', 'pending')->count(),
            'reviewed' => QuoteRequest::where('status', 'reviewed')->count(),
            'quoted' => QuoteRequest::where('status', 'quoted')->count(),
            'accepted' => QuoteRequest::where('status', 'accepted')->count(),
            'completed' => QuoteRequest::where('status', 'completed')->count(),
        ];

        return view('admin.quote-requests.index', compact('quoteRequests', 'stats'));
    }

    /**
     * Display the specified resource.
     */
    public function show(QuoteRequest $quoteRequest)
    {
        $quoteRequest->load('assignedTo');
        $admins = User::where('role', 'admin')->get();
        
        return view('admin.quote-requests.show', compact('quoteRequest', 'admins'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuoteRequest $quoteRequest)
    {
        $admins = User::where('role', 'admin')->get();
        
        return view('admin.quote-requests.edit', compact('quoteRequest', 'admins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuoteRequest $quoteRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,quoted,accepted,rejected,completed',
            'quoted_price' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string|max:1000',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validated['status'] === 'quoted') {
            $validated['quoted_at'] = now();
        }

        $quoteRequest->update($validated);

        return redirect()->route('admin.quote-requests.show', $quoteRequest)
            ->with('success', 'Quote request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuoteRequest $quoteRequest)
    {
        $quoteRequest->delete();

        return redirect()->route('admin.quote-requests.index')
            ->with('success', 'Quote request deleted successfully.');
    }

    /**
     * Update quote request status
     */
    public function updateStatus(Request $request, QuoteRequest $quoteRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,quoted,accepted,rejected,completed',
        ]);

        $quoteRequest->update($validated);

        return redirect()->back()
            ->with('success', 'Status updated successfully.');
    }

    /**
     * Send quote to customer
     */
    public function sendQuote(Request $request, QuoteRequest $quoteRequest)
    {
        $validated = $request->validate([
            'quoted_price' => 'required|numeric|min:0',
            'quote_details' => 'nullable|string|max:1000',
        ]);

        $quoteRequest->update([
            'quoted_price' => $validated['quoted_price'],
            'admin_notes' => $validated['quote_details'] ?? $quoteRequest->admin_notes,
            'status' => 'quoted',
            'quoted_at' => now(),
        ]);

        // Here you would typically send an email to the customer
        // For now, we'll just update the status

        return redirect()->back()
            ->with('success', 'Quote sent successfully to customer.');
    }

    /**
     * Assign quote to admin
     */
    public function assign(Request $request, QuoteRequest $quoteRequest)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $quoteRequest->update([
            'user_id' => $validated['user_id'],
            'status' => $quoteRequest->status === 'pending' ? 'reviewed' : $quoteRequest->status,
        ]);

        return redirect()->back()
            ->with('success', 'Quote request assigned successfully.');
    }

    /**
     * Get quote request statistics
     */
    public function stats()
    {
        $stats = [
            'today' => QuoteRequest::whereDate('created_at', today())->count(),
            'this_week' => QuoteRequest::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => QuoteRequest::whereMonth('created_at', now()->month)->count(),
            'conversion_rate' => $this->getConversionRate(),
            'avg_response_time' => $this->getAverageResponseTime(),
        ];

        return response()->json($stats);
    }

    /**
     * Calculate conversion rate
     */
    private function getConversionRate()
    {
        $total = QuoteRequest::count();
        $accepted = QuoteRequest::where('status', 'accepted')->count();
        
        return $total > 0 ? round(($accepted / $total) * 100, 2) : 0;
    }

    /**
     * Calculate average response time
     */
    private function getAverageResponseTime()
    {
        $quotes = QuoteRequest::whereNotNull('quoted_at')->get();
        
        if ($quotes->isEmpty()) {
            return 0;
        }

        $totalHours = $quotes->sum(function($quote) {
            return $quote->quoted_at->diffInHours($quote->created_at);
        });

        return round($totalHours / $quotes->count(), 1);
    }
}
