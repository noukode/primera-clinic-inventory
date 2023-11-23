<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;
use App\Models\Branch;
use App\Models\PurchaseOrderDetail;
use App\Models\StockType;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Purchase Order';
        $branches = Branch::get();
        $stock_types = StockType::get();
        $purchases = new PurchaseOrder();

        if(request('branch_id')){
            $purchases = $purchases->where('branch_id', request('branch_id'));
        }

        if(request('stock_type_id')){
            $purchases = $purchases->where('stock_type_id', request('stock_type_id'));
        }

        if(request('purchase_status') !== null){
            $purchases = $purchases->where('purchase_status', request('purchase_status'));
        }

        if(request('search')){
            $purchases = $purchases->where('purchase_no', 'LIKE', '%'. request('search') .'%')->orWhere('project_name', 'LIKE', '%'. request('search') .'%');
        }

        $purchases = $purchases->with(['stock_type', 'branch'])->withCount('details')->paginate(15);
        return view('pages.purchase.index',compact('title', 'purchases', 'branches', 'stock_types'));
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
        $new_po = sprintf('%03d', 1) . '/POMUK3PC/' . $this->romawi(date('m')) . '/' . date('Y') ;
        $last_po = PurchaseOrder::where('purchase_no', 'LIKE', '%'. date('Y'))->orderBy('created_at', 'DESC')->first();

        if($last_po){
            $split_last_po = explode('/', $last_po->purchase_no);
            $new_po = sprintf(($split_last_po[0] + 1)) . '/POMUK3PC/' . $this->romawi(date('m')) . '/' . date('Y') ;
        }

        $po = PurchaseOrder::create([
            'purchase_no' => $new_po ,
            'project_name' => $request->project_name,
            'branch_id' => $request->branch_id,
            'stock_type_id' => $request->stock_type_id,
            'purchase_date' => Carbon::now(),
            'purchase_status' => $request->purchase_status,
            'created_by' => auth()->user()->id,
            'known_by' => $request->purchase_status == 1 ? auth()->user()->id : null
        ]);

        // $items = [];
        // foreach ($request->items as $key => $item) {
        //     $items[] = [
        //         'purchase_order_id' => $po->id,
        //         'item_id' => $item->id,
        //         'qty' => $item->qty,
        //         'price' => $item->price
        //     ];
        // }

        // PurchaseOrderDetail::insert($items);

        return redirect()->to(route('purchase-order.edit', $po->id));
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $title = 'Detail Purchase Order';
        $purchaseOrder = $purchaseOrder->with(['details' => function($query){
            return $query->with(['item' => function($query){
                return $query->with(['category', 'unit']);
            }]);
        }])->where('id', $purchaseOrder->id)->first();

        return view('pages.purchase.show', compact('title', 'purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        $title = 'Edit Purchase Order';
        $purchaseOrder = $purchaseOrder->with(['details' => function($query){
            return $query->with(['item' => function($query){
                return $query->with(['category', 'unit']);
            }]);
        }])->where('id', $purchaseOrder->id)->first();
        $branches = Branch::get();
        $stock_types = StockType::get();

        return view('pages.purchase.edit', compact('title', 'purchaseOrder', 'branches', 'stock_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->project_name = $request->project_name;
        $purchaseOrder->branch_id = $request->branch_id;
        $purchaseOrder->stock_type_id = $request->stock_type_id;
        $purchaseOrder->purchase_status = $request->purchase_status;
        if($request->purchase_status == 1){
            $purchaseOrder->known_by = auth()->user()->id;
        }else{
            $purchaseOrder->created_by = auth()->user()->id;
        }
        $purchaseOrder->save();

        return response()->json([
            'status' => 'success',
            'error' => 0,
            'message' => 'Success'
        ]);
    }

    public function approve(Request $request, PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->purchase_status = $request->purchase_status;
        $purchaseOrder->approved_by = auth()->user()->id;
        $purchaseOrder->save();

        return response()->json([
            'status' => 'success',
            'error' => 0,
            'message' => 'Success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }

    public function romawi($angka)
    {
        $arr_roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

        return $arr_roman[$angka-1];
    }

    public function print(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder = $purchaseOrder->with(['details.item', 'branch', 'stock_type', 'created_by_user', 'known_by_user', 'approved_by_user'])->where('id', $purchaseOrder->id)->first();
        $disc = 0;
        $pdf = Pdf::loadView('pages.purchase.print', compact('purchaseOrder', 'disc'));
        // return $pdf->download($purchaseOrder->purchase_no . '.pdf');
        return $pdf->stream();

        // return view('pages.purchase.print', compact('purchaseOrder', 'disc'));
    }
}
