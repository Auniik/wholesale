<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryProductResource;
use App\Models\InventoryProduct;
use App\Models\InventoryProductPurchase;
use App\Models\InventoryProductSale;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InventoryReportController extends Controller
{
    public function productWiseInventory(Request $request)
    {
        if ($request->ajax()){
            if ($request->get('name')){
                return InventoryProductResource::collection(
                    InventoryProduct::query()
                        ->orderBy('name', 'ASC')
                        ->where('name', 'like', "%{$request->get('name')}%")
                        ->get()
                );
            }
        }
        $products = InventoryProduct::orderBy('name', 'ASC')
            ->where('company_id', company_id())
            ->paginate(25);
        return view('pharmacy.reports.index', compact('products'));
    }



    public function customerWiseSales()
    {
        $dateRange = [
            'fromDate' => \request()->fromDate ?? date('Y-m-d'),
            'toDate' => \request()->toDate ?? date('Y-m-d'),
        ];
        return view('pharmacy.reports.sales.patient-wise', [
            'company' => auth()->user()->companyInfo,
            'sales' => InventoryProductSale::where('company_id', company_id())
                ->whereBetween('date', $dateRange)
                ->groupBy('patient_id')
                ->get()
        ]);
    }




    public function productWiseSales(Request $request)
    {
        $sales = InventoryProductSale::where('company_id', company_id())
            ->whereBetween('date', dateRange());

        if ($request->filled('product_id')){
            $sales->with(['report' => function ($query)use($request){
                $query->where('inventory_product_purchase_items.product_id', $request->product_id);
            }]);
        }
        return view('pharmacy.reports.sales.product-wise', [
            'company' => auth()->user()->companyInfo,
            'sales' => $sales->paginate()
        ]);
    }


    public function productWisePurchase(Request $request)
    {
        $purchase = InventoryProductPurchase::where('company_id', company_id())
                        ->whereBetween('date', dateRange());

        if ($request->filled('product_id')){
            $purchase->with(['report' => function ($query)use($request){
                $query->where('inventory_product_purchase_items.product_id', $request->product_id);
            }]);
        }

        return view('pharmacy.reports.purchase.product-wise', [
            'company' => auth()->user()->companyInfo,
            'purchases' => $purchase->paginate()
        ]);
    }


    public function stockAlertReports()
    {
        return view('pharmacy.reports.stock', [
            'products' => InventoryProduct::where('company_id', company_id())
                ->whereRaw('stock_limitation >= retail_quantity')
                ->paginate(),

            'company' => auth()->user()->companyInfo,
        ]);
    }
}
