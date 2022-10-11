<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Models\prodcut;
use Illuminate\Http\Request;

class ProdcutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=prodcut::where('com_code',auth()->user()->com_code)->get();
        return view('product.index',compact('product'));
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
    public function store(StoreProduct $request)
    {
       $request->validated();
        prodcut::create([
            'name' => $request->product_name,
            'com_code'=>auth()->user()->com_code,
            'created_by' => auth()->user()->name
        ]);
        return redirect()->back()->with('success','تم اضافة المنتج بجاح ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\prodcut  $prodcut
     * @return \Illuminate\Http\Response
     */
    public function show(prodcut $prodcut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\prodcut  $prodcut
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreProduct $request)
    {
        $request->validated();
        prodcut::where('id', $request->id)->update(['name'=>$request->product_name,'updated_by'=>auth()->user()->name]);

        return redirect()->back()->with('success','تم التعديل بنجاح ');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\prodcut  $prodcut
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, prodcut $prodcut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\prodcut  $prodcut
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $prodcut)
    {
        prodcut::find($prodcut->id)->delete();
        return redirect()->back()->with('success','تم الحذف بنجاح ');
    }
}
