<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;
use App\Models\PurchaseOrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Pending Purchase Order';
        $purchases = new PurchaseOrder();
        if($request->search){
            $purchases = $purchases->where('purchase_no', 'LIKE', '%'. $request->search .'%');
        }
        $purchases = $purchases->paginate(15);
        return view('pages.purchase.index',compact('title', 'purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Purchase Order";
        return view('pages.purchase.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        $po = PurchaseOrder::create([
            'purchase_no' => $request->po_no,
            'purchase_date' => Carbon::now(),
            'purchase_status' => 0,
        ]);

        $items = [];
        foreach ($request->items as $key => $item) {
            $items[] = [
                'purchase_order_id' => $po->id,
                'item_id' => $item->id,
                'qty' => $item->qty,
                'price' => $item->price
            ];
        }

        PurchaseOrderDetail::insert($items);

        return response()->json([
            'status' => 'success',
            'error' => 0,
            'message' => 'Success',
            'data' => $po,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
