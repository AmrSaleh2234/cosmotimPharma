<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Models\product;
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
        $product=product::where('com_code',auth()->user()->com_code)->get();
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
        product::create([
            'name' => $request->product_name,
            'com_code'=>auth()->user()->com_code,
            'created_by' => auth()->user()->name,
            'price_after'=>$request->price_after,
            'active'=>1
        ]);
        return redirect()->back()->with('success','تم اضافة المنتج بجاح ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $prodcut
     * @return \Illuminate\Http\Response
     */
    public function show(product $prodcut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $prodcut
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreProduct $request)
    {
        $request->validated();
        product::where('id', $request->id)->where('com_code',auth()->user()->com_code)->update(['name'=>$request->product_name,'price_after'=>$request->price_after,'updated_by'=>auth()->user()->name]);


        return redirect()->back()->with('success','تم التعديل بنجاح ');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $prodcut
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $prodcut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $prodcut
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
        $product=product::where('id',$request->id)->where('com_code',auth()->user()->com_code)->first();
        if ($product->active == 1)
        {
            $product->update(['active'=>0]);
            return redirect()->back()->with('success','تم التعطيل بنجاح ');
        }
        $product->update(['active'=>1]);
        return redirect()->back()->with('success','تم التفعيل بنجاح ');

    }
    public function destroy(Request $prodcut)
    {
        product::find($prodcut->id)->delete();
        return redirect()->back()->with('success','تم الحذف بنجاح ');
    }
}
