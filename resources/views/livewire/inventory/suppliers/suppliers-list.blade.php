<div class="dashboard-main-body">
    <div class="p-0 card h-100 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="flex-wrap gap-3 d-flex align-items-center">
                <form class="navbar-search">
                    <input type="text" class="w-auto bg-base h-40-px" name="search"
                        placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
            @can('service_create')
                <button type="button" class="gap-2 text-sm btn btn-primary btn-sm radius-8 d-flex align-items-center"
                    data-bs-toggle="modal" data-bs-target="#exampleModal" wire:click="resetInputFields()">
                    <iconify-icon icon="ic:baseline-plus" class="text-xl icon line-height-1"></iconify-icon>
                    {{ $lang->data['add_new_supplier'] ?? 'Add New Supplier' }}
                </button>
            @endcan
        </div>
        <div class="p-0 card-body">
            <div class="table-responsive scroll-sm">
                <table class="table mb-0 bordered-table sm-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="">{{ $lang->data['supplier_name'] ?? 'Supplier Name' }}</th>
                            <th scope="col" class="">{{ $lang->data['phone'] ?? 'Phone' }}</th>
                            <th scope="col" class="">{{ $lang->data['tax_number'] ?? 'Tax Number' }}</th>
                            <th scope="col" class="">{{ $lang->data['opening_balance'] ?? 'Opening Balance' }}</th>
                            <th scope="col" class="">{{ $lang->data['address'] ?? 'Address' }}</th>
                            <th scope="col" class="">{{ $lang->data['email'] ?? 'Email' }}</th>
                            <th scope="col" class="text-center">{{ $lang->data['action'] ?? 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($suppliers as $row)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td class="">{{ $row->name }}</td>
                                <td class="">
                                    <p>{{ getCountryCode() }}{{ (int) $row->phone }}</p>
                                </td>
                                 <td class="">
                                      {{$row->tax_number ? :'N/A'}} 
                                </td>
                                <td class="">
                                      {{ $row->opening_balance }} 
                                </td>
                                <td class="">
                                    {{ !empty($row->address) ? $row->address : 'N/A' }} 
                                </td>
                                <td class="">
                                    {{ !empty($row->email) ? $row->email : 'N/A' }}
                                </td>
                                <td class="text-center">
                                    <div class="gap-10 d-flex align-items-center justify-content-center">
                                        @can('supplier_edit')
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#editModal"
                                                wire:click="edit({{ $row->id }})"
                                                class="bg-info-100 text-info-600 bg-hover-info-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle"
                                                data-bs-toggle="modal" data-bs-target="#exampleModalEdit">
                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                            </button>
                                        @endcan
                                        @can('supplier_delete')
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

                    </tbody>
                </table>
            </div>
            @if (count($suppliers) == 0)
                <x-empty-item />
            @endif

        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="px-24 py-16 border modal-header border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">
                        {{ $lang->data['add_new_supplier'] ?? 'Add New Supplier' }}</h1>
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
                                @error('opening_balance')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20 col-6">
                                <label for="name"
                                    class="mb-8 text-sm form-label fw-semibold text-primary-light">{{ $lang->data['email'] ?? 'Email' }}
                                    </label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_email'] ?? 'Enter Email' }}"
                                    wire:model="email">
                                @error('email')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
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
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="px-24 py-16 border modal-header border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">
                        {{ $lang->data['edit_supplier'] ?? 'Edit Supplier' }}</h1>
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
                                    
                                <input type="number" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_tax_number'] ?? 'Enter Tax Number' }}"
                                    wire:model="tax_number"> 
                            </div>
                            <div class="mb-20 col-6">
                                <label for="name"
                                    class="mb-8 text-sm form-label fw-semibold text-primary-light">{{ $lang->data['opening_balance'] ?? 'Opening Balance' }}
                                     
                                <input type="number" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_opening_balance'] ?? 'Enter Opening Balance' }}"
                                    wire:model="opening_balance"> 
                            </div>
                            <div class="mb-20 col-6">
                                <label for="name"
                                    class="mb-8 text-sm form-label fw-semibold text-primary-light">{{ $lang->data['email'] ?? 'Email' }}
                                    
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
