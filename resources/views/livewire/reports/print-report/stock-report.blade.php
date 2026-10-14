<div>
    <!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{$lang->data['sales_report'] ?? 'Sales Report'}}</title>
        <link href="https://fonts.googleapis.com/css?family=Calibri:400,700,400italic,700italic">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap"
            rel="stylesheet">
        <script src="{{ asset('assets/vendors/font-awesome/css/font-awesome.css') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" crossorigin="anonymous"></script>
        <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
        <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.min28b5.css?v=2.0.0') }}" rel="stylesheet" />
        <link id="pagestyle" href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    </head>
    <body onload="">
        <div class="mb-4 row align-items-center justify-content-between">
        </div>
        <div class="row">
            <div class="col-12">
                <h5 class="fw-500">{{$lang->data['stock_report'] ?? 'Stock Report'}}</h5>
            </div>
             
            <div class="col-12">
                <div class="mb-4 shadow-none card">
                    <div class="p-4 card-header">
                    </div>
                    <div class="p-0 card-body">
                        <div class="">
                            <table class="table mb-0 align-items-center">
                                <thead>
                                    <tr class="table-dark">
                                        <th class="text-xs text-uppercase ">{{$lang->data['#'] ?? '#'}}</th>
                                        <th class="text-xs text-uppercase ">{{$lang->data['product_name'] ?? 'Product Name'}}</th>
                                        <th class="text-xs text-uppercase ">{{$lang->data['available_stock'] ?? 'Available Stock'}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $row)
                                        <tr>
                                            <td>
                                                <p class="px-3 mb-0 text-xs">
                                                    {{ $loop->index + 1 }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="px-3 mb-0 text-xs">
                                                    <span class="font-weight-bold">{{ $row->name }}</span>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="px-3 mb-0 text-xs font-weight-bold">
                                                    {{ $row->current_stock }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="px-4 pt-5 mb-3 row align-items-center">
                            <div class="col">
                                <span class="mb-0 text-sm fw-500">{{$lang->data['total_products'] ?? 'Total Products'}}:</span>
                                <span class="mb-0 text-sm text-dark ms-2 fw-600">{{ count($products) }}</span>
                            </div>
                            <div class="col">
                                <span class="mb-0 text-sm fw-500">{{$lang->data['available_stock'] ?? 'Available Stock'}}:</span>
                                <span
                                    class="mb-0 text-sm text-dark ms-2 fw-600">{{($products->sum('current_stock'))}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
</div>
<script type="text/javascript">
 "use strict";
    window.onload = function() {
        window.print();
        setTimeout(function() {
            window.close();
        }, 1);
    }
</script>