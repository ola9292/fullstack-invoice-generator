<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\PricingController;
use App\Mail\SignUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Cashier\Http\Controllers\WebhookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');
// Route::get('/signup', function () {
//     return Inertia::render('Form/Signup');
// });
Route::post('stripe/webhook', [WebhookController::class, 'handleWebhook']);

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'saveUser']);
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::get('polls', [PollController::class, 'index'])->name('poll.index');
    Route::get('poll/create', [PollController::class, 'create'])->name('poll.create')->middleware('subscribed');
    Route::post('poll/create', [PollController::class, 'store'])->name('poll.store')->middleware('subscribed');
    Route::get('poll/{slug}', [PollController::class, 'show'])->name('poll.show');
    Route::post('vote', [PollController::class, 'storeVote'])->name('poll.vote');
    Route::get('poll/{id}/result', [PollController::class, 'showResult'])->name('poll.result');

    // invoice
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('invoice/create', [InvoiceController::class, 'create'])->name('invoice.create')->middleware('paid');
    Route::post('invoice/create', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('invoice/{invoice_number}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::post('invoice/{id}/delete', [InvoiceController::class, 'destroy'])->name('invoice.destroy');

    // pricing/stripe
    // Route::get('/pricing', [PricingController::class, 'pricing'])->name('billing.plan');
    // Route::get('/checkout/{name}', [PricingController::class, 'checkout'])->name('billing.checkout');
    // Route::get('/checkout-success', [PricingController::class, 'success'])->name('checkout.success');
    // Route::get('/checkout-cancel', [PricingController::class, 'cancel'])->name('checkout.cancel');

    Route::post('/payment', [PaymentController::class, 'makePayment'])->name('payment');
    Route::get('/success', [PaymentController::class, 'success'])->name('success');
    Route::get('/cancel', [PaymentController::class, 'cancel'])->name('cancel');

    Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth');
});
// Route::post('/signup', function (Request $request) {
//     // User::create();

//     $rules = [
//         'first_name' => ['required', 'max:50'],
//         'last_name' => ['required', 'max:50'],
//         'email' => ['required', 'max:50', 'email'],
//         'agree_terms' => ['accepted'],
//         'age_range' => ['required'],
//     ];
//     if ($request->age_range === 'over-18') {
//         $rules['consent'] = ['required', 'accepted'];
//     }
//     $data = $request->validate($rules);
//     Mail::to('okaz692@gmail.com')->send(new SignUp($data));
//     dd($request->all());
// });

Route::get('/send-invoice/{number}', function (Request $request, $number) {
    // dd($number);
    $data = \App\Models\Invoice::where('invoice_number', $number)->first();
    // dd($data->to_email);
    $email = $data->to_email;
    Mail::to($email)->send(new \App\Mail\SendInvoice($data));

    return redirect()->route('invoice.index')->with('message', 'Invoice sent');
});
