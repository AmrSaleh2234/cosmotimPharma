<html style="direction: rtl">
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <link rel="license" href="https://www.opensource.org/licenses/mit-license/">
    <style>
        /* reset */
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600&display=swap');


        * {
            border: 0;
            box-sizing: content-box;
            color: inherit;
            font-family: 'Cairo', sans-serif;
            font-size: 16px;
            font-style: inherit;
            line-height: inherit;
            list-style: none;
            margin: 0;
            padding: 0;
            text-decoration: none;
        }

        /* content editable */


        /* heading */

        h1 {
            font: bold 100% sans-serif;
            text-align: center;
            text-transform: uppercase;
        }

        /* table */

        table {
            width: 100%;
        }

        table {
            border-collapse: separate;
            border-spacing: 2px;
        }

        th, td {
            border-width: 1px;
            padding: 0.5em;
            position: relative;
            text-align: right
        }

        th, td {
            border-radius: 0.25em;
            border-style: solid;
        }

        th {
            background: #e1e1e1;
            border-color: #785028;
        }

        td {
            border-color: #DDD;
        }

        /* page */

        html {
            font: 16px/1 'Open Sans', sans-serif;
            overflow: auto;
            padding: 0.5in;
        }

        html {
            background: #999;
            cursor: default;
        }

        body {
            box-sizing: border-box;
            height: 11in;
            margin: 0 auto;
            overflow: hidden;
            padding: 0.5in;
            width: 8.5in;
        }

        body {
            background: #FFF;
            border-radius: 1px;
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding-top: 167px;
        }

        /* header */

        header {
            margin: 0 0 3em;
        }

        header:after {
            clear: both;
            content: "";
            display: table;
        }

        header h1 {
            background: #000;
            border-radius: 0.25em;
            color: #FFF;
            margin: 0 0 1em;
            padding: 0.5em 0;
        }

        header address {
            float: right;
            font-size: 75%;
            font-style: normal;
            line-height: 1.25;
            margin: 0 1em 1em 0;
        }

        header address p {
            margin: 0 0 0.25em;
        }

        header span, header img {
            display: block;
            float: left;
        }

        header span {
            margin: 0 0 1em 1em;
            max-height: 25%;
            max-width: 60%;
            position: relative;
        }

        header img {
            max-height: 100%;
            max-width: 100%;
        }

        header input {
            cursor: pointer;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            height: 100%;
            left: 0;
            opacity: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }

        /* article */

        article, article address, table.meta, table.inventory {
            margin: 0 0 3em;
        }

        article:after {
            clear: both;
            content: "";
            display: table;
        }

        article h1 {
            clip: rect(0 0 0 0);
            position: absolute;
        }

        article address {
            float: right;
            font-size: 125%;
            font-weight: bold;
        }

        /* table meta & balance */

        table.meta, table.balance {
            float: left;
            width: 36%;
        }

        table.meta:after, table.balance:after {
            clear: both;
            content: "";
            display: table;
        }

        /* table meta */

        table.meta th {
            width: 46%;
        }

        table.meta td {
            width: 60%;
        }

        /* table items */

        table.inventory {
            clear: both;
            width: 100%;
        }

        table.inventory th {
            font-weight: bold;
            text-align: center;
        }



        /* table balance */


        /* aside */

        aside h1 {
            border: none;
            border-width: 0 0 1px;
            margin: 0 0 1em;
        }

        aside h1 {
            border-color: #999;
            border-bottom-style: solid;
        }

        /* javascript */

        .add, .cut {
            border-width: 1px;
            display: block;
            font-size: .8rem;
            padding: 0.25em 0.5em;
            float: right;
            text-align: center;
            width: 0.6em;
        }

        .add, .cut {
            background: #9AF;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
            background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
            border-radius: 0.5em;
            border-color: #0076A3;
            color: #FFF;
            cursor: pointer;
            font-weight: bold;
            text-shadow: 0 -1px 2px rgba(0, 0, 0, 0.333);
        }

        .add {
            margin: -2.5em 0 0;
        }

        .add:hover {
            background: #00ADEE;
        }

        .cut {
            opacity: 0;
            position: absolute;
            top: 0;
            left: -1.5em;
        }

        .cut {
            -webkit-transition: opacity 100ms ease-in;
        }

        tr:hover .cut {
            opacity: 1;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact;
            }

            html {
                background: none;
                padding: 0;
            }

            body {
                box-shadow: none;
                margin: 0;
            }

            span:empty {
                display: none;
            }

            .add, .cut {
                display: none;
            }
        }

        @page {
            margin: 0;
        }
    </style>
</head>
<body>

<article>
    <div style="display: flex;">
        <address style="width: 60%">
            <p style="margin-bottom: 16px"> الاسم: {{$invoice->customer->name}} </p>
            <p style="margin-bottom: 19px;line-height: 23px"> العنوان: {{$invoice->customer->address}}  </p>
            <p> الهاتف: {{$invoice->customer->phone}} </p>
        </address>
        <table class="meta"  style="width: 40%">
            <tr>
                <th><span>رقم الفاتورة #</span></th>
                <td><span>{{$invoice->id}}</span></td>
            </tr>
            <tr>
                <th><span>التاريخ</span></th>
                <td><span>{{$invoice->created_at->format('Y/m/d')}}</span></td>
            </tr>

        </table>
    </div>

    <table class="inventory">
        <thead>
        <tr>
            <th><span>الصنف</span></th>
            <th><span>الكمية</span></th>
            <th><span>السعر</span></th>

            <th><span>الخصم</span></th>
            <th><span>الاجمالي</span></th>
            <th><span>سعر الحمهور</span></th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoice->inventory as $item )
            <tr>
                <td><span>{{$item->product->name}}</span></td>
                <td><span>{{$item->pivot->quantity}}</span></td>
                <td><span>{{$item->pivot->price_after_discount/$item->pivot->quantity}}</span><span
                        data-prefix> جم</span></td>
                <td style="color:#0ba360"><span data-prefix>%</span><span>{{$item->pivot->discount}}</span></td>

                <td><span>{{$item->pivot->price_after_discount}}</span><span data-prefix> جم</span></td>
                <td><span>{{$item->product->price_after}}</span><span data-prefix> جم </span></td>

            </tr>
        @endforeach

        </tbody>
    </table>

    <table class="balance">
        <tr>
            <th><span>الاجمالي</span></th>
            <td><span>{{$invoice->total_after}}</span><span data-prefix> جم</span></td>
        </tr>
        @if($invoice->discount !=0)
            <tr>
                <th style="color: #0ba360;font-size: 13px"><span>خصم كلي علي الفاتورة</span></th>
                <td><span data-prefix>%</span><span>{{$invoice->discount}}</span></td>
            </tr>
        @endif

        <tr>
            <th><span>المدفوع</span></th>
            <td><span>{{$invoice->payed}}</span><span data-prefix> جم</span></td>
        </tr>
        <tr>
            <th><span>المستحق</span></th>
            <td style="color: #0a58ca;font-size: 13px"><span>{{$invoice->total_after-$invoice->payed}}</span><span
                    data-prefix> جم</span></td>
        </tr>
    </table>
</article>
<aside>
    <div>
        <p style="font-weight: bold">المرتجعات : تقبل قبل انتهاء الصلاحية بثلاثة اشهر علي ان تكون 10 % من قية الفاتورة.</p>
        <p style="font-weight: bold">المرتجعات : تقبل قبل انتهاء الصلاحية بثلاثة اشهر علي ان تكون 10 % من قية الفاتورة.</p>

    </div>
</aside>

</body>
<script>
    var p = window.print();


</script>
</html>
