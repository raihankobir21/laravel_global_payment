<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('payment');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'card_number' => 'required',
            'expiry_date' => 'required',
            'cvv'         => 'required',
            'amount'      => 'required|numeric|min:1',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GLOBALPAY_API_KEY'),
            ])->post(env('GLOBALPAY_API_URL'), [
                'merchant_id' => env('GLOBALPAY_MERCHANT_ID'),
                'card_number' => $request->card_number,
                'expiry_date' => $request->expiry_date,
                'cvv'         => $request->cvv,
                'amount'      => $request->amount,
                'currency'    => 'USD',
                'description' => 'Payment via GlobalPay',
            ]);

            if ($response->successful()) {
                return redirect()->route('payment.form')->with('success', 'Payment Successful!');
            } else {
                return redirect()->route('payment.form')->with('error', 'Payment Failed!');
            }
        } catch (\Exception $e) {
            return redirect()->route('payment.form')->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
