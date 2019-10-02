<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\Accounts\Transaction;
use App\Models\AccountSetting;
use App\Models\InventoryProductPurchase;
use App\Models\InventoryProductSale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InventoryPurchasePaymentController extends Controller
{
    public function create(InventoryProductPurchase $invoice)
    {
        return view('pharmacy.payments.purchase.payment', compact('invoice'), [
            'accounts' => AccountSetting::where('fk_company_id', company_id())->where('status',1)->get()
        ]);
    }

    public function index(InventoryProductPurchase $invoice)
    {
        $invoice = $invoice->load('payments');
        return view('pharmacy.payments.purchase.index', compact('invoice'));
    }

    public function store(Request $request, InventoryProductPurchase $invoice)
    {
        $request->validate([
//            'account_id' => 'required',
//            'method_id' => 'required',
            'totalPaid' => 'required|numeric|max:' . $invoice->due
        ]);

        $invoice->payments()->create([
            'amount' =>  $request->totalPaid >= $invoice->due ? $invoice->due : $request->totalPaid,
            'account_id' => defaultAccount(),
        ]);
        return back()->withSuccess('Due Payment Successful');
    }

    public function destroy(Transaction $payment)
    {
        $payment->delete();
        return response([
            'check' => true
        ]);
    }
}
