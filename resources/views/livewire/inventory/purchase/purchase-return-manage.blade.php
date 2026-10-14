<div class="dashboard-main-body">
    <div class="card tw-h-full  radius-12 pb-3 pt-3 tw-flex tw-flex-col">
        <div class="tw-flex tw-justify-between tw-py-2 tw-px-3">
            <div class="tw-flex gap-1">
                <div class="icon-field  tw-relative tw-w-full tw-items-center">
                    <span class="icon -tw-translate-y-[2px]">
                        <iconify-icon icon="f7:person"></iconify-icon>
                    </span>
                    <input type="text" class="form-control"
                        placeholder="{{ $selected_supplier ? $selected_supplier->name : ($lang->data['select_a_supplier'] ?? 'Select A Supplier') }}" required=""
                        wire:model.live="search_suppliers">
                    @if (!empty($search_suppliers) && count($filteredSuppliers) > 0)
                    <a href="#"
                        class="tw-absolute tw-top-[100%] tw-left-0 tw-w-full tw-z-20 tw-shadow-md tw-bg-white tw-rounded-lg ">
                        @foreach ($filteredSuppliers as $supplier)
                        <li class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900"
                            wire:click="selectSupplier({{ $supplier->id }})">{{ $supplier->name }}</li>
                        @endforeach
                    </a>
                    @endif
                </div>

            </div>

            <div class="d-flex tw-gap-2">
                <button class="btn tw-bg-gray-100 text-sm btn-sm radius-8 d-flex align-items-center gap-2" wire:click.prevent="resetAll"> {{ $lang->data['clear_all'] ?? 'Clear All' }}</button>
                <button class="btn btn-primary text-sm btn-sm radius-8 d-flex align-items-center gap-2" wire:click.prevent="savePurchaseReturn()">{{ $lang->data['save'] ?? 'Save' }}</button>
            </div>
        </div>
        @error('search_suppliers')
        <div class=" tw-px-3">
            <span class="tw-text-red-500 tw-text-xs">{{ $message }}</span>
        </div>
        @enderror

        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex gap-2">
                <div class="icon-field  tw-relative  tw-items-center">
                    <span class="icon -tw-translate-y-[2px]">
                        <iconify-icon icon="mdi:file-document"></iconify-icon>
                    </span>
                    <input type="text"
                        class="form-control"
                        placeholder="{{ $lang->data['purchase_number'] ?? 'Purchase Number' }}"
                        required
                        wire:model.live="purchase_number">
                    @error('purchase_number')
                    <div class=" tw-px-3">
                        <span class="tw-text-red-500 tw-text-xs">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
                <div class="icon-field  tw-relative  tw-items-center">
                    <span class="icon -tw-translate-y-[2px]">
                        <iconify-icon icon="mdi:file-document"></iconify-icon>
                    </span>
                    <input type="text"
                        class="form-control"
                        placeholder=" {{ $lang->data['invoice_number'] ?? 'Invoice Number' }}"
                        required
                        wire:model.live="invoice_number">
                    @error('invoice_number')
                    <div class=" tw-px-3">
                        <span class="tw-text-red-500 tw-text-xs">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
                <div class="icon-field  tw-relative  tw-items-center">
                    <span class="icon -tw-translate-y-[2px]">
                        <iconify-icon icon="f7:person"></iconify-icon>
                    </span>
                    <input type="date"
                        class="form-control"
                        required
                        wire:model.live="invoice_date">
                    @error('invoice_date')
                    <div class=" tw-px-3">
                        <span class="tw-text-red-500 tw-text-xs">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="tw-flex gap-2">
                @can('customer_create')
                <div class=" tw-bg-gray-100 text-sm btn-sm radius-8 d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                    {{ $next_number }}
                </div>
                @endcan
                @can('customer_create')
                <div class=" tw-bg-gray-100 text-sm btn-sm radius-8 d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                    {{ $current_date }}
                </div>
                @endcan
            </div>
        </div>

        <div class="tw-flex-1 tw-overflow-y-auto ">
            <div
            class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center  tw-w-full gap-3 justify-content-between tw-relative">
            <div class="icon-field has-validation tw-w-full">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
                </span>
                <input type="text" class="form-control" wire:model.live="search_products"
                    placeholder="{{ $lang->data['search_product'] ?? 'Search Product' }}" required="">
                @if (!empty($search_products) && count($filteredProducts) > 0)
                    <ul
                        class="tw-bg-white tw-border tw-rounded-md tw-mt-2 tw-shadow-md tw-z-20 tw-absolute tw-w-full tw-max-h-60 tw-overflow-y-auto">
                        @foreach ($filteredProducts as $product)
                            <li wire:click="selectProduct({{ $product->id }})"
                                class="tw-px-4 tw-py-2 hover:tw-bg-gray-100 tw-cursor-pointer">
                                {{ $product->name }}
                            </li>
                        @endforeach
                    </ul>
                @elseif(!empty($search_products))
                <div
                    class="tw-absolute tw-top-[100%] tw-left-0 tw-p-2 tw-w-full tw-z-20 tw-shadow-md tw-bg-white tw-rounded-lg ">
                    {{$lang->data['no_results_found'] ?? 'No Results Found'}}
                </div>
                @endif
            </div>
        </div>

            <div class="card-body p-0">
                <div class="table-responsive scroll-sm tw-py-1.5 tw-px-3 tw-overflow-y-auto tw-h-[calc(100vh-29.2rem)]">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{$lang->data['name'] ?? 'Name'}}</th>
                                <th>{{$lang->data['qty'] ?? 'QTY'}}</th>
                                <th>{{$lang->data['rate'] ?? 'Rate'}}</th>
                                <th class="text-center">{{$lang->data['discount'] ?? 'Discount'}}</th>
                                <th class="text-center">{{$lang->data['tax'] ?? 'Tax'}}</th>
                                <th class="text-center">{{$lang->data['total'] ?? 'Total'}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['product']['name'] }}</td>
                                <td>
                                    <input type="number" class="form-control tw-text-sm tw-py-1 tw-px-2 text-center"
                                        wire:model.live="cart.{{ $index }}.quantity" wire:input="calculateTotal">
                                </td>
                                <td>
                                    <input type="number" class="form-control tw-text-sm tw-py-1 tw-px-2 text-center"
                                        wire:model="cart.{{ $index }}.rate" wire:input="calculateTotal">
                                </td>
                                <td>
                                    <input type="number" class="form-control tw-text-sm tw-py-1 tw-px-2 text-center"
                                        wire:model="cart.{{ $index }}.discount"
                                        value="0" min="0" wire:input="calculateTotal">
                                </td>
                                <td class="text-center">
                                    {{ $tax_rate }}%
                                </td>
                                <td class="text-center">
                                    {{getFormattedCurrency($item['total'])}}
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-10 justify-content-center">
                                        <a href="#" wire:click="removeProduct({{ $index }})"
                                            type="button"
                                            class="remove-item-button bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle">
                                            <iconify-icon icon="fluent:delete-24-regular"
                                                class="menu-icon"></iconify-icon>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tw-bg-white  tw-pt-12">
            <div class="tw-flex tw-gap-8 tw-items-start  tw-px-3 ">
                <div class="tw-w-[60%] tw-space-y-6">
                    <div class="tw-flex tw-gap-6">
                        <div class="tw-flex tw-flex-col tw-w-[200px]">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-2">{{ $lang->data['notes'] ?? 'Notes/Remarks' }}</label>
                            <textarea class="form-control radius-8" rows="3" placeholder="{{ $lang->data['note'] ?? 'Enter Note/Remarks' }}" wire:model.live="note"></textarea>
                        </div>
                        <div class="tw-flex tw-flex-col tw-w-[200px]">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-2">{{ $lang->data['reason'] ?? 'Reason' }}</label>
                            <textarea class="form-control radius-8" rows="3" placeholder="{{ $lang->data['enter_reason_for_return'] ?? 'Enter Reason For Return' }}" wire:model.live="return_reason"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="tw-w-[35%] tw-h-full tw-justify-end  tw-flex tw-flex-col ">
                    <div class=" tw-rounded-lg  tw-space-y-1 tw-text-xs tw-font-medium " >
                        <div class="tw-flex tw-justify-between">
                            <span>{{ $lang->data['sub_total'] ?? 'Sub Total' }}</span>
                            <span>{{getFormattedCurrency($cartData['sub_total'] ?? 0)}}</span>
                        </div>
                        <div class="tw-flex tw-justify-between">
                            <span>{{ $lang->data['discount'] ?? 'Discount' }}</span>
                            <span>{{getFormattedCurrency($cartData['discount'] ?? 0)}}</span>
                        </div>
                        <div class="tw-flex tw-justify-between">
                            <span>{{ $lang->data['taxable_amount'] ?? 'Taxable Amount' }}</span>
                            <span>{{getFormattedCurrency($cartData['sub_total'] ?? 0)}}</span>
                        </div>
                        <div class="tw-flex tw-justify-between">
                            <span>{{ $lang->data['tax_amount'] ?? 'Tax Amount' }}</span>
                            <span>{{getFormattedCurrency($cartData['tax_amount'] ?? 0)}}</span>
                        </div>
                        <div class="tw-flex tw-justify-between tw-text-base tw-font-bold border-t pt-2">
                            <span>{{ $lang->data['gross_total'] ?? 'Gross Total' }}</span>
                            <span>{{getFormattedCurrency($cartData['total'] ?? 0)}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>