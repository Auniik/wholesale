<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\AccountSetting;
use App\Models\InventoryProductSale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InventoryProductPaymentController extends Controller
{
    public function createSalesPayment(InventoryProductSale $invoice)
    {
        return view('pharmacy.payments.sale.payment', compact('invoice'), [
            'accounts' => AccountSetting::where('fk_company_id', company_id())->where('status',1)->get()
        ]);
    }

    public function salePayments(InventoryProductSale $invoice)
    {
        $invoice = $invoice->load('payments');
        return view('pharmacy.payments.sale.index', compact('invoice'));
    }

    public function storeSalesPayment(Request $request, InventoryProductSale $invoice)
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
}
