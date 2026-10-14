<div>
    <!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{$lang->data['order_report'] ?? 'Order Report'}}</title>
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
        <div class="row align-items-center justify-content-between mb-4">
            <div class="col">
                <h5 class="fw-500">{{$lang->data['order_report'] ?? 'Order Report'}}</h5>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-md-3">
                    <label>{{$lang->data['start_date'] ?? 'Start Date'}}: </label>
                    {{ \Carbon\Carbon::parse($from_date)->format('d/m/Y') }}
                </div>
                <div class="col-md-3">
                    <label>{{$lang->data['end_date'] ?? 'End Date'}}: </label>
                    {{ \Carbon\Carbon::parse($to_date)->format('d/m/Y') }}
                </div>
                <div class="col-md-3">
                    <label>{{$lang->data['status'] ?? 'Status'}}: </label>
                    {{ getOrderStatus($status) }}
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4 shadow-none">
                    <div class="card-header p-4">
                    </div>
                    <div class="card-body p-0 shadow-none">
                        <div class="table-responsive">
                            <table class="table table-bordered align-items-center mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-uppercase text-xs">{{$lang->data['date'] ?? 'Date'}}</th>
                                        <th class="text-uppercase text-xs">{{$lang->data['order_id'] ?? 'Order ID'}}</th>
                                        <th class="text-uppercase text-xs">{{$lang->data['customer'] ?? 'Customer'}}</th>
                                        <th class="text-uppercase text-xs ">{{$lang->data['order_amount'] ?? 'Order Amount'}}</th>
                                        <th class="text-uppercase text-xs ">{{$lang->data['status'] ?? 'Status'}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $row)
                                        <tr>
                                            <td>
                                                <p class="text-xs px-3 mb-0">
                                                    {{ \Carbon\Carbon::parse($row->order_date)->format('d/m/Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs px-3 mb-0">
                                                    <span class="font-weight-bold">{{ $row->order_number }}</span>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs px-3 font-weight-bold mb-0">
                                                    {{ $row->customer_name ?? 'Walk In Customer' }}</p>
                                            </td>
                                            <td style="text-align: center">
                                                <p class="text-xs px-3 font-weight-bold mb-0">
                                                    {{getFormattedCurrency($row->total)}}</p>
                                            </td>
                                            <td style="text-align: center">
                                                <a type="button"
                                                    class="badge badge-sm bg-secondary text-uppercase">{{ getOrderStatus($row->status) }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row align-items-center pt-5 px-4 mb-3">
                            <div class="col">
                                <span class="text-sm mb-0 fw-500">{{$lang->data['total_orders'] ?? 'Total Orders'}}:</span>
                                <span class="text-sm text-dark ms-2 fw-600 mb-0">{{ count($orders) }}</span>
                            </div>
                            <div class="col">
                                <span class="text-sm mb-0 fw-500">{{$lang->data['total_order_amount'] ?? 'Total Order Amount'}}:</span>
                                <span
                                    class="text-sm text-dark ms-2 fw-600 mb-0">{{getFormattedCurrency($orders->sum('total'))}}</span>
                            </div>
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