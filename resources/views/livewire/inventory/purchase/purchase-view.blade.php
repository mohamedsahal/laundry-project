<div class="dashboard-main-body">
    <div class="tw-flex tw-gap-4 lg:tw-flex-row tw-flex-col">
        <div class="card h-100 p-0 radius-12 tw-w-full">
            <div
                class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between ">
                <div class="tw-flex tw-flex-col  tw-text-sm">
                    <div class="text-lg tw-font-medium text-primary-light">
                        {{ $purchase->supplier->name}}
                    </div>
                    <div class="tw-flex tw-flex-col tw-mt-2">
                        <div class="">{{ $purchase->supplier->phone }}</div>
                        <div class="">{{ $purchase->supplier->email }}</div>
                        <div class="">{{ $purchase->supplier->address }}</div>
                        <div class="tw-mt-2">{{ $lang->data['tax'] ?? 'TAX' }}: {{ $purchase->supplier->tax_number }}</div>
                    </div>
                </div>
                <div class="tw-flex tw-flex-col tw-text-sm tw-items-end">
                    <div class="tw-flex tw-flex-col tw-mt-2 tw-items-end">
                        <div class="text-neutral-600">
                            {{ $lang->data['invoice_number'] ?? 'Invoice Number' }} : # <span
                                class="tw-font-medium text-primary-light">{{ $invoice_number }}</span>
                        </div>
                        <div class="text-neutral-600">
                            {{ $lang->data['invoice_date'] ?? 'Invoice Date' }} : <span
                                class="tw-font-medium text-primary-light">{{ $invoice_date }}</span>
                        </div>
                        <div class="text-neutral-600">
                            {{ $lang->data['purchase_number'] ?? 'Purchase Number' }} : # <span
                                class="tw-font-medium text-primary-light">{{ $purchase_number }}</span>
                        </div>
                        <div class="text-neutral-600">
                            {{ $lang->data['purchase_date'] ?? 'Purchase Date' }} : <span
                                class="tw-font-medium text-primary-light">{{ $purchase_date->format('Y-m-d') }}</span>
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
                                <th scope="col" class="">{{ $lang->data['purchase_items'] ?? 'Purchase Items' }}
                                </th>
                                <th scope="col" class=""> {{ $lang->data['purchase_price'] ?? 'Purchase Price' }}</th>
                                <th scope="col" class="">{{ $lang->data['qty'] ?? 'QTY' }}</th>
                                <th scope="col" class=""> {{ $lang->data['tax_amount'] ?? 'Tax Amount' }}</th>
                                <th scope="col" class=""> {{ $lang->data['total'] ?? 'Total' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase_details as $detail)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td class="">
                                        <p>{{ $detail->product_name  }}</p>
                                        <p>{{ $detail->created_at->format('Y-m-d') }}</p>
                                    </td>
                                    <td class="">
                                        <p>{{ getCurrency() }} {{ number_format($detail->purchase_price, 2) }}</p>
                                    </td>
                                    <td class="">
                                        <p>{{ $detail->quantity  }}</p>
                                    </td>
                                    <td class="">
                                        <p>{{ getCurrency() }} {{ number_format($detail->tax_amount, 2) }}</p>
                                    </td>
                                    <td class="">
                                        <p>{{ getCurrency() }} {{ number_format($detail->total, 2) }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tw-flex tw-flex-col">
                    <div class="tw-flex tw-justify-between tw-items-start tw-mt-6">
                        <div class="tw-flex tw-flex-col">
                            <div class="pb-2 text-lg tw-font-medium text-primary-light">{{ $lang->data['payment_details'] ?? 'Payment Details' }}</div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem] tw-mt-4">
                                <div class="  tw-text-sm">
                                    {{ $lang->data['sub_total'] ?? 'Sub Total' }}
                                </div>
                                <div class=" tw-text-sm">
                                    {{ getCurrency() }} {{ number_format($sub_total, 2) }}
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem]">
                                <div class="  tw-text-sm">
                                    {{ $lang->data['discount'] ?? 'Discount' }}
                                </div>
                                <div class=" tw-text-sm">
                                    {{ getCurrency() }} {{ number_format($discount_total, 2) }}
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem]">
                                <div class="  tw-text-sm">
                                    {{ $lang->data['tax_amount'] ?? 'Tax Amount' }}
                                </div>
                                <div class=" tw-text-sm">
                                    {{ getCurrency() }} {{ number_format($tax_amount, 2) }}
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem]">
                                <div class="  tw-text-sm">
                                    {{ $lang->data['taxable_amount'] ?? 'Taxable Amount' }}
                                </div>
                                <div class=" tw-text-sm">
                                    {{ getCurrency() }} {{ number_format($taxable_amount, 2) }}
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem] tw-mt-2  ">
                                <div class=" tw-font-bold tw-text-sm">
                                    {{ $lang->data['gross_total'] ?? 'Gross Total' }}
                                </div>
                                <div class="tw-font-bold tw-text-sm">
                                    {{ getCurrency() }} {{ number_format($total, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="tw-mt-4">
                    <div class="tw-flex tw-items-center tw-justify-center tw-gap-2 tw-mt-4">
                        <div class="tw-w-full tw-h-[1px]  tw-from-transparent tw-to-neutral-300 tw-bg-gradient-to-r">
                        </div>
                        <div class="tw-shrink-0 tw-font-light">{{ $lang->data['powered_by'] ?? 'Powered By' }}<span  class="tw-font-bold"> &nbsp; {{ getApplicationName() }}</span> </div>
                        <div class="tw-w-full tw-h-[1px] tw-from-transparent tw-to-neutral-300 tw-bg-gradient-to-l">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">
                        {{ $lang->data['payment_details'] ?? 'Payment Details' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <ul>
                                        <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between tw-w-full">
                                            <span
                                                class="text-md fw-semibold text-primary-light">{{ $lang->data['customer'] ?? 'Customer' }}
                                                :</span>
                                            <span
                                                class="text-secondary-light fw-medium">{{ $customer->name ?? '' }}</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between ">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['order_id'] ?? 'Order ID' }} :</span>
                                            <span class="text-secondary-light fw-medium">Order Number</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['order_date'] ?? 'Order Date' }} :</span>
                                            <span class="text-secondary-light fw-medium">Order Date</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['delivery_date'] ?? 'Delivery Date' }} :</span>
                                            <span class="text-secondary-light fw-medium">Delivery Date</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['order_amount'] ?? 'Order Amount' }} :</span>
                                            <span class="text-secondary-light fw-medium">
                                                Order total</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['paid_amount'] ?? 'Paid Amount' }} :</span>
                                            <span class="text-secondary-light fw-medium">
                                                Paid Amount</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 tw-justify-between">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['balance'] ?? 'Balance' }} :</span>
                                            <span class="text-secondary-light fw-medium">
                                                Balance</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 tw-my-6">
                                <hr>
                            </div>
                            <div class="col-12 mb-20 ">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['paid_amount'] ?? 'Paid Amount' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"
                                    wire:model="paid_amount">
                                @error('balance')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 mb-20 ">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['payment_type'] ?? 'Payment Type' }}
                                    <span class="text-danger">*</span></label>
                                <select class="form-select radius-8" wire:model="payment_type">
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
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['notes'] ?? 'Notes' }}
                                </label>
                                <textarea class="form-control radius-8" placeholder="{{ $lang->data['enter_notes'] ?? 'Enter Notes' }}"
                                    wire:model="notes"></textarea>
                                @error('notes')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex align-items-start justify-content-end gap-3 mt-24">
                                <button data-bs-dismiss="modal" type="button"
                                    class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8">
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button wire:click.prevent="addPayment"
                                    class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8">
                                    {{ $lang->data['save'] ?? 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
