<div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab"
    tabindex="0" wire:ignore.self>
    <div class="tw-p-0">
        <div class="table-responsive scroll-sm">
            <table class="table bordered-table sm-table mb-0">
                <thead>
                    <tr>
                        <th scope="col" class="">{{ $lang->data['order_info'] ?? 'Order Info' }}</th>
                        <th scope="col" class="">{{ $lang->data['order_amount'] ?? 'Order Amount' }}</th>
                        <th scope="col" class=""> {{ $lang->data['status'] ?? 'Status' }}</th>
                        <th scope="col" class="">{{ $lang->data['payment'] ?? 'Payment' }}</th>
                        <th scope="col" class="text-center">{{ $lang->data['action'] ?? 'Action' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $item)
                        <tr class="tw-text-xs">
                            <td>
                                <div class="tw-flex tw-flex-col">
                                    <div class="text-neutral-600">
                                        {{ $lang->data['order_id'] ?? 'Order ID' }} : <span class="tw-font-medium text-primary-light">{{ $item->order_number }}</span> 
                                    </div>
                                    <div class="text-neutral-600">
                                        {{ $lang->data['order_date'] ?? 'Order Date' }} : <span class="tw-font-medium text-primary-light">{{ \Carbon\Carbon::parse($item->order_date)->format('d/m/y') }}</span> 
                                    </div>
                                    <div class="text-neutral-600">
                                        {{ $lang->data['delivery_date'] ?? 'Delivery Date' }} : <span class="tw-font-medium text-primary-light">{{ \Carbon\Carbon::parse($item->delivery_date)->format('d/m/y') }}</span> 
                                    </div>
                                </div>
                            </td>
                            <td class="text-primary">
                                {{ getFormattedCurrency($item->total) }}
                            </td>
                            <td class="">
                                @if ($item->status == 0)
                                <span class="badge  fw-semibold text-neutral-600 bg-neutral-200 px-20 py-9 radius-4 text-white">
                                    {{ $lang->data['pending'] ?? 'Pending' }}
                                </span>
                                @elseif($item->status == 1)
                                <span class="badge  fw-semibold text-warning-600 bg-warning-100 px-20 py-9 radius-4 text-white">
                                    {{ $lang->data['processing'] ?? 'Processing' }}
                                </span>
                                @elseif($item->status ==2)
                                <span class="badge  fw-semibold text-info-600 bg-info-100 px-20 py-9 radius-4 text-white">
                                    {{ $lang->data['ready_to_deliver'] ?? 'Ready To Deliver' }}
                                </span>
                                @elseif($item->status == 3)
                                <span class="badge  fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4 text-white">
                                    {{ $lang->data['delivered'] ?? 'Delivered' }}
                                </span>
                                @elseif($item->status == 4)
                                <span class="badge  fw-semibold text-danger-600 bg-danger-100 px-20 py-9 radius-4 text-white">
                                    {{ $lang->data['returned'] ?? 'Returned' }}
                                </span>
                                @endif
                            </td>
                            <td>
                                @php
                                $paidamount = \App\Models\Payment::where('order_id', $item->id)->sum('received_amount');
                                @endphp
                                <div class="tw-flex tw-flex-col">
                                    <div class="text-neutral-600">
                                        {{ $lang->data['total_amount'] ?? 'Total Amount' }} : <span class="tw-font-medium text-primary-light">{{ getFormattedCurrency($item->total) }}</span> 
                                    </div>
                                    <div class="text-neutral-600">
                                        @php
                                        $current_paid_amount = \App\Models\Payment::where('order_id',$item->id)->sum('received_amount');
                                        @endphp
                                        {{ $lang->data['paid_amount'] ?? 'Paid Amount' }} : <span class="tw-font-medium text-primary-light"> {{ getFormattedCurrency($current_paid_amount) }}</span> 
                                    </div>
                                    @if ($paidamount < $item->total)
                                        @if($item->status != 4)
                                        <div class="tw-mt-1">
                                            <button type="button" class="btn rounded-pill btn-success-100 text-success-600 radius-8 tw-text-xs tw-py-1 tw-px-2 " data-bs-toggle="modal" data-bs-target="#exampleModal" wire:click="payment({{ $item->id }})">{{ $lang->data['add_payment'] ?? 'Add Payment' }}</button>
                                        </div>
                                        @endif
                                    @else
                                    @if($item->status != 4)
                                    <div class="tw-mt-1">
                                        <button type="button" class="btn rounded-pill btn-neutral-300 text-neutral-600 radius-8 tw-text-xs tw-py-1 tw-px-2 " >{{ $lang->data['fully_paid'] ?? 'Fully Paid' }}</button>
                                    </div>
                                    @endif
                                    @endif

                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    <a href="{{ route('order.view', $item->id) }}" type="button"
                                        class="bg-info-100 text-info-600 bg-hover-info-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="lucide:eye" class="menu-icon"></iconify-icon>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($hasMorePages)
                <div x-data="{
                    init() {
                        let observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    @this.call('loadOrders')
                                    console.log('loading...')
                                }
                            })
                        }, {
                            root: null
                        });
                        observer.observe(this.$el);
                    }
                }" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-4">
                    <div class="text-center pb-2 d-flex justify-content-center align-items-center">
                    {{ $lang->data['loading'] ?? 'Loading...' }}
                        <div class="spinner-grow d-inline-flex mx-2 text-primary" role="status">
                            <span class="visually-hidden"> {{ $lang->data['loading'] ?? 'Loading...' }}</span>
                        </div>
                    </div>
                </div>
            @endif
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
                                                <span class="text-secondary-light fw-medium">{{ $customer_name }}</span>
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
                                    <input type="text" class="form-control radius-8" placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}" wire:model="balance" >
                                    @error('balance')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 mb-20 ">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['payment_type'] ?? 'Payment Type' }} <span class="text-danger">*</span></label>
                                    <select  class="form-select radius-8" wire:model="payment_mode">
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
                                    @error('payment_mode')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 mb-20">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['notes'] ?? 'Notes' }} </label>
                                    <textarea class="form-control radius-8" placeholder="{{ $lang->data['enter_notes'] ?? 'Enter Notes' }}"  wire:model="note"></textarea>
                                    @error('note')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="d-flex align-items-start justify-content-end gap-3 mt-24">
                                    <button data-bs-dismiss="modal" type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8"> 
                                        Cancel
                                    </button>
                                    <button type="button" wire:click.prevent="addPayment()" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8"> 
                                        Save Change
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>