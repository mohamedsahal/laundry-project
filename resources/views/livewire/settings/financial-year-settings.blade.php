<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <form class="navbar-search">
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search_query">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
            <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addyear" wire:click="resetFields()">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                {{ $lang->data['add_financial_year'] ?? 'Add Financial year' }}
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col" class="">{{ $lang->data['name'] ?? 'Name' }}</th>
                      <th scope="col" class="">{{ $lang->data['start_date'] ?? 'Start Date' }}</th>
                      <th scope="col" class="">{{ $lang->data['end_date'] ?? 'End Date' }}</th>
                      <th scope="col" class="text-center">{{ $lang->data['action'] ?? 'Action' }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($years)>0)
                  @foreach ($years as $item)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td class="">{{$item->year}}</td>
                            <td class="">{{\Carbon\Carbon::parse($item->starting_date)->format('d/m/Y')}}</td>
                            <td class="">{{\Carbon\Carbon::parse($item->ending_date)->format('d/m/Y')}} </td>
                            <td class="text-center"> 
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    <button type="button" class="bg-info-100 text-info-600 bg-hover-info-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle" wire:click="edit({{$item->id}})" data-bs-toggle="modal" data-bs-target="#edityear">
                                        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                    </button>
                                </div>
                            </td> 
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="text-center">No records found...</td>
                        </tr>
                        @endif
                  </tbody>
                </table>
            </div>
            
        </div>
    </div>

    <div class="modal fade" id="addyear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self >
        <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">{{$lang->data['add_financial_year'] ?? 'Add Financial Year'}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">   
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{$lang->data['year'] ?? 'Year'}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8" id="name"  wire:model="year">
                                @error('year') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="date" class="form-label fw-semibold text-primary-light text-sm mb-8">{{$lang->data['start_date'] ?? 'Start Date'}} </label>
                                <input type="date" class="form-control radius-8" id="date" wire:model="start_date">
                            </div>
                            <div class="col-6">
                                <label for="end_date" class="form-label fw-semibold text-primary-light text-sm mb-8">{{$lang->data['end_date'] ?? 'End Date'}} </label>
                                <input type="date" class="form-control radius-8" id="end_date" wire:model="end_date">
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8" wire:click.prevent="$dispatch('closemodal')"> 
                                {{$lang->data['cancel'] ?? 'Cancel'}}
                                </button>
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8" wire:click.prevent="create"> 
                                {{$lang->data['save'] ?? 'Save'}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edityear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self >
        <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">{{$lang->data['edit_financial_year'] ?? 'Edit Financial Year'}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">   
                            <div class="col-6 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{$lang->data['year'] ?? 'Year'}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8" id="name"  wire:model="year">
                                @error('year') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="date" class="form-label fw-semibold text-primary-light text-sm mb-8">{{$lang->data['start_date'] ?? 'Start Date'}} </label>
                                <input type="date" class="form-control radius-8" id="date" wire:model="start_date">
                            </div>
                            <div class="col-6">
                                <label for="end_date" class="form-label fw-semibold text-primary-light text-sm mb-8">{{$lang->data['end_date'] ?? 'End Date'}} </label>
                                <input type="date" class="form-control radius-8" id="end_date" wire:model="end_date">
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8" wire:click.prevent="$dispatch('closemodal')"> 
                                {{$lang->data['cancel'] ?? 'Cancel'}}
                                </button>
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8" wire:click.prevent="update"> 
                                {{$lang->data['save'] ?? 'Save'}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
