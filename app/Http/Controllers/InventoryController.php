<?php

namespace App\Http\Controllers;

use App\Http\Requests\inventoryRequest;
use App\Models\inventory;
use App\Models\prodcut;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory =inventory::where('com_code',auth()->user()->com_code)->get();
        $products = prodcut::where('com_code',auth()->user()->com_code)->get();
        return view('inventory.index',compact('inventory','products'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(inventoryRequest $request)
    {
        $request->validated();
        inventory::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price_before' => $request->price_before,
            'price_after' => $request->price_after,

            ]);
        return redirect()->back()->with('success','لقد تم اضافة المنتج في المخزن');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(inventoryRequest $request)
    {
        $request->validated();
        inventory::where('id', $request->id)->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price_before' => $request->price_before,
            'price_after' => $request->price_after,
            'updated_by'=>auth()->user()->name
        ]);

        return redirect()->back()->with('success','تم التعديل بنجاح ');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $inventory)
    {
        inventory::find($inventory->id)->forceDelete();
        return redirect()->back()->with('success','تم الحذف بنجاح ');
    }
}
