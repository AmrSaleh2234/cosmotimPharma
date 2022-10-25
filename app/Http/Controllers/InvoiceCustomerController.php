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
        $invoices = invoice_customer::all();//com code required
        return view('customer_invoice.index', compact('invoices'));

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

            if (count($product->inventory) > 0) {
                $sum = 0;
                foreach ($product->inventory as $inv) {
                    $sum += $inv->quantity;
                }
                $product->total_quantity = $sum;

                array_push($data, $product);
            }


        }

        return view('customer_invoice.create', compact('account', 'data'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, customer $account)
    {
        $i = 0;
        $total_before = 0;
        $total_after = 0;
        $profit = 0;
        $id_invoice = 1;

        if (invoice_customer::all()->last()) {
            $id_invoice = invoice_customer::all()->last()->id + 1;
        }
        foreach ($request->products_id as $id) {
            $product = product::find($id);
            $quantity = $request->quantities[$i];
            $total_before += $product->price_after * $quantity;
            $total_after += ($product->price_after * $quantity) - ($product->price_after * $quantity * ($request->discount[$i] / 100));
            $quantity *= -1;
            foreach ($product->inventory as $inv) {

                $val = $inv->quantity + $quantity;
                if ($val >= 0) { //batch product sastifiy

                    $price_after_discount = ($product->price_after * ($quantity * -1)) - ($product->price_after * ($quantity * -1) * ($request->discount[$i] / 100));
                    $profit += $price_after_discount - ($inv->price_before * ($quantity * -1));
                    if($price_after_discount - ($inv->price_before * ($quantity * -1)) < 0)
                    {
                        return redirect()->back()->with('error','نسبة الخصم المكتوبة في المنتج تجعلك تخسر ');
                    }
                    if ($val == 0) {
                        $inv->update(['quantity' => $val]);
                        $inv->delete();
                    } else {
                        $inv->update(['quantity' => $val]);
                    }
                    order_customer::create([
                        'invoice_customer_id' => $id_invoice,
                        'inventory_id' => $inv->id,
                        'quantity' => ($quantity * -1),
                        'price_before_discount' => $product->price_after * ($quantity * -1),
                        'price_after_discount' => $price_after_discount,
                        'discount' => $request->discount[$i]

                    ]);


                    break;
                } else {// inv not quantity sastify
                    $price_after_discount= ($product->price_after * ((-1 * $quantity) + $val)) - ($product->price_after * ((-1 * $quantity) + $val) * ($request->discount[$i] / 100));
                    $profit +=  $price_after_discount-($inv->price_before * ((-1 * $quantity) + $val));
                    if ($price_after_discount-($inv->price_before * ((-1 * $quantity) + $val)) < 0 )
                    {
                        return redirect()->back()->with('error','نسبة الخصم المكتوبة في المنتج تجعلك تخسر ');

                    }
                    order_customer::create([
                        'invoice_customer_id' => $id_invoice,
                        'inventory_id' => $inv->id,
                        'quantity' => (-1 * $quantity) + $val,
                        'price_before_discount' => $product->price_after * ((-1 * $quantity) + $val),
                        'price_after_discount' =>$price_after_discount,
                        'discount' => $request->discount[$i]

                    ]);

                    $quantity = $val;
                    $inv->update(['quantity' => '0']);
                    $inv->delete();
                }

            }//end for each inv
            $i++;
        }
        $total_after -= ($request->invoice_discount / 100) * $total_after;
        invoice_customer::create(['customer_id' => $account->id, 'discount' => $request->invoice_discount
            , 'total_before' => $total_before, 'total_after' => $total_after, 'created_by' => auth()->user()->name,
            'profit' => $profit,
            'payed' => 0
        ]);
        $status=2;
        if ($account->balance+$total_after>0)
        {
            $status=3;
        }
        elseif ($account->balance+$total_after<0)
        {
            $status=1;
        }
        $account->update(['balance'=>$account->balance+$total_after,'balance_status'=>$status]);


        return redirect()->back()->with(['success' => 'تم ضافة الفاتورة بنجاح']);
    }

    public function orderDetails(invoice_customer $invoice)
    {
        $order = $invoice->order;

        return view('customer_invoice._productOrder', compact('order', 'invoice'));
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
    public function edit(invoice_customer $invoice)
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
        return view('customer_invoice.edit',compact('invoice','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\invoice_customer $invoice_customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_customer $invoice)
    {
        $id_invoice=$invoice->id;
        $account_id=$invoice->customer->id;
        $totalBeforDelete=$invoice->total_after;

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
        $status=2;
        if ($invoice->customer->balance-$totalBeforDelete >0)
        {
            $status=3;
        }
        elseif ($invoice->customer->balance-$totalBeforDelete<0)
        {
            $status=1;
        }
        $invoice->customer->update(['balance'=>$invoice->customer->balance-$totalBeforDelete,'balance_status'=>$status]);

        $invoice->inventory()->detach(); // delete pivot
        $invoice->delete();
        $i = 0;
        $total_before = 0;
        $total_after = 0;

        $profit = 0;

        foreach ($request->products_id as $id) {
            $product = product::find($id);
            $quantity = $request->quantities[$i];
            $total_before += $product->price_after * $quantity;
            $total_after += ($product->price_after * $quantity) - ($product->price_after * $quantity * ($request->discount[$i] / 100));
            $quantity *= -1;
            foreach ($product->inventory as $inv) {

                $val = $inv->quantity + $quantity;
                if ($val >= 0) { //batch product sastifiy

                    $price_after_discount = ($product->price_after * ($quantity * -1)) - ($product->price_after * ($quantity * -1) * ($request->discount[$i] / 100));
                    $profit += $price_after_discount - ($inv->price_before * ($quantity * -1));
                    if($price_after_discount - ($inv->price_before * ($quantity * -1)) < 0)
                    {
                        return redirect()->back()->with('error','نسبة الخصم المكتوبة في المنتج تجعلك تخسر ');
                    }
                    if ($val == 0) {
                        $inv->update(['quantity' => $val]);
                        $inv->delete();
                    } else {
                        $inv->update(['quantity' => $val]);
                    }
                    order_customer::create([
                        'invoice_customer_id' => $id_invoice,
                        'inventory_id' => $inv->id,
                        'quantity' => ($quantity * -1),
                        'price_before_discount' => $product->price_after * ($quantity * -1),
                        'price_after_discount' => $price_after_discount,
                        'discount' => $request->discount[$i]

                    ]);


                    break;
                } else {// inv not quantity sastify
                    $price_after_discount= ($product->price_after * ((-1 * $quantity) + $val)) - ($product->price_after * ((-1 * $quantity) + $val) * ($request->discount[$i] / 100));
                    $profit +=  $price_after_discount-($inv->price_before * ((-1 * $quantity) + $val));
                    if ($price_after_discount-($inv->price_before * ((-1 * $quantity) + $val)) < 0 )
                    {
                        return redirect()->back()->with('error','نسبة الخصم المكتوبة في المنتج تجعلك تخسر ');

                    }
                    order_customer::create([
                        'invoice_customer_id' => $id_invoice,
                        'inventory_id' => $inv->id,
                        'quantity' => (-1 * $quantity) + $val,
                        'price_before_discount' => $product->price_after * ((-1 * $quantity) + $val),
                        'price_after_discount' =>$price_after_discount,
                        'discount' => $request->discount[$i]

                    ]);

                    $quantity = $val;
                    $inv->update(['quantity' => '0']);
                    $inv->delete();
                }

            }//end for each inv
            $i++;
        }
        $total_after -= ($request->invoice_discount / 100) * $total_after;

        invoice_customer::create(['id'=>$id_invoice,'customer_id' => $account_id, 'discount' => $request->invoice_discount
            , 'total_before' => $total_before, 'total_after' => $total_after,'created_by'=>$invoice->created_by ,'updated_by' => auth()->user()->name,
            'profit' => $profit,
            'payed' => 0
        ]);

        $status=2;
        if ($invoice->customer->balance+$total_after >0)
        {
            $status=3;
        }
        elseif ($invoice->customer->balance+$total_after<0)
        {
            $status=1;
        }
        $invoice->customer->update(['balance'=>$invoice->customer->balance+$total_after,'balance_status'=>$status]);


        return redirect()->back()->with(['success' => 'تم نعديل الفاتورة بنجاح']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\invoice_customer $invoice_customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice_customer $invoice)
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
