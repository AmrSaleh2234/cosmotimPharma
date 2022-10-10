<?php

namespace App\Http\Controllers;

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
        return view('product.index');
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
    public function store(Request $request)
    {
        //
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
    public function edit(prodcut $prodcut)
    {
        //
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
    public function destroy(prodcut $prodcut)
    {
        //
    }
}
