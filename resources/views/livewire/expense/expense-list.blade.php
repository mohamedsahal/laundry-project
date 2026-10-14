<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                
                <form class="navbar-search">
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>

            @can('expense_create')
            <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#exampleModal" wire:click="resetInputFields()">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                {{ $lang->data['add_new_expense'] ?? 'Add New Expense' }}
            </button>
            @endcan
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                  <thead>
                    <tr>
                      <th scope="col">{{ $lang->data['date'] ?? 'Date' }}</th>
                      <th scope="col" class="">{{ $lang->data['amount'] ?? 'Amount' }}</th>
                      <th scope="col" class="">{{ $lang->data['towards'] ?? 'Towards' }}</th>
                      <th scope="col" class="">{{ $lang->data['tax_included'] ?? 'Tax Included' }}</th>
                      <th scope="col" class="">{{ $lang->data['payment_mode'] ?? 'Payment Mode' }}</th>
                      <th scope="col" class="">{{ $lang->data['created_by'] ?? 'Created By' }}</th>
                      <th scope="col" class="text-center">{{ $lang->data['action'] ?? 'Action' }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($expenses)>0)
                  @foreach ($expenses as $row)
                        <tr>
                            <td> {{ date('d/m/Y', strtotime($row->expense_date)) }}</td>
                            <td class="text-primary">{{ $row->expense_amount }}</td>
                            <td class="">
                                <span class="badge text-sm fw-semibold text-info-600 bg-info-100 px-20 py-9 radius-4 text-white">
                                {{ $row->expenseCategory->expense_category_name }}
                                </span>
                            </td>
                            <td class="">
                                <span class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4 text-white">
                                @if ($row->tax_included)
                                                    {{ $lang->data['yes'] ?? 'YES' }}
                                                @else
                                                    {{ $lang->data['no'] ?? 'No' }}
                                                @endif
                                </span>
                            </td>
                            <td class="">
                                <span class="badge text-sm fw-semibold text-warning-600 bg-warning-100 px-20 py-9 radius-4 text-white">
                                {{ getpaymentMode($row->payment_mode) }}
                                </span>
                            </td>
                            <td class="">
                            {{ $row->user->name ?? "" }}
                            </td>
                            <td class="text-center"> 
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    @can('expense_edit')
                                        <button type="button" class="bg-info-100 text-info-600 bg-hover-info-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal"  wire:click="edit({{ $row->id }})">
                                            <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                        </button>
                                    @endcan
                                    @can('expense_delete')
                                        <button type="button" class="remove-item-button bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle" wire:click="delete({{ $row->id }})"> 
                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                        </button>
                                    @endcan
                                    
                                </div>
                            </td> 
                        </tr>
                  @endforeach
                        @endif
                    </tbody>
                </table>
                @if(count($expenses) == 0)
                    <x-empty-item/>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">{{ $lang->data['add_expense'] ?? 'Add Expense' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">   
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['date'] ?? 'Date' }} </label>
                                <input type="date" class="form-control radius-8" wire:model="expense_date" >
                                @error('expense_date')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @php
                                    $inline_categories = App\Models\ExpenseCategory::latest()->get();
                                @endphp
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['expense_category'] ?? 'Expense Category' }} <span class="text-danger">*</span></label>
                                <select name="" id="" class="form-select radius-8" wire:model="expense_category_id">
                                    <option value="">
                                        {{ $lang->data['choose_expense_category'] ?? 'Choose Expense Category' }}   
                                    </option>
                                    @foreach ($inline_categories as $row)
                                        <option value={{ $row->id }}>{{ $row->expense_category_name }}</option>
                                    @endforeach
                                </select>
                                @error('expense_category_id')
                                    <span class="error text-danger">{{ 'Expense Category Required' }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['expense_amount'] ?? 'Expense Amount' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8" placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"  wire:model="expense_amount">
                                @error('expense_amount')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['payment_mode'] ?? 'Payment Mode' }} <span class="text-danger">*</span></label>
                                <select name="" id="" class="form-select radius-8" wire:model="payment_mode">
                                    <option value="">
                                        {{ $lang->data['choose_payment_mode'] ?? 'Choose Payment Mode' }}
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
                            <div class="col-6  tw-flex tw-flex-col">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['tax_included'] ?? 'Tax Included' }}</label>
                                <div class="btn-group mb-20" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" checked="" wire:model.live="tax_included" value="1">
                                    <label class="btn btn-outline-success-600 px-20 py-11 radius-8" for="btnradio1">{{ $lang->data['yes'] ?? 'Yes' }}</label>
                                  
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2"  wire:model.live="tax_included" value="0">
                                    <label class="btn btn-outline-warning-600 px-20 py-11" for="btnradio2">{{ $lang->data['no'] ?? 'No' }}</label>
                                </div>
                            </div>
                            @if ($tax_included == 1)
                            <div class="col-6 ">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['tax_percentage'] ?? 'Tax Percentage' }} <span class="text-danger">*</span></label>
                                <input type="number"  class="form-control radius-8" placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"  wire:model="tax_percentage">
                                @error('tax_percentage')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                            </div>
                            @endif
                            <div class="col-12 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['notes'] ?? 'Notes' }} </label>
                                <textarea class="form-control radius-8" placeholder="{{ $lang->data['enter_notes'] ?? 'Enter Notes' }}"  wire:model="note"></textarea>
                                @error('note')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex align-items-start justify-content-center gap-3 mt-24">
                                <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8" wire:click.prevent="$dispatch('closemodal')"> 
                                {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8" wire:click.prevent="store">
                                {{ $lang->data['save'] ?? 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">{{ $lang->data['add_expense'] ?? 'Add Expense' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">   
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['date'] ?? 'Date' }} </label>
                                <input type="date" class="form-control radius-8" wire:model="expense_date" >
                                @error('expense_date')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @php
                                    $inline_categories = App\Models\ExpenseCategory::latest()->get();
                                @endphp
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['expense_category'] ?? 'Expense Category' }} <span class="text-danger">*</span></label>
                                <select name="" id="" class="form-select radius-8" wire:model="expense_category_id">
                                    <option value="">
                                        {{ $lang->data['choose_expense_category'] ?? 'Choose Expense Category' }}   
                                    </option>
                                    @foreach ($inline_categories as $row)
                                        <option value={{ $row->id }}>{{ $row->expense_category_name }}</option>
                                    @endforeach
                                </select>
                                @error('expense_category_id')
                                    <span class="error text-danger">{{ 'Expense Category Required' }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['expense_amount'] ?? 'Expense Amount' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8" placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"  wire:model="expense_amount">
                                @error('expense_amount')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['payment_mode'] ?? 'Payment Mode' }} <span class="text-danger">*</span></label>
                                <select name="" id="" class="form-select radius-8" wire:model="payment_mode">
                                    <option value="">
                                        {{ $lang->data['choose_payment_mode'] ?? 'Choose Payment Mode' }}
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
                            <div class="col-6  tw-flex tw-flex-col">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['tax_included'] ?? 'Tax Included' }}</label>
                                <div class="btn-group mb-20" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1"  wire:model.live="tax_included" value="1">
                                    <label class="btn btn-outline-success-600 px-20 py-11 radius-8" for="btnradio1">{{ $lang->data['yes'] ?? 'Yes' }}</label>
                                  
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2"  wire:model.live="tax_included" value="0">
                                    <label class="btn btn-outline-warning-600 px-20 py-11" for="btnradio2">{{ $lang->data['no'] ?? 'No' }}</label>
                                </div>
                            </div>
                            @if ($tax_included == 1)
                            <div class="col-6 ">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['tax_percentage'] ?? 'Tax Percentage' }} <span class="text-danger">*</span> </label>
                                <input type="number"  class="form-control radius-8" placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"  wire:model="tax_percentage">
                                @error('tax_percentage')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                            </div>
                            @endif
                            <div class="col-12 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['notes'] ?? 'Notes' }} </label>
                                <textarea class="form-control radius-8" placeholder="{{ $lang->data['enter_notes'] ?? 'Enter Notes' }}"  wire:model="note"></textarea>
                                @error('note')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex align-items-start justify-content-center gap-3 mt-24">
                                <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8" wire:click.prevent="$dispatch('closemodal')"> 
                                {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8" wire:click.prevent="store">
                                {{ $lang->data['save'] ?? 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <livewire:components.check-financial-year-component/>
</div>