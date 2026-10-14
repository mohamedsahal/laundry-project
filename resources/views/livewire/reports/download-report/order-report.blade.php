<div>
    <!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{$lang->data['order_report'] ?? 'Order Report'}}</title>
        <style>
            #main {
                border-collapse: collapse;
                line-height: 1rem;
                text-align: center;
            }
            th {
                background-color: rgb(101, 104, 101);
                Color: white;
                font-size: 0.75rem;
                line-height: 1rem;
                font-weight: bold;
                text-transform: uppercase;
                text-align: center;
                padding: 10px;
            }
            td {
                text-align: center;
                border: 1px solid;
                font-size: 0.75rem;
                line-height: 1rem;
            }
            .col {
                border: none;
                text-align: left;
                padding: 10px;
                font-size: 0.75rem;
                line-height: 1rem;
            }
        </style>
    </head>
    <body onload="">
        @php
            if ($status == -1) {
                $orders = \App\Models\Order::whereDate('order_date', '>=', $from_date)
                    ->whereDate('order_date', '<=', $to_date)
                    ->latest()
                    ->get();
            } else {
                $orders = \App\Models\Order::whereDate('order_date', '>=', $from_date)
                    ->whereDate('order_date', '<=', $to_date)
                    ->where('status', $status)
                    ->latest()
                    ->get();
            }
            $lang = null;
        if (session()->has('selected_language')) {
        $lang = \App\Models\Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $lang = \App\Models\Translation::where('default', 1)->first();
        }
        @endphp
        <h3 class="fw-500 text-dark">{{$lang->data['order_report'] ?? 'Order Report'}}</h3>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="col"> <label>{{$lang->data['start_date'] ?? 'Start Date'}}: </label>
                    {{ \Carbon\Carbon::parse($from_date)->format('d/m/Y') }}</td>
                <td class="col"> <label>{{$lang->data['end_date'] ?? 'End Date'}}: </label>
                    {{ \Carbon\Carbon::parse($to_date)->format('d/m/Y') }} </td>
                <td class="col"> <label>{{$lang->data['status'] ?? 'Status'}}: </label>
                    {{ getOrderStatus($status) }}
            </tr>
        </table>
        <table id="main" width="100%" cellpadding="0" cellspacing="0">
            <thead class="table-dark">
                <tr>
                    <th class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['date'] ?? 'Date'}}</th>
                    <th class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['order_id'] ?? 'Order ID'}}</th>
                    <th class="text-uppercase text-secondary text-xs  opacity-7">{{$lang->data['customer'] ?? 'Customer'}}</th>
                    <th class="text-uppercase text-secondary text-xs  opacity-7">{{$lang->data['order_amount'] ?? 'Order Amount'}}</th>
                    <th class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['status'] ?? 'Status'}}</th>
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
        <br /> <br />
        <table cellspacing="15">
            <tr>
                <td class="col">
                    <span class="text-sm mb-0 fw-500">{{$lang->data['total_orders'] ?? 'Total Orders'}}:</span>
                    <span class="text-sm text-dark ms-2 fw-600 mb-0">{{ count($orders) }}</span>
                </td>
                <td class="col"> <span class="text-sm mb-0 fw-500">{{$lang->data['total_order_amount'] ?? 'Total Order Amount'}}:</span>
                    <span
                        class="text-sm text-dark ms-2 fw-600 mb-0">{{getFormattedCurrency($orders->sum('total'))}}</span>
                </td>
            </tr>
        </table>
    </body>
    </html>
</div>