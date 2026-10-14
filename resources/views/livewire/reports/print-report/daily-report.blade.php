<div>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{$lang->data['daily_report'] ?? 'Daily Report'}}</title>
        <link href="https://fonts.googleapis.com/css?family=Calibri:400,700,400italic,700italic">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
        <script src="{{ asset('assets/vendors/font-awesome/css/font-awesome.css') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" crossorigin="anonymous"></script>
        <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
        <link id="pagestyle" href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    @vite('resources/css/app.css')
    </head>
    <body onload="">
        <div class="row align-items-center justify-content-between mb-4">
            <div class="col">
                <h5 class="fw-500">{{$lang->data['daily_report'] ?? 'Daily Report'}}</h5>
            </div>
        </div>
        <div class="row p-0">
            <div class="row p-0">
                <div class="col-md-3">
                    <label>{{$lang->data['date'] ?? 'Date'}}: </label>
                    {{ \Carbon\Carbon::parse($today)->format('d/m/Y') }}
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4 shadow-none p-0">
                    <div class="card-header p-4">
                    </div>
                    <div class="card-body p-0 shadow-none">
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table sm-table mb-0 tw-w-full">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-uppercase text-xs">{{$lang->data['particulars'] ?? 'Particulars'}}</th>
                                        <th class="text-uppercase text-xs">{{$lang->data['value'] ?? 'Value'}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="text-xs px-3 mb-0">
                                                <span class="font-weight-bold">{{$lang->data['orders'] ?? 'Orders'}}</span>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs px-3 font-weight-bold mb-0">
                                                {{$new_order}}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-sm px-3 mb-0">{{$lang->data['no_of_orders_delivered'] ?? 'No. of Orders Delivered'}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs px-3 font-weight-bold mb-0">{{$delivered_orders}}</p>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-sm px-3 mb-0">{{$lang->data['total_sales'] ?? 'Total Sales'}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs px-3 font-weight-bold mb-0">{{getFormattedCurrency($total_sales)}}</p>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-sm px-3 mb-0">{{$lang->data['total_payment'] ?? 'Total Payment'}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs px-3 font-weight-bold mb-0">{{getFormattedCurrency($total_payment)}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-sm px-3 mb-0">{{$lang->data['total_expense'] ?? 'Total Expense'}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs px-3 font-weight-bold mb-0">{{getFormattedCurrency($total_expense)}}</p>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-sm px-3 mb-0">{{ $lang->data['materials_used'] ?? 'Materials Used' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs px-3 font-weight-bold mb-0">{{getFormattedCurrency($total_material)}}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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