@if(count($invoice->exchangeRevenue)>0)
    <div class="table-responsive">
        <table class="table mg-b-0 text-md-nowrap">
            <thead>
            <tr>
                <th>#</th>
                <th>التاريخ</th>
                <th>النقدية</th>
                <th>حذف</th>
                @php
                    $i=0
                @endphp
            </tr>
            </thead>
            <tbody id="tbody">
            @foreach($invoice->exchangeRevenue as $item)
                <tr>
                    <td>{{++$i}}</td>
                    <td>{{ $item->created_at->format(' H:i || Y-m-d') }}</td>
                    <td>{{$item->amount}}</td>
                    <td>
                        <button class="btn btn-danger-gradient ml-2 btn-fixed"
                                onclick="getElementById('delete_invoice_customer').submit()"><i
                                class="mdi mdi-delete-empty tx-20 "></i></button>
                        <form id="delete_invoice_customer" method="post"
                              action="{{ route('invoice_customer.destroy', $item) }}"
                              style="display: none">
                            @csrf
                        </form>
                    </td>

                </tr>
            @endforeach

            </tbody>

        </table>
    </div>
@else
    لا يوجد نقدية بعد
@endif
