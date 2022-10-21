<?php

namespace App\Http\Controllers;

use App\Models\gift;
use App\Models\invoice_customer;
use App\Models\order_customer;
use App\Models\order_gift;
use App\Models\product;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = gift::where('com_code', $this->getAuthData('com_code'))->get();
        return view('gift.index', compact('invoices'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderDetails(gift $invoice)
    {
        $order = $invoice->inventory;

        return view('gift._productOrder', compact('order', 'invoice'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = product::where('com_code', auth()->user()->com_code)->get();
        $data = [];
        foreach ($products as $product) {

            if (count($product->inventory) > 0) {
                $sum = 0;
                foreach ($product->inventory as $inv) {
                    $sum += $inv->quantity;
                }
                $product->total_quantity = $sum;

                array_push($data, $product);
            }
        }

        return view('gift.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $i = 0;
        $id_invoice = 1;

        if (gift::all()->last()) {
            $id_invoice = gift::all()->last()->id + 1;
        }

        $total = 0;

        foreach ($request->products_id as $id) {
            $product = product::find($id);
            $quantity = $request->quantities[$i];

            $quantity *= -1;
            foreach ($product->inventory as $inv) {

                $val = $inv->quantity + $quantity;
                if ($val >= 0) { //batch product sastifiy


                    if ($val == 0) {
                        $inv->update(['quantity' => $val]);
                        $inv->delete();
                    } else {
                        $inv->update(['quantity' => $val]);
                    }
                    order_gift::create([
                        'gift_id' => $id_invoice,
                        'inventory_id' => $inv->id,
                        'quantity' => ($quantity * -1),
                        'total' => ($quantity * -1) * $inv->price_before


                    ]);
                    $total += ($quantity * -1) * $inv->price_before;


                    break;
                } else { // inv not quantity sastify

                    order_customer::create([
                        'invoice_customer_id' => $id_invoice,
                        'inventory_id' => $inv->id,
                        'quantity' => (-1 * $quantity) + $val,
                        'total' => ((-1 * $quantity) + $val) * $inv->price_before
                    ]);
                    $total += ((-1 * $quantity) + $val) * $inv->price_before;

                    $quantity = $val;
                    $inv->update(['quantity' => '0']);
                    $inv->delete();
                }
            } //end for each inv
            $i++;
        }
        gift::create(['id'=>$id_invoice,
            'description' => "hello ",  'total' => $total, 'created_by' => auth()->user()->name, 'com_code' => auth()->user()->com_code


        ]);

        return redirect()->back()->with(['success' => 'تم ضافة الفاتورة بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(gift $invoice)
    {
        $products = product::where('com_code', $this->getAuthData('com_code'))->get();
        $data = [];
        foreach ($products as $product) {

            if (count($product->inventory) > 0) {
                $sum = 0;
                foreach ($product->inventory as $inv) {
                    $sum += $inv->quantity;
                }
                $product->total_quantity = $sum;

                array_push($data, $product);
            }


        }
        return view('gift.edit',compact('invoice','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, gift $invoice)
    {
        $id_invoice=$invoice->id;

        foreach ($invoice->inventory as $order)
        {
            if($order->deleted_at!=null)
            {
                $order->update(['deleted_at'=>null]);
            }
            $order->update([
                'quantity'=>$order->quantity+$order->pivot->quantity
            ]);
        }
        $invoice->inventory()->detach();
        $invoice->delete();
        $i = 0;
        $total = 0;


        foreach ($request->products_id as $id) {
            $product = product::find($id);
            $quantity = $request->quantities[$i];
            $quantity *= -1;
            foreach ($product->inventory as $inv) {

                $val = $inv->quantity + $quantity;
                if ($val >= 0) { //batch product sastifiy

                    
                    if ($val == 0) {
                        $inv->update(['quantity' => $val]);
                        $inv->delete();
                    } else {
                        $inv->update(['quantity' => $val]);
                    }
                    order_gift::create([
                        'gift_id' => $id_invoice,
                        'inventory_id' => $inv->id,
                        'quantity' => ($quantity * -1),
                        'total' => ($quantity * -1) * $inv->price_before


                    ]);
                    $total += ($quantity * -1) * $inv->price_before;


                    break;
                } else {// inv not quantity sastify
        
                    
                    order_customer::create([
                        'invoice_customer_id' => $id_invoice,
                        'inventory_id' => $inv->id,
                        'quantity' => (-1 * $quantity) + $val,
                        'total' => ((-1 * $quantity) + $val) * $inv->price_before
                    ]);
                    $total += ((-1 * $quantity) + $val) * $inv->price_before;

                    $quantity = $val;
                    $inv->update(['quantity' => '0']);
                    $inv->delete();
                }

            }//end for each inv
            $i++;
        }
        gift::create(['id'=>$id_invoice,'description' => "hello ",  'total' => $total, 'created_by' => auth()->user()->name, 'com_code' => auth()->user()->com_code

        ]);

        return redirect()->back()->with(['success' => 'تم نعديل الفاتورة بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(gift $invoice)
    {

        foreach ($invoice->inventory as $order)
        {
            if($order->quantity==0)
            {
                $order->update(['deleted_at'=>null]);
            }
            $order->update([
                'quantity'=>$order->quantity+$order->pivot->quantity
            ]);
        }
    

        $invoice->inventory()->detach();
        $invoice->delete();
        return redirect()->back()->with('success','تم الحذف بنجاح');
    }
}
