
<div class="table-responsive" >
    <table class="table mg-b-0 ">
        <thead>
        <tr>

            <th>اسم المنتج</th>
            <th>الكمية</th>
            <th>الخصم</th>
            <th>السعر قبل</th>
            <th>السعر بعد</th>
        </tr>
        </thead>
        <tbody >
        @foreach($order as $item)
            <tr>
                <td>{{$item->inventory->product->name}}</td>
                <td>{{$item->quantity}}</td>
                <td class="text-primary">%{{$item->discount}}</td>
                <td class="text-danger">{{$item->price_before_discount}}</td>
                <td class="text-success">{{$item->price_after_discount}}</td>
            </tr>
        @endforeach

        </tbody>

    </table>
</div>
<hr>


<div class="mt-3">
    <span>المجموع قبل الخصم: </span> <span id="total" class="text-danger">{{$invoice->total_before}}جم </span>
</div>
@if($invoice->discount!=0)
    <div class="mt-3">
        <span>الخصم علي الفاتورة ككل : </span> <span id="total" class="text-primary">{{$invoice->discount}}%</span>
    </div>
@endif
<div class="mt-3">
    <span>المجموع بعد الخصم: </span> <span id="total" class="text-success"> {{$invoice->total_after}}جم </span>
</div>




