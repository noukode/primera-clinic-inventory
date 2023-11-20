<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrderDetail;
use App\Http\Requests\StorePurchaseOrderDetailRequest;
use App\Http\Requests\UpdatePurchaseOrderDetailRequest;

class PurchaseOrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseOrderDetailRequest $request, PurchaseOrderDetail $purchaseOrderDetail)
    {
        //
    }

    public function store()
    {
        $item = PurchaseOrderDetail::where('purchase_order_id', request('purchase_order_id'))->where('item_id', request('item_id'))->first();
        if($item){
            $item->qty += request('qty');
            $item->price = request('price');
            $item->save();
        }else{
            PurchaseOrderDetail::create([
                'purchase_order_id' => request('purchase_order_id'),
                'item_id' => request('item_id'),
                'qty' => request('qty'),
                'price' => request('price'),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'error' => 0,
            'message' => 'Success'
        ]);
    }

    public function get_by_po()
    {
        $data = PurchaseOrderDetail::with(['item.category', 'item.unit'])->where('purchase_order_id', request('purchase_order_id'))->get();
        return response()->json([
            'status' => 'success',
            'error' => 0,
            'message' => 'Success',
            'data' => $data
        ]);
    }

    public function destroy()
    {
        PurchaseOrderDetail::where('id', request('id'))->delete();
        return response()->json([
            'status' => 'success',
            'error' => 0,
            'message' => 'Success'
        ]);
    }
}
