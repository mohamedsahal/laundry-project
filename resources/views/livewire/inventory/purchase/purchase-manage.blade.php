<div class="dashboard-main-body">
    <div class="card  p-0 radius-12 tw-flex tw-flex-col">
        <div class="tw-flex tw-justify-between tw-py-2 tw-px-3">
            <div class="d-flex gap-2">
                <div class="icon-field  tw-relative tw-w-full tw-items-center">
                    <span class="icon -tw-translate-y-[2px]">
                        <iconify-icon icon="f7:person"></iconify-icon>
                    </span>
                    <input type="text" class="form-control"
                        placeholder="{{ $selected_supplier ? $selected_supplier->name : $lang->data['select_a_supplier'] ?? 'Select A Supplier' }}"
                        required="" wire:model.live="search_suppliers">
                    @if (!empty($search_suppliers) && count($filteredSuppliers) > 0)
                        <div
                            class="tw-absolute tw-top-[100%] tw-left-0 tw-w-full tw-z-20 tw-shadow-md tw-bg-white tw-rounded-lg ">
                            @foreach ($filteredSuppliers as $supplier)
                                <li class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900"
                                    wire:click="selectSupplier({{ $supplier->id }})">{{ $supplier->name }}</li>
                            @endforeach
                        </div>

                    @elseif(!empty($search_suppliers))
                    <div
                        class="tw-absolute tw-top-[100%] tw-left-0 tw-p-2 tw-w-full tw-z-20 tw-shadow-md tw-bg-white tw-rounded-lg ">
                        {{$lang->data['no_results_found'] ?? 'No Results Found'}}
                    </div>
                    @endif
                </div>
                @can('order_create')
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addSupplier"
                        wire:click="resetInputFields"
                        class="tw-px-4 tw-py-3 bg-primary-600 tw-rounded-md tw-text-white tw-flex tw-items-center tw-gap-1.5 tw-border-0 tw-shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-person-fill-add" viewBox="0 0 16 16">
                            <path
                                d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path
                                d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4" />
                        </svg>
                    </button>
                @endcan
            </div>
            <div class="d-flex tw-gap-2 ">
                <button class="btn tw-bg-gray-100 text-sm btn-sm radius-8 d-flex align-items-center gap-2"
                    wire:click.prevent="resetAll">{{$lang->data['clear_all'] ?? 'Clear All'}}</button>
                <button class="btn btn-primary text-sm btn-sm radius-8 d-flex align-items-center gap-2"
                    wire:click="savePurchase"> {{$lang->data['save'] ?? 'Save'}}</button>
            </div>
        </div>
        @error('search_suppliers')
            <div class=" tw-px-3">
                <span class="tw-text-red-500 tw-text-xs">{{ $message }}</span>
            </div>
        @enderror
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex gap-2">
                <div class="col-6">
                    <input type="text" class="form-control radius-8 tw-rounded-md"
                        placeholder="{{ $lang->data['enter_invoice_number'] ?? '#Invoice Number' }}"
                        wire:model="invoice_number">
                    @error('invoice_number')
                        <span class="tw-text-red-500 tw-text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-6">
                    <input type="date" class="form-control radius-8 tw-rounded-md"
                        placeholder="{{ $lang->data['enter_product_name'] ?? 'Enter Product Name' }}"
                        wire:model="invoice_date">
                    @error('invoice_date')
                        <span class="tw-text-red-500 tw-text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="tw-flex gap-2">
                @can('customer_create')
                    <div class=" tw-bg-gray-100 text-sm btn-sm radius-8 d-flex align-items-center gap-2" >
                    {{ $lang->data['purchase'] ?? 'Purchase' }} #:<span class="tw-font-bold">{{ $purchase_number }}</span> 
                    </div>
                @endcan
                @can('customer_create')
                    <div class=" tw-bg-gray-100 text-sm btn-sm radius-8 d-flex align-items-center gap-2" >
                        Date :<span class="tw-font-bold">{{ $current_date }}</span>    
                    </div>
                @endcan
            </div>
        </div>


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
        @error('search_products')
            <div class=" tw-px-3">
                <span class="tw-text-red-500 tw-text-xs">{{ $message }}</span>
            </div>
        @enderror
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm tw-py-1.5 tw-px-3 tw-overflow-y-auto tw-h-[calc(100vh-33rem)]">
                <table class="table bordered-table sm-table mb-0 ">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="">{{ $lang->data['name'] ?? ' Name' }}</th>
                            <th scope="col" class="">{{ $lang->data['qty'] ?? 'QTY' }}</th>
                            <th scope="col" class="">{{ $lang->data['rate'] ?? 'Rate' }}</th>
                            <th scope="col" class="text-center">{{ $lang->data['discount'] ?? 'Discount' }}</th>
                            <th scope="col" class="text-center">{{ $lang->data['tax'] ?? 'Tax' }}</th>
                            <th scope="col" class="text-center">{{ $lang->data['total'] ?? 'Total' }}</th>
                            <th scope="col" class="text-center"></th>
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

        <div class="tw-flex tw-gap-8  tw-py-3 tw-px-3 tw-pt-12">
            <div class="tw-w-[60%] tw-space-y-6">
                <div class="tw-flex tw-gap-6">
                    <div class="tw-flex tw-flex-col tw-w-[250px]">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-2">
                            {{ $lang->data['paid_amount'] ?? 'Paid Amount' }} <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control radius-8" disabled
                            placeholder="{{ $lang->data['paid_amount'] ?? 'Paid Amount' }}" wire:model="paid_amount">
                        @error('paid_amount')
                            <span class="tw-text-red-500 tw-text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="tw-flex tw-flex-col tw-w-[250px]">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-2">
                            {{ $lang->data['payment_method'] ?? 'Payment Method' }} <span class="text-danger">*</span>
                        </label>

                        <select class="form-select radius-8" wire:model="payment_method">
                            <option value="">
                                {{ $lang->data['choose_payment_method'] ?? 'Choose Payment Method' }}
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
                        @error('payment_method')
                            <span class="tw-text-red-500 tw-text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="tw-flex tw-gap-6">
                    <div class="tw-flex tw-flex-col tw-w-[250px]">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-2">
                            {{ $lang->data['notes'] ?? 'Notes/Remarks' }}
                        </label>
                        <textarea class="form-control radius-8" rows="3"
                            placeholder="{{ $lang->data['note'] ?? 'Enter Note/Remarks' }}" wire:model="note"></textarea>
                    </div>
                    <div class="tw-flex tw-flex-col tw-w-[250px]">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-2">
                            {{ $lang->data['payment_remarks'] ?? 'Payment Remarks' }}
                        </label>
                        <textarea class="form-control radius-8" rows="3"
                            placeholder="{{ $lang->data['enter_payment_remarks'] ?? 'Enter Payment Remarks' }}" wire:model="payment_remarks"></textarea>
                    </div>
                </div>
            </div>

            <div class="tw-w-[35%] tw-h-full tw-justify-end  tw-flex tw-flex-col ">
                <div class=" tw-rounded-lg  tw-space-y-1 tw-text-xs tw-font-medium " >
                    <div class="tw-flex tw-justify-between">
                        <span> {{ $lang->data['sub_total'] ?? 'Sub Total' }}</span>
                        <span>{{getFormattedCurrency($cartData['sub_total'] ?? 0)}}</span>
                    </div>
                    <div class="tw-flex tw-justify-between">
                        <span> {{ $lang->data['discount'] ?? 'Discount' }}</span>
                        <span>{{getFormattedCurrency($cartData['discount'] ?? 0)}}</span>
                    </div>
                    <div class="tw-flex tw-justify-between">
                        <span> {{ $lang->data['taxable_amount'] ?? 'Taxable Amount' }}</span>
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
    <div class="modal fade" id="addSupplier" tabindex="-1" aria-labelledby="addSupplier" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="px-24 py-16 border modal-header border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">
                        {{ $lang->data['add_new_supplier'] ?? 'Add New Supplier' }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="p-24 modal-body">
                    <form action="#">
                        <div class="row">
                            <div class="mb-20 col-6">
                                <label for="name"
                                    class="mb-8 text-sm form-label fw-semibold text-primary-light">{{ $lang->data['supplier_name'] ?? 'Supplier Name' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_supplier_name'] ?? 'Enter Supplier Name' }}"
                                    wire:model="name">
                                @error('name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20 col-6">
                                <label for="name"
                                    class="mb-8 text-sm form-label fw-semibold text-primary-light">{{ $lang->data['phone_number'] ?? 'Phone Number' }}
                                    <span class="text-danger">*</span></label>
                                <input type="number" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_phone_number'] ?? 'Enter Phone Number' }}"
                                    wire:model="phone">
                                @error('phone')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20 col-6">
                                <label for="name"
                                    class="mb-8 text-sm form-label fw-semibold text-primary-light">{{ $lang->data['tax_number'] ?? 'Tax Number' }}
                                </label>
                                <input type="number" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_tax_number'] ?? 'Enter Tax Number' }}"
                                    wire:model="tax_number">
                            </div>
                            <div class="mb-20 col-6">
                                <label for="name"
                                    class="mb-8 text-sm form-label fw-semibold text-primary-light">{{ $lang->data['opening_balance'] ?? 'Opening Balance' }}
                                </label>
                                <input type="number" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_opening_balance'] ?? 'Enter Opening Balance' }}"
                                    wire:model="opening_balance">

                            </div>
                            <div class="mb-20 col-6">
                                <label for="name"
                                    class="mb-8 text-sm form-label fw-semibold text-primary-light">{{ $lang->data['email'] ?? 'Email' }}
                                </label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_email'] ?? 'Enter Email' }}"
                                    wire:model="email">

                            </div>

                            <div class="mb-20 col-12">
                                <label for="name"
                                    class="mb-8 text-sm form-label fw-semibold text-primary-light">{{ $lang->data['address'] ?? 'Address' }}</label>
                                <textarea class="form-control radius-8" placeholder="{{ $lang->data['enter_address'] ?? 'Enter Address' }}"
                                    wire:model="address"></textarea>
                            </div>
                            <div class="col-12 tw-mt-6">
                                <div class="gap-3 form-switch switch-primary d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch1"
                                        checked="" wire:model="is_active">
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                        for="switch1">{{ $lang->data['is_active'] ?? 'Is Active' }} ?</label>
                                </div>
                            </div>
                            <div class="gap-3 mt-24 d-flex align-items-start justify-content-end">
                                <button type="reset"
                                    class="px-40 border border-danger-600 bg-hover-danger-200 text-danger-600 text-md py-11 radius-8"
                                    wire:click.prevent="$dispatch('closemodal')">
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="submit"
                                    class="px-24 py-12 border btn btn-primary border-primary-600 text-md radius-8"
                                    wire:click.prevent="store">
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
