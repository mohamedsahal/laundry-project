<div>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        $new_order = \App\Models\Order::whereDate('order_date',$today)->count();
        $delivered_orders = \App\Models\Order::whereDate('order_date',$today)->where('status',3)->count();
        $total_payment = \App\Models\Payment::whereDate('payment_date',$today)->sum('received_amount');
        $total_expense = \App\Models\Expense::whereDate('expense_date',$today)->sum('expense_amount');
        $total_material = \App\Models\StockUsage::whereDate('usage_date',$today)->sum('total_cost');
        $total_sales = \App\Models\Order::whereDate('order_date',$today)->where('status',3)->sum('total');
        $lang = null;
        if (session()->has('selected_language')) {
        $lang = \App\Models\Translation::where('id', session()->get('selected_language'))->first();
        } else {
        $lang = \App\Models\Translation::where('default', 1)->first();
        }
        @endphp
        <h3 class="fw-500 text-dark">{{$lang->data['daily_report'] ?? 'Daily Report'}}</h3>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="col"> <label>{{$lang->data['date'] ?? 'Date'}}: </label>
                    {{ \Carbon\Carbon::parse($today)->format('d/m/Y') }}
                </td>
            </tr>
        </table>
        <br /> <br />
        <table  width="100%" cellpadding="0" cellspacing="0" border="0">
        <thead class="table-dark">
                <tr>
                    <th class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['particulars'] ?? 'Particulars'}}</th>
                    <th class="text-uppercase text-secondary text-xs opacity-7">{{$lang->data['value'] ?? 'Value'}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <p class="text-xs px-3 mb-0">{{$lang->data['orders'] ?? 'Orders'}}</p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold text-warning mb-0">{{$new_order}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="text-sm px-3 mb-0">{{$lang->data['no_of_orders_delivered'] ?? 'No. of Orders Delivered'}}</p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold text-primary mb-0">{{$delivered_orders}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="text-sm px-3 mb-0">{{$lang->data['total_sales'] ?? 'Total Sales'}}</p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold text-success mb-0">{{getFormattedCurrency($total_sales)}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="text-sm px-3 mb-0">{{$lang->data['total_payment'] ?? 'Total Payment'}}</p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold text-info mb-0">{{getFormattedCurrency($total_payment)}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="text-sm px-3 mb-0">{{$lang->data['total_expense'] ?? 'Total Expense'}}</p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold text-danger mb-0">{{getFormattedCurrency($total_expense)}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="text-sm px-3 mb-0">{{ $lang->data['materials_used'] ?? 'Materials Used' }}</p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold text-danger mb-0">{{getFormattedCurrency($total_material)}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
    </html>
</div>