<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket de Venta</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            text-align: center; /* Centra todo el texto en el body */
        }
        .ticket {
            width: 300px;
            margin: 0 auto;
            text-align: center;
            padding: 0;
        }
        .header, .footer {
            margin-bottom: 0;
            padding: 0;
        }
        .items table {
            width: 100%;
            border-collapse: collapse;
        }
        .items th, .items td {
            border: 0px solid black;
            padding: 2px;
        }
        .items th {
            text-align: left;
        }
        .items td.quantity {
            text-align: center;
        }
        .items td.amount {
            text-align: right;
        }
        .header h1, .header h6, .header h3, .header h4 {
            margin: 0;
            padding: 0;
            line-height: 1;
        }
        .header span {
            display: block;
            margin: 0;
            padding: 0;
        }
        .header p {
            margin: 0;
            padding: 0;
        }
        .footer p {
            margin: 10px 0 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <span><img src="{{ asset('template/assets/images/kfe-full.png') }}" alt="" height="166px"></span>
            <span>1149-PLAZA LAS FLORES</span>
            <span>AV. HERMANOS PANIAGUA LOCAL 45</span>
            <span>COL. INSURGENTES, SAN CRISTOBAL DE LAS CASAS</span>
            <span>CHIAPAS, CP. 29240</span>
            <span>918 - 123 - 93 - 90</span>
            <h3>Ticket de Venta</h3>
        </div>
        <div class="items">
            <table width="100%">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio/unit</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale_detail as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td class="quantity">{{ $product->quantity }}</td>
                            <td class="amount">{{ _currencyFormat_($product->price) }}</td>
                            <td class="amount">{{ _currencyFormat_($product->total) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="amount"><strong>Sub-total:</strong></td>
                        <td class="amount"><strong>{{ _currencyFormat_($sale_amount_subtotal) }}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="amount"><strong>IVA(16%):</strong></td>
                        <td class="amount"><strong>{{ _currencyFormat_($sale_amount_iva) }}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="3"class="amount"><strong>Total:</strong></td>
                        <td class="amount"><strong>{{ _currencyFormat_($sale_amount_total) }}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="3"class="amount"><strong>Pago:</strong></td>
                        <td class="amount"><strong>{{ _currencyFormat_($sale_amount_payment) }}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="3"class="amount"><strong>Cambio:</strong></td>
                        <td class="amount"><strong>{{ _currencyFormat_($sale_amount_change) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>{{ $sale_date }}</p>
            <span>Atendido por: JOSE EDUARDO</span>
            <br>
            <span>KFE - UN MOMENTO DE SABORES</span>
            <br>
            <span>#AmamosElCafe</span>
            <br>
            <span>¡GRACIAS POR SU COMPRA!</span>
        </div>
    </div>
</body>
</html>
