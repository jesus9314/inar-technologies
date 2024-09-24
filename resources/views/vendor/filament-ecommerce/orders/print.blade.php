<!doctype html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Pedido: {{$model->uuid}}</title>

    <style>
        body, html {
            margin: 0 !important;
            padding: 0 !important;
        }
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #000000;
            padding: 5px;
        }
    </style>
</head>
<body style="text-align: center" onload="window.print()">
<div dir="rtl"  style="margin-left: auto; margin-right:auto; display:block">
    @if(setting('ordering_show_company_logo'))
    <div>
        <img style="width: 100px" src="{{$model->company?->getFirstMediaUrl('logo')}}">
    </div>
    @endif
    @if(setting('ordering_show_company_data'))
        <h3 style="text-align: center; padding: 5px;">{{$model->company?->name}}</h3>
    @else
        <br>
    @endif
    <h3 style="border: 1px solid #000000; text-align: center; padding: 5px;">Pedido:  {{$model->uuid}}</h3>
    <br>
    <p style="margin-top: -15px;">Impreso En: {{\Carbon\Carbon::now()->format('d/m/Y g:i A')}}</p>
    <p style="margin-top: -15px;">Cajero: {{ $model->user?->name }}
    </p>
    <table border="0" style="width: 100%">
        <tbody>
        @if($model->name || $model->phone)
            <tr>
                <th>Facturado A: </th>
                <td>
                    @if($model->name)<span>{{$model->name}}</span>@endif
                    @if($model->phone)<br><span>{{$model->phone}}</span>@endif
                    @if($model->address)<br><span>{{$model->address}}</span>@endif
                    @if($model->city)<br><span>{{$model->city?->name}}</span>@endif
                    @if($model->area)<br><span>{{$model->area?->name}}</span>@endif
                </td>
            </tr>
        @endif
        </tbody>
    </table><br>
    <table style="width: 100%">
        <thead>
        <tr>
            <th>Artículo</th>
            <th>Cantidad</th>
            <th>Total</th>

        </tr>
        </thead>
        <tbody>
        @php $Count = 1 @endphp
        @foreach($model->ordersItems ?? [] as $item)
            <tr>
                <td>
                    <b>{{$item->product->name}} - [{{$item->product->sku}}]
                    </b>
                </td>
                <td>
                    {{$item->qty}}
                </td>
                <td>
                    {!! dollar($item->total) !!}
                </td>
            </tr>
            @php $Count++ @endphp
        @endforeach
        </tbody>
    </table><br>
    <table border="0" style="width: 100%">
        <tbody>
        <tr>
            <th>Subtotal</th>
            <td>{!! dollar(($model->total+$model->discount)-($model->shipping+$model->vat)) !!}</td>
        </tr>
        @if($model->shipping)
            <tr>
                <th>Envío</th>
                <td>{!! dollar($model->shipping) !!}</td>
            </tr>
        @endif
        @if($model->vat)
            <tr>
                <th>IGV</th>
                <td>{!! dollar($model->vat) !!}</td>
            </tr>
        @endif
        @if($model->coupon)
            <tr>
                <th>Cupón de Descuento [{{ $model->coupon->code }}]</th>
                <td>
                    {!! dollar($model->coupon->discount($model->total)) !!}
                </td>
            </tr>
        @endif
        @if($model->discount)
            <tr>
                <th>Descuento</th>
                <td>
                    @if($model->coupon)
                        {!! dollar($model->discount - $model->coupon->discount($model->total)) !!}
                    @else
                        {!! dollar($model->discount) !!}
                    @endif
                </td>
            </tr>
        @endif
        <tr>
            <th>Total</th>
            <td>
                <b>
                    {!! dollar($model->total) !!}
                </b>
            </td>
        </tr>

        @if($model->notes)
            <tr>
                <th>Notas: </th>
                <td>{{$model->notes}}</td>
            </tr>
        @endif

        </tbody>
    </table>
    <br>

    @if(setting('ordering_show_branch_data'))
        <div>{{$model->branch?->name}}</div>
        <div>{{$model->branch?->address}}</div>
        <div><b>{{$model->branch?->phone}}</b></div>
    @endif
    @if(setting('ordering_show_tax_number'))
        <div>REG: {{ $model->company?->tax_number }}</div>
    @endif
    @if(setting('ordering_show_registration_number'))
        <div>TAX: {{ $model->company?->registration_number }}</div>
    @endif
    <hr style="width: 100%">
    <img src="data:image/png;base64,{{\DNS1D::getBarcodePNG((string)$model->uuid, 'C128',1,44,array(1,1,1), true)}}" alt="barcode"  />

</div>
</body>
</html>
