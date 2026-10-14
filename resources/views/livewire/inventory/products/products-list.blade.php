<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <form class="navbar-search">
                    <input type="text" class="bg-base h-40-px w-auto" name="search"
                        placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
            @can('customer_create')
            <button type="button" class="btn btn-primary text-sm btn-sm radius-8 d-flex align-items-center gap-2"
                data-bs-toggle="modal" data-bs-target="#exampleModal" wire:click="resetInputFields()">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                {{ $lang->data['add_new_product'] ?? 'Add New Product' }}
            </button>
            @endcan
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="">{{ $lang->data['product_name'] ?? 'Product Name' }}</th>
                            <th scope="col" class="">{{ $lang->data['category'] ?? 'Category' }}</th>
                            <th scope="col" class="">{{ $lang->data['unit'] ?? 'Unit' }}</th>
                            <th scope="col" class="">{{ $lang->data['sku'] ?? 'Sku' }}</th>
                            <th scope="col" class="">{{ $lang->data['purchase_price'] ?? 'Purchase Price' }}
                            </th>
                            <th scope="col" class="">{{ $lang->data['available_stock'] ?? 'Available Stock' }}
                            </th>
                            <th scope="col" class="">
                                {{ $lang->data['minimum_stock_level'] ?? 'Minimum Stock Level' }}
                            </th>
                            <th scope="col" class="">
                                {{ $lang->data['status'] ?? 'Status' }}
                            </th>
                            <th scope="col" class="text-center">{{ $lang->data['action'] ?? 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($products) > 0)
                        @foreach ($products as $row)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="">{{ $row->name }}</td>
                            <td class="">{{ $row->category?->name }}</td>
                            <td class="">{{ $row->unit? $row->unit->name : '-' }}</td>
                            <td class="">{{ $row->sku }}</td>
                            <td class="">
                                <p>{{ getCurrency() }} {{ (int) $row->purchase_price }}.00</p>
                            </td>
                            <td class="">{{ $row->current_stock}}</td>
                            <td class="">{{ $row->minimum_stock_level }}</td>
                            <td class="">
                                @if ($row->is_active == 1)
                                <span
                                    class=" text-sm fw-semibold text-success-600 bg-success-100 tw-px-2 tw-py-0.5 tw-rounded-lg text-white">{{ $lang->data['active'] ?? 'Active' }}</span>
                                @else
                                <span
                                    class=" text-sm fw-semibold text-danger-600 tw-bg-red-100 tw-px-2 tw-py-0.5 tw-rounded-lg text-white">{{ $lang->data['inactive'] ?? 'InActive' }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    @can('customer_edit')
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#editModal"
                                        wire:click="edit({{ $row->id }})"
                                        class="bg-info-100 text-info-600 bg-hover-info-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle"
                                        data-bs-toggle="modal" data-bs-target="#exampleModalEdit">
                                        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                    </button>
                                    @endcan
                                    @can('customer_delete')
                                    <a href="#" wire:click="delete({{ $row->id }})" type="button"
                                        class="remove-item-button bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="fluent:delete-24-regular"
                                            class="menu-icon"></iconify-icon>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                @if ($hasMorePages)
                <div x-data="{
                        init() {
                            let observer = new IntersectionObserver((entries) => {
                                entries.forEach(entry => {
                                    if (entry.isIntersecting) {
                                        @this.call('loadCustomers')
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
            @if (count($products) == 0)
            <x-empty-item />
            @endif
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">
                        {{ $lang->data['add_new_product'] ?? 'Add New Product' }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['product_name'] ?? 'Product Name' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_product_name'] ?? 'Enter Product Name' }}"
                                    wire:model="name">
                                @error('name')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['category'] ?? 'Category' }}<span
                                        class="text-danger">*</span></label>
                                <select name="" id="" class="form-select radius-8"
                                    wire:model="category_id">
                                    <option class="select-box" value="">
                                        {{ $lang->data['choose_category'] ?? 'Choose Category' }}
                                    </option>
                                    @foreach ($categories as $row)
                                    <option class="select-box" value="{{ $row->id }}">
                                        {{ $row->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['unit'] ?? 'Unit' }}<span
                                        class="text-danger">*</span></label>
                                <select name="" id="" class="form-select radius-8"
                                    wire:model="unit_id">
                                    <option class="select-box" value="">
                                        {{ $lang->data['choose_unit'] ?? 'Choose Unit' }}
                                    </option>
                                    @foreach ($units as $item)
                                    <option class="select-box" value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['sku'] ?? 'SKU' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_sku'] ?? 'Enter SKU' }}" wire:model="sku">
                                @error('sku')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['purchase_price'] ?? 'Purchase Price' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_purchase_price'] ?? 'Enter Purchase Price' }}"
                                    wire:model="purchase_price">
                                @error('purchase_price')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['opening_stock'] ?? 'Opening Stock' }}</label>
                                <input type="number" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_opening_stock'] ?? 'Enter Opening Stock' }}"
                                    wire:model="opening_stock">
                                    @error('opening_stock')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['minimum_stock_level'] ?? 'Minimum Stock Level' }}</label>
                                <input type="number" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_minimum_stock_level'] ?? 'Enter Minimum Stock Level' }}"
                                    wire:model="minimum_stock_level">
                                    @error('minimum_stock_level')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="col-12 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['description'] ?? 'Description' }}</label>
                                <textarea class="form-control radius-8" placeholder="{{ $lang->data['enter_description'] ?? 'Enter Description' }}"
                                    wire:model="description"></textarea>
                            </div>
                            <div class="tw-flex w-full tw-items-center tw-justify-between">
                                <div class="">
                                    <div class="col-12 tw-mt-6">
                                        <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="switch1" checked="" wire:model="is_consumable">
                                            <label
                                                class="form-check-label line-height-1 fw-medium text-secondary-light"
                                                for="switch1">{{ $lang->data['is_consumable'] ?? 'Is Consumable' }}
                                                ?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="col-12 tw-mt-6">
                                        <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="switch1" checked="" wire:model="is_active">
                                            <label
                                                class="form-check-label line-height-1 fw-medium text-secondary-light"
                                                for="switch1">{{ $lang->data['is_active'] ?? 'Is Active' }}
                                                ?</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-start justify-content-end gap-3 mt-24">
                                <button type="reset"
                                    class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8"
                                    wire:click.prevent="$dispatch('closemodal')">
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="submit"
                                    class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8"
                                    wire:click.prevent="save">
                                    {{ $lang->data['save'] ?? 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">
                        {{ $lang->data['edit_product'] ?? 'Edit Product' }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['product_name'] ?? 'Product Name' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_product_name'] ?? 'Enter Product Name' }}"
                                    wire:model="name">
                                @error('name')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['category'] ?? 'Category' }}<span
                                        class="text-danger">*</span></label>
                                <select name="" id="" class="form-select radius-8"
                                    wire:model="category_id">
                                    <option class="select-box" value="">
                                        {{ $lang->data['choose_category'] ?? 'Choose Category' }}
                                    </option>
                                    @foreach ($categories as $row)
                                    <option class="select-box" value="{{ $row->id }}">
                                        {{ $row->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['unit'] ?? 'Unit' }}<span
                                        class="text-danger">*</span></label>
                                <select name="" id="" class="form-select radius-8"
                                    wire:model="unit_id">
                                    <option class="select-box" value="">
                                        {{ $lang->data['choose_unit'] ?? 'Choose Unit' }}
                                    </option>
                                    @foreach ($units as $item)
                                    <option class="select-box" value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['sku'] ?? 'SKU' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_sku'] ?? 'Enter SKU' }}" wire:model="sku">
                                @error('sku')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['purchase_price'] ?? 'Purchase Price' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_purchase_price'] ?? 'Enter Purchase Price' }}"
                                    wire:model="purchase_price">
                                @error('purchase_price')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['opening_stock'] ?? 'Opening Stock' }}</label>
                                <input type="number" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_opening_stock'] ?? 'Enter Opening Stock' }}"
                                    wire:model="opening_stock">
                                    @error('opening_stock')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['minimum_stock_level'] ?? 'Minimum Stock Level' }}</label>
                                <input type="number" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_minimum_stock_level'] ?? 'Enter Minimum Stock Level' }}"
                                    wire:model="minimum_stock_level">
                                    @error('minimum_stock_level')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="col-12 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['description'] ?? 'Description' }}</label>
                                <textarea class="form-control radius-8" placeholder="{{ $lang->data['enter_description'] ?? 'Enter Description' }}"
                                    wire:model="description"></textarea>
                            </div>
                            <div class="tw-flex w-full tw-items-center tw-justify-between">
                                <div class="">
                                    <div class="col-12 tw-mt-6">
                                        <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="switch1" checked="" wire:model="is_consumable">
                                            <label
                                                class="form-check-label line-height-1 fw-medium text-secondary-light"
                                                for="switch1">{{ $lang->data['is_consumable'] ?? 'Is Consumable' }}
                                                ?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="col-12 tw-mt-6">
                                        <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="switch1" checked="" wire:model="is_active">
                                            <label
                                                class="form-check-label line-height-1 fw-medium text-secondary-light"
                                                for="switch1">{{ $lang->data['is_active'] ?? 'Is Active' }}
                                                ?</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-start justify-content-end gap-3 mt-24">
                                <button type="reset"
                                    class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8"
                                    wire:click.prevent="$dispatch('closemodal')">
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="submit"
                                    class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8"
                                    wire:click.prevent="update">
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