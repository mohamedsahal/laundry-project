<div class="dashboard-main-body">
    <div class="tw-flex tw-gap-4 lg:tw-flex-row tw-flex-col">
        <div class="card h-100 p-0 radius-12 tw-w-full">
            <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between ">
                <div class="tw-flex tw-flex-col  tw-text-sm">
                    <div class="text-lg tw-font-medium text-primary-light">
                        {{ $sitename }}
                    </div>
                    <div class="tw-flex tw-flex-col tw-mt-2">
                        <div class="">{{$phone ? getCountryCode() : ''}}{{ (int)$phone }}</div>
                        <div class="">{{ $store_email }}</div>
                        <div class="">{{ $address }} - {{ $zipcode }}</div>
    
                        <div class="tw-mt-2">{{ $lang->data['tax'] ?? 'TAX' }}: {{ $tax_number }}</div>
                    </div>
                </div>
                <div class="tw-flex tw-flex-col  tw-text-sm tw-items-end">
                    <div class="text-lg tw-font-medium text-primary-light">
                    </div>
                    <div class="tw-flex tw-flex-col tw-mt-2 tw-items-end">
                        <div class="text-neutral-600">
                            {{ $lang->data['order_id'] ?? 'Order ID' }} : <span class="tw-font-medium text-primary-light">#{{ $order->order_number }}</span> 
                        </div>
                        <div class="text-neutral-600">
                            {{ $lang->data['order_date'] ?? 'Order Date' }} : <span class="tw-font-medium text-primary-light">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span> 
                        </div>
                        <div class="text-neutral-600">
                            {{ $lang->data['delivery_date'] ?? 'Delivery Date' }} : <span class="tw-font-medium text-primary-light">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</span> 
                        </div>
                        <div class="tw-mt-2 tw-flex tw-items-center tw-gap-2">
                            <div class="">
                                {{ $lang->data['order_status'] ?? 'Order Status' }} : 
                            </div>
                            <div class="dropdown">
                                @can('order_status_change')
                                @if($order->status != 3 && $order->status != 4)
                                <button class="btn btn-primary-600 not-active tw-py-1 tw-px-2 dropdown-toggle toggle-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false"> {{ getOrderStatus($order->status) }} </button>
                                <ul class="dropdown-menu" style="">
                                  <li><a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" href="#" wire:click.prevent="changeStatus(1)">{{ $lang->data['processing'] ?? 'Processing' }}</a></li>
                                  <li><a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" href="#" wire:click.prevent="changeStatus(2)">{{ $lang->data['ready_to_deliver'] ?? 'Ready To Deliver' }}</a></li>
                                  <li>
                                        @if($balance > 0)
                                        <button disabled class="dropdown-item px-16 py-8 rounded tw-text-neutral-400  disabled:tw-bg-transparent" href="#" >
                                            {{ $lang->data['delivered'] ?? 'Delivered' }} <span class="text-danger text-xs">({{ $lang->data['payment_incomplete'] ?? 'Payment Incomplete' }})</span>
                                        </button>
                                        @else
                                        <button  class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" href="#" wire:click.prevent="changeStatus(3)">
                                            {{ $lang->data['delivered'] ?? 'Delivered' }} 
                                        </button>
                                        @endif
                                    </li>
                                  <li><a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" href="#" wire:click.prevent="changeStatus(4)">{{ $lang->data['returned'] ?? 'Returned' }}</a></li>
                                </ul>
                                @else
                                    @if($order->status == 4)
                                    <div class="text-danger">
                                        {{ $lang->data['returned'] ?? 'Returned' }}
                                    </div>
                                    @else
                                    <div class="text-success">
                                        {{ $lang->data['delivered'] ?? 'Delivered' }}
                                    </div>
                                    @endif
                                @endif
                                @endcan
                                @cannot('order_status_change')
                                <div class="">
                                    {{ getOrderStatus($order->status) }}
                                </div>
                                @endcannot 
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-24">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                      <thead>
                        <tr>
                          <th scope="col" class="">#</th>
                          <th scope="col" class="">{{ $lang->data['service_name'] ?? 'Service Name' }}</th>
                          <th scope="col" class=""> {{ $lang->data['color'] ?? 'Color' }}</th>
                          <th scope="col" class="">{{ $lang->data['rate'] ?? 'Rate' }}</th>
                          <th scope="col" class=""> {{ $lang->data['qty'] ?? 'QTY' }}</th>
                          <th scope="col" class=""> {{ $lang->data['total'] ?? 'Total' }}</th>
                          <th scope="col" class=""> {{ $lang->data['actions'] ?? 'Actions' }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($orderdetails as $item)
                            @php
                                $service = \App\Models\Service::where('id', $item->service_id)->first();
                            @endphp
                            <tr class="tw-text-sm">
                                <td>
                                    {{ $loop->index + 1 }}
                                </td>
                                <td class="">
                                    <div class="tw-flex tw-gap-4">
                                        <div class="tw-size-10">
                                            <img src="{{ $service->image() }}" class="tw-object-contain tw-rounded-lg" alt="">
                                        </div>
                                        <div class="tw-flex tw-flex-col">
                                            <p class="tw-text-black">{{ $service->service_name }}</p>
                                            <p class="tw-text-gray-600 tw-text-xs">[{{$item->service_name}}]</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-primary">
                                    @if($item->color_code!="")
                                    <div class="tw-size-6 tw-rounded-lg" style="background-color: {{$item->color_code}}">
                                    </div>
                                    @else
                                    <div class="tw-size-6 tw-rounded-lg tw-bg-white" >
                                    </div>
                                    @endif
                                </td>
                                <td class="text-primary">
                                    {{ getFormattedCurrency($item->service_price) }}
                                </td>
                                <td>
                                    {{ $item->service_quantity }}
                                </td>
                                <td class="text-primary">

                                    <div class="tw-flex tw-gap-2 tw-items-center">
                                        {{ getFormattedCurrency($item->service_detail_total) }}

                                       
                                    </div>
                                </td>

                                <td>
                                    @can('order_print')
                                    <a href="{{route('order.print-job-card',['id' => $order->id,'detailId' => $item->id])}}" target="_blank" type="button" class="btn btn-outline-warning-600 tw-p-1 tw-rounded-full">
                                        <iconify-icon icon="material-symbols-light:print-outline" class="menu-icon tw-text-xl"></iconify-icon>
                                    </a>
                                    @endcan()
                                </td>
                               
                            </tr>
                            @endforeach
                      </tbody>
                    </table>
                </div>

                <div class="tw-flex tw-flex-col">
                    <div class="tw-flex tw-justify-between tw-items-start tw-mt-6">
                        <div class="tw-flex tw-flex-col ">
                            <div class="">{{ $lang->data['invoice_to'] ?? 'Invoice To' }}</div>
                            <div class="tw-mt-2 tw-font-medium tw-text-sm">
                                {{ $customer->name ?? 'Walk-In Customer' }}
                            </div>
                            <div class="tw-text-sm">
                                {{$customer && $customer->phone ? getCountryCode() : ''}} {{  $customer && $customer->phone ?  (int)$customer->phone : 'Phone' }}
                            </div>
                            <div class=" tw-text-sm">
                                {{ $customer->email ?? 'Email' }}
                            </div>
                            <div class=" tw-text-sm">
                                {{ $customer->address ?? '' }}
                            </div>
    
                            <div class="tw-text-sm tw-mt-2">
                                {{ $lang->data['vat'] ?? 'VAT' }} : {{ $customer->tax_number ?? 'TAX' }}
                            </div>
                        </div>
    
                        <div class="tw-flex tw-flex-col ">
                            <div class="pb-2">{{ $lang->data['payment_details'] ?? 'Payment Details' }}</div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem] tw-mt-2">
                                <div class="  tw-text-sm">
                                    {{ $lang->data['sub_total'] ?? 'Sub Total' }}
                                </div>
                                <div class=" tw-text-sm">
                                    {{ getFormattedCurrency($order->sub_total) }}
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem]">
                                <div class="  tw-text-sm">
                                    {{ $lang->data['addon'] ?? 'Addon' }}
                                </div>
                                <div class=" tw-text-sm">
                                    {{ getFormattedCurrency($order->addon_total) }}
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem]">
                                <div class="  tw-text-sm">
                                    {{ $lang->data['discount'] ?? 'Discount' }}
                                </div>
                                <div class=" tw-text-sm">
                                    {{ getFormattedCurrency($order->discount) }}
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem]">
                                <div class="  tw-text-sm">
                                    {{ $lang->data['tax'] ?? 'Tax' }}
                                        ({{ $order->tax_percentage }}%)
                                </div>
                                <div class=" tw-text-sm">
                                    {{ getFormattedCurrency($order->tax_amount) }}
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem] tw-mt-2  ">
                                <div class=" tw-font-bold tw-text-sm">
                                    {{ $lang->data['gross_total'] ?? 'Gross Total' }}
                                </div>
                                <div class="tw-font-bold tw-text-sm">
                                    {{ getFormattedCurrency($order->total) }}
                                </div>
                                
                            </div>
                           
                        </div>
                    </div>
                    <hr class="tw-mt-4">
                    <div class="tw-flex tw-justify-between tw-text-sm tw-mt-4 ">
                        <div class=""><span class="tw-font-medium">{{ $lang->data['notes'] ?? 'Notes' }} :</span> {{ $order->note }}</div>                        
                    </div>
                    <div class="tw-flex tw-items-center tw-justify-center tw-gap-2 tw-mt-4">
                        <div class="tw-w-full tw-h-[1px]  tw-from-transparent tw-to-neutral-300 tw-bg-gradient-to-r"></div>
                        <div class="tw-shrink-0 tw-font-light">{{ $lang->data['powered_by'] ?? 'Powered By' }}<span class="tw-font-bold">{{ getApplicationName() }}</span> </div>
                        <div class="tw-w-full tw-h-[1px] tw-from-transparent tw-to-neutral-300 tw-bg-gradient-to-l"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card h-100 p-0 radius-12 lg:tw-w-[24rem]  tw-w-full tw-shrink-0">
            <div class="card-body p-24">
                @if ($orderaddons)
                    @if (count($orderaddons) > 0)
                    <div class="tw-text-xl tw-font-medium">{{ $lang->data['service_addons'] ?? 'Service Addons' }}</div>
                    @foreach ($orderaddons as $item)
                        <div class="tw-flex tw-flex-col bg-gradient-success card tw-mt-2">
                            <div class="card-body">
                                <div class="tw-flex tw-items-center  tw-text-sm tw-gap-4">
                                    <div class=" tw-relative tw-items-center tw-flex tw-flex-col ">
                                    <iconify-icon icon="tabler:puzzle" class="menu-icon tw-text-xl"></iconify-icon>
                                    </div>
                                    <div class="tw-flex tw-flex-col">
                                        <div class="tw-font-medium">{{ $item->addon_name }} </div>
                                        <div class="">{{ getFormattedCurrency($item->addon_price) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                @endif
                @can('payment_create')
                <div class="tw-text-xl tw-font-medium tw-pt-6">{{ $lang->data['payments'] ?? 'Payments' }}</div>
                @foreach ($payments as $item)
                <div class="tw-flex tw-items-center tw-pt-2 tw-text-sm tw-gap-4">
                    <div class=" tw-relative tw-items-center tw-flex tw-flex-col tw-translate-y-1">
                        <iconify-icon icon="tabler:target" class="menu-icon"></iconify-icon>
                        <div class="tw-top-[100%] tw-left-[6px] tw-h-6 tw-w-[2px] tw-bg-neutral-300"></div>
                    </div>
                    <div class="tw-flex tw-flex-col">
                        <div class="tw-font-medium">{{ getFormattedCurrency($item->received_amount) }}</div>
                        <div class="tw-text-xs tw-font-light tw-mt-1">{{ Carbon\Carbon::parse($item->payment_date)->format('d/m/Y') }} <span class="tw-font-bold">[{{ getpaymentMode($item->payment_type) }}]</span></div>
                    </div>
                </div>
                @endforeach
                @if ($balance > 0)
                    @if($order->status != 4)
                        <button data-bs-toggle="modal" data-bs-target="#exampleModal"  type="button" class="btn btn-outline-success-600 radius-8 px-20 py-11 tw-mt-6 tw-w-full" >{{ $lang->data['add_payment'] ?? 'Add Payment' }}</button>
                    @endif
                @else
                <button type="button" class="btn btn-outline-neutral-600 radius-8 px-20 py-11 tw-mt-6 tw-w-full" disabled>{{ $lang->data['fully_paid'] ?? 'Fully Paid' }}</button>
                @endif
                @endcan
                @can('order_print')
                <a href="{{url('admin/orders/print/'.$order->id)}}" target="_blank" type="button" class="btn btn-outline-warning-600 radius-8 px-20 py-11 tw-mt-3 tw-w-full">{{ $lang->data['print_invoice'] ?? 'Print Invoice' }}</a>
                @endcan()
                @can('order_print')
                <a href="{{route('order.print-job-card',['id' => $order->id])}}" target="_blank" type="button" class="btn btn-outline-info-500 radius-8 px-20 py-11 tw-mt-3 tw-w-full">{{ $lang->data['print_job_card'] ?? 'Print Job Card' }}</a>
                @endcan()
                <a id="whatsappShareButton" href="#" target="_blank" type="button" class="btn btn-outline-success-600 radius-8 px-20 py-11 tw-mt-3 tw-w-full" data-action="share/whatsapp/share">Share via Whatsapp</a>

            </div>
        </div>
    </div>
  

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">{{ $lang->data['payment_details'] ?? 'Payment Details' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if ($order)
                    <div class="modal-body p-24">
                        <form action="#">
                            <div class="row">   
                                <div class="col-12">
                                    <div class="">
                                        <ul>
                                            <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between tw-w-full">
                                                <span class="text-md fw-semibold text-primary-light">{{ $lang->data['customer'] ?? 'Customer' }} :</span>
                                                <span class="text-secondary-light fw-medium">{{ $customer->name ?? '' }}</span>
                                            </li>
                                            <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between ">
                                                <span class="text-md fw-semibold text-primary-light"> {{ $lang->data['order_id'] ?? 'Order ID' }} :</span>
                                                <span class="text-secondary-light fw-medium">{{ $order->order_number }}</span>
                                            </li>
                                            <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between">
                                                <span class="text-md fw-semibold text-primary-light">  {{ $lang->data['order_date'] ?? 'Order Date' }} :</span>
                                                <span class="text-secondary-light fw-medium">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
                                            </li>
                                            <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between">
                                                <span class="text-md fw-semibold text-primary-light">  {{ $lang->data['delivery_date'] ?? 'Delivery Date' }} :</span>
                                                <span class="text-secondary-light fw-medium">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</span>
                                            </li>
                                            <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between">
                                                <span class="text-md fw-semibold text-primary-light"> {{ $lang->data['order_amount'] ?? 'Order Amount' }} :</span>
                                                <span class="text-secondary-light fw-medium"> {{ getFormattedCurrency($order->total) }}</span>
                                            </li>
                                            <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between">
                                                <span class="text-md fw-semibold text-primary-light"> {{ $lang->data['paid_amount'] ?? 'Paid Amount' }} :</span>
                                                <span class="text-secondary-light fw-medium"> {{ getFormattedCurrency($paid_amount) }}</span>
                                            </li>
                                            <li class="d-flex align-items-center gap-1 tw-justify-between">
                                                <span class="text-md fw-semibold text-primary-light"> {{ $lang->data['balance'] ?? 'Balance' }} :</span>
                                                <span class="text-secondary-light fw-medium"> {{ getFormattedCurrency($order->total - $paid_amount) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 tw-my-6">
                                    <hr>
                                </div>
                                <div class="col-12 mb-20 ">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['paid_amount'] ?? 'Paid Amount' }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control radius-8" placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}" wire:model="paid_amount" >
                                    @error('balance')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 mb-20 ">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['payment_type'] ?? 'Payment Type' }} <span class="text-danger">*</span></label>
                                    <select  class="form-select radius-8" wire:model="payment_type">
                                        <option value="">
                                            {{ $lang->data['choose_payment_type'] ?? 'Choose Payment Type' }}
                                        </option>
                                        <option class="select-box" value="1">
                                            Sahal
                                        </option>
                                        <option class="select-box" value="2">
                                            Edahab
                                        </option>
                                        <option class="select-box" value="3">
                                            Premier Wallet
                                        </option>
                                        <option class="select-box" value="4">
                                            Mycash
                                        </option>
                                        <option class="select-box" value="5">
                                            T-plus
                                        </option>
                                    </select>
                                    @error('payment_type')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mb-20">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['notes'] ?? 'Notes' }} </label>
                                    <textarea class="form-control radius-8" placeholder="{{ $lang->data['enter_notes'] ?? 'Enter Notes' }}"  wire:model="notes"></textarea>
                                    @error('notes')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="d-flex align-items-start justify-content-end gap-3 mt-24">
                                    <button data-bs-dismiss="modal" type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8"> 
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                    </button>
                                    <button wire:click.prevent="addPayment" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8"> 
                                    {{ $lang->data['save'] ?? 'Save' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const whatsappButton = document.getElementById("whatsappShareButton");
            
            const sitename = "{{ $sitename }}";
            const phone = "{{ $phone ? $phone : 'N/A' }}";
            const email = "{{ $store_email }}";
            const address = "{{ $address }}";
            const zipcode = "{{ $zipcode }}";
            const orderId = "{{ $order->order_number }}";
            const orderDate = "{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}";
            const deliveryDate = "{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}";
            const orderStatus = "{{ getOrderStatus($order->status) }}";
            const grossTotal = "{{ getFormattedCurrency($order->total) }}";
            const subTotal = "{{ getFormattedCurrency($order->sub_total) }}";
            const taxTotal = "{{ getFormattedCurrency($order->tax_amount) }}";
            const customerName = "{{ $customer->name ?? 'Walk-In Customer' }}";
            const customerPhone = "{{ $customer && $customer->phone ? $customer->phone : 'N/A' }}";
            const customerEmail = "{{ $customer->email ?? 'N/A' }}";
            const paymentReceived = "{{ getFormattedCurrency($payments->sum('received_amount')) }}"
            let orders = ``;
            @foreach ($orderdetails as $item)
            @php
            $service = \App\Models\Service::where('id', $item->service_id)->first();
            @endphp
            orders += '{{$loop->index +1 }}. Item : {{$service->service_name }}, Quantity : {{$item->service_quantity}}, Total : {{getFormattedCurrency($item->service_detail_total)}}\n'
            @endforeach
            let summary = `*Order Summary*\n*Order ID:* #${orderId}\n*Order Date:* ${orderDate}\n*Delivery Date:* ${deliveryDate}\n*Status:* ${orderStatus}\n*Phone:* ${phone}\n*Email:* ${email}\n*Address:* ${address} ${zipcode}\n*Payment Received:* ${paymentReceived}\n\nDetails:\n${orders}\n*Sub Total:* ${subTotal}\n*Tax Total:* ${taxTotal}\n*Total:* ${grossTotal}`;
            whatsappButton.href = `https://api.whatsapp.com/send?text=${encodeURIComponent(summary)}{!!$customer?->phone ?'&phone='. $customer->phone : ''!!}`;
        });
    </script>

</div>