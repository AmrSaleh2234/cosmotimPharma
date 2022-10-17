<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\inventory;
use App\Models\invoice_customer;
use App\Models\order_customer;
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

        return view('customer_invoice..create',compact('account','data'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, customer $account)
    {
        $i=0;
        $total_before=0;
        $total_after=0;
        $id_invoice=invoice_customer::all()->last()->id+1;

        foreach ($request->products_id as $id)
            {
                $product=product::find($id);
                $quantity=$request->quantities[$i];
                $total_before+=$product->price_after*$quantity;
                $total_after+=($product->price_after*$quantity)-($product->price_after*$quantity*($request->discount[$i]/100));
                $quantity*=-1;
                foreach ($product->inventory as $inv)
                {

                    $val=$inv->quantity+$quantity;
                    if($val>=0)
                    {
                        if($val==0)
                        {
                            $inv->update(['quantity'=>$val]);
                            $inv->delete();
                        }
                        else
                        {
                            $inv->update(['quantity'=>$val]);
                        }
                        order_customer::create([
                            'invoice_customer_id'=>$id_invoice,
                            'inventory_id'=>$inv->id,
                            'quantity'=>($quantity*-1),
                            'price_before_discount'=>$product->price_after*($quantity*-1),
                            'price_after_discount'=>($product->price_after*($quantity*-1))-($product->price_after*($quantity*-1)*($request->discount[$i]/100)),
                            'discount'=>$request->discount[$i]

                        ]);


                        break;
                    }
                    else{

                        order_customer::create([
                            'invoice_customer_id'=>$id_invoice,
                            'inventory_id'=>$inv->id,
                            'quantity'=>(-1*$quantity)+$val,
                            'price_before_discount'=>$product->price_after*((-1*$quantity)+$val),
                            'price_after_discount'=>($product->price_after*((-1*$quantity)+$val))-($product->price_after*((-1*$quantity)+$val)*($request->discount[$i]/100)),
                            'discount'=>$request->discount[$i]

                        ]);
                        $quantity=$val;
                        $inv->update(['quantity'=>'0']);
                        $inv->delete();
                    }

                }//end for each inv
                $i++;
            }
        $total_after-=($request->invoice_discount/100)*$total_after;
        invoice_customer::create([ 'customer_id'=>$account->id,'discount'=>$request->invoice_discount
            ,'total_before'=>$total_before,'total_after'=>$total_after]);

        return $request;
    }
//{
//"_token": "trwIVx9bmQia4tvnmFyo9fYPhzMz739O953wE7p8",
//"products_id": [
//"3",
//"4"
//],
//"quantities": [
//"1",
//"1"
//],
//"discount": [
//"5",
//"5"
//],
//"invoice_discount": "10"
//}
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
