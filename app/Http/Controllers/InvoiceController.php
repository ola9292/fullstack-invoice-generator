<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function index()
    {
        $current_user_id = auth()->user()->id;
        $invoices = Invoice::where('user_id', $current_user_id)->get();

        return Inertia::render('Invoice/Index', [
            'invoices' => $invoices,
        ]);
    }

    public function create()
    {
        return Inertia::render('Invoice/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|max:50|unique:invoices,invoice_number',
            'date' => 'required|date',
            'from_name' => 'required|string|max:255',
            'from_email' => 'required|email|max:255',
            'to_name' => 'required|string|max:255',
            'to_email' => 'required|email|max:255',
            'logo' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.rate' => 'required|numeric|min:0.5',
            'items.*.amount' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
            'discount_rate' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'sub_total' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
        ]);

        // Create the invoice
        $invoice = Invoice::create([
            'user_id' => Auth::id(),
            'invoice_number' => $validated['invoice_number'],
            'date' => $validated['date'],
            'from_name' => $validated['from_name'],
            'from_email' => $validated['from_email'],
            'to_name' => $validated['to_name'],
            'to_email' => $validated['to_email'],
            'logo' => $validated['logo'] ?? null,
            'items' => $validated['items'], // stored as JSON
            'tax_rate' => $validated['tax_rate'],
            'discount_rate' => $validated['discount_rate'],
            'tax_amount' => $validated['tax_amount'],
            'discount_amount' => $validated['discount_amount'],
            'sub_total' => $validated['sub_total'],
            'total_amount' => $validated['total_amount'],
        ]);

        return redirect()
            ->route('invoice.index', $invoice->id)
            ->with('message', 'Invoice created successfully!');
    }

    public function show(Request $request, $invoice_number)
    {
        $current_user_id = auth()->user()->id;
        $invoice = Invoice::where('invoice_number', $invoice_number)->first();

        return Inertia::render('Invoice/Show', [
            'invoice' => $invoice,
        ]);
    }

    public function destroy(Request $request, $id)
    {

        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()
            ->route('invoice.index')
            ->with('message', 'Invoice deleted successfully!');
    }
}
