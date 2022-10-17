<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\invoice_customer;
use App\Models\product;
use Illuminate\Http\Request;

class InvoiceCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(customer $account)
    {
        $products = product::where('com_code', auth()->user()->com_code)->get();
        $data = [];
        foreach ($products as $product) {

            if (count($product->inventory)>0) {
                $sum=0;
                foreach ($product->inventory as $inv)
                {
                    $sum+=$inv->quantity;
                }
                $product->total_quantity=$sum;

                array_push($data, $product);
            }


        }

        return view('customer_invoice.create',compact('account','data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, customer $account)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\invoice_customer $invoice_customer
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_customer $invoice_customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\invoice_customer $invoice_customer
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_customer $invoice_customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\invoice_customer $invoice_customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_customer $invoice_customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\invoice_customer $invoice_customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice_customer $invoice_customer)
    {
        //
    }
}
