

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota No {{$nId}}</title>
    <base href="https://yonke.ecoverde.mx/"/>
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <link rel="shortcut icon" href="{{ asset('vendor/adminlte/dist/img/logo-yonke-ecoverde.png') }}"/>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css" media="all">
        body { color: #000; }
        #wrapper { max-width: 520px; margin: 0 auto; padding-top: 20px; }
        .btn { margin-bottom: 5px; }
        .table { border-radius: 3px; }
        .table th { background: #f5f5f5; }
        .table th, .table td { vertical-align: middle !important; }
        h3 { margin: 5px 0; }

        @media print {
            .no-print { display: none; }
            #wrapper { max-width: 480px; width: 100%; min-width: 250px; margin: 0 auto; }
            table tfoot { display: table-row-group; }
        }
        tfoot tr th:first-child { text-align: right; }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="receiptData" style="width: auto; max-width: 580px; min-width: 250px; margin: 0 auto;">
        <div class="no-print">
            <div class="alert alert-success">
                <button data-dismiss="alert" class="close" type="button">×</button>
                Venta agregada correctamente                            </div>
        </div>
        <div id="receipt-data">
            <div>
                <div style="text-align:center;">
                    <img src="{{ asset('vendor/adminlte/dist/img/logo-yonke-ecoverde.png') }}" alt="Yonke EcoVerde"><p style="text-align:center;"><strong>Yonke EcoVerde</strong><br>La Paz, BCS<br></p></div>
                <p>
                    Fecha: {{ $venta[0]->fecha_venta }} <br>
                    Venta No/Ref: {{ $venta[0]->id }}<br>
                    Cliente: {{ $venta[0]->customer }} <br>
                    Cajero: {{ $venta[0]->vendedor }} <br>
                </p>
                <div style="clear:both;"></div>
                <table class="table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 50%; border-bottom: 2px solid #ddd;">Descripcion</th>
                        <th class="text-center" style="width: 12%; border-bottom: 2px solid #ddd;">Cantidad</th>
                        <th class="text-center" style="width: 24%; border-bottom: 2px solid #ddd;">Precio</th>
                        <th class="text-center" style="width: 26%; border-bottom: 2px solid #ddd;">Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listItems as $v)
                        <tr>
                            <td>{{ $v->part_name }}</td>
                            <td style="text-align:center;">{{ $v->cantidad }}</td>
                            <td class="text-right">{{ $v->precio }}</td>
                            <td class="text-right">{{ $v->precio }}</td>
                        </tr>
                    @endforeach
                    <tfoot>
                    <tr>
                        <th class="text-left" colspan="2"></th>
                        <th colspan="2" class="text-right"></th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="2">Sub-Total</th>
                        <th colspan="2" class="text-right">$ {{ number_format($venta[0]->subtotal, 2) }}</th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="2">IVA</th>
                        <th colspan="2" class="text-right">$ {{ number_format($venta[0]->iva, 2) }}</th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="2">Total</th>
                        <th colspan="2" class="text-right">$ {{ number_format($venta[0]->total, 2) }}</th>
                    </tr>
                    </tfoot>
                </table>
                <table class="table table-striped table-condensed" style="margin-top:10px;">
                    <tbody>
                    <tr>
                        <td class="text-right">Tipo de Pago:</td>
                        <td>{{ ucfirst($venta[0]->tipo_pago) }}</td>
                        @if ($venta[0]->tipo_pago == 'tarjeta')
                            <td class="text-right">Tarjeta No :</td>
                            <td>{{ $venta[0]->referencia_pago }}</td>
                        @endif
                    </tr>
                    </tbody>
                </table>
                <div class="well well-sm" style="">
                    <div style="text-align: center;">https://yonke.ecoverde.mx</div>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>

        <!-- start -->
        <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
             <hr style="margin: 5px 0">
            <span class="pull-right col-xs-12">
                                <button onclick="window.print();" class="btn btn-block btn-primary">Imprimir</button>                            </span>
            <span class="col-xs-12">
                                <a class="btn btn-block btn-warning" href="{{ url('/ventas') }}">Regresar a la Caja</a>
                            </span>
            <div style="clear:both;"></div>
        </div>
        <!-- end -->
    </div>
</div>
<!-- start -->
<script type="text/javascript">
    var base_url = 'https://yonke.ecoverde.mx/';
    var site_url = 'https://yonke.ecoverde.mx/';
    var dateformat = 'D j M Y', timeformat = 'h:i A';
    var Settings = {"logo":"logo1.png","site_name":"https://yonke.ecoverde.mx/","tel":"+52 624 122 6058","dateformat":"D j M Y","timeformat":"h:i A","language":"spanish","theme":"default","mmode":"0","captcha":"0","currency_prefix":"MXN","default_customer":"1","default_tax_rate":"16%","rows_per_page":"10","total_rows":"30","header":null,"footer":null,"bsty":"3","display_kb":"0","default_category":"1","default_discount":"0","item_addition":"1","barcode_symbology":null,"pro_limit":"10","decimals":"2","thousands_sep":",","decimals_sep":".","focus_add_item":"ALT+F1","add_customer":"ALT+F2","toggle_category_slider":"ALT+F10","cancel_sale":"ALT+F5","suspend_sale":"ALT+F6","print_order":"ALT+F11","print_bill":"ALT+F12","finalize_sale":"ALT+F8","today_sale":"Ctrl+F1","open_hold_bills":"Ctrl+F2","close_register":"ALT+F7","java_applet":"0","receipt_printer":"","pos_printers":"","cash_drawer_codes":"","char_per_line":"42","rounding":"1","pin_code":"abdbeb4d8dbe30df8430a8394b7218ef","purchase_code":"877adf61-1e45-45c1-adb3-42cab57c4ec0","envato_username":"mcoria01","theme_style":"green","after_sale_page":"0","overselling":"1","multi_store":"0","qty_decimals":"2","symbol":"","sac":"0","display_symbol":"0","remote_printing":"1","printer":"1","order_printers":"null","auto_print":"0","local_printers":"1","rtl":"0","print_img":"0","ws_barcode_type":"price","ws_barcode_chars":"13","flag_chars":"1","item_code_start":"2","item_code_chars":"6","price_start":"0","price_chars":"0","price_divide_by":"0","weight_start":"8","weight_chars":"5","weight_divide_by":"100","selected_language":"spanish"};
</script>
<script src="{{ asset('js/jQuery-2.1.4.min.js') }}"></script>
<script src="{{ asset('js/libraries.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/scripts.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#print').click(function (e) {
            e.preventDefault();
            var link = $(this).attr('href');
            $.get(link);
            return false;
        });
    });
</script>

<!-- end -->
</body>
</html>

