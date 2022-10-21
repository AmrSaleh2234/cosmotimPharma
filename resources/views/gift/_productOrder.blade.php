
<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
        <tr>

            <th>اسم المنتج</th>
            <th>الكمية</th>
            <th>السعر </th>
        </tr>
        </thead>
        <tbody id="tbody">
        @foreach($order as $item)
            <tr>
                <td>{{$item->product->name}}</td>
                <td>{{$item->pivot->quantity}}</td>
                <td class="text-success">{{$item->pivot->total}}</td>
            </tr>
        @endforeach

        </tbody>

    </table>
</div>
<hr>




<div class="mt-3">
    <span>المجموع: </span> <span id="total" class="text-success"> {{$invoice->total}}جم </span>
</div>




