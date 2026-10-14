<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <form class="navbar-search">
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="{{$lang->data['search_here'] ?? 'Search Here'}}" wire:model.live="search_query">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
            @can('service_create')
                <a href="{{route('service.manage')}}" type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                    <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                    {{$lang->data['add_new_service'] ?? 'Add New Service'}}
                </a>
            @endcan
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="">{{$lang->data['service_name'] ?? 'Service Name'}}</th>
                            <th scope="col" class="">{{$lang->data['service_types'] ?? 'Service Types'}}</th>
                            <th scope="col" class="">{{$lang->data['status'] ?? 'Status'}}</th>
                            <th scope="col" class="text-center">{{ $lang->data['action'] ?? 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($services)>0)
                        @foreach ($services as $item)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td class="">
                                <div class="tw-flex tw-gap-2 tw-items-center">
                                    <div class="tw-aspect-square tw-w-10 tw-rounded-lg tw-overflow-clip">
                                        <img src="{{$item->image()}}" alt="" class="tw-h-full tw-w-full tw-object-cover">
                                    </div>
                                    {{$item->service_name}}
                                </div>
                            </td>
                            <td class="">
                                <div class="tw-flex tw-flex-col tw-gap-0.5 tw-items-center">
                                    @php
                                    $details = \App\Models\ServiceDetail::where('service_id',$item->id)->get();
                                    @endphp
                                    @if($details)
                                    @foreach ($details as $row)
                                    @php
                                    $type = \App\Models\ServiceType::where('id',$row->service_type_id)->first();
                                    @endphp
                                    <span class="tw-bg-gray-200  tw-px-2 tw-text-xs tw-text-gray-600 tw-font-normal tw-rounded tw-py-0.5">{{$type->service_type_name}}</span>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="">
                                @if($item->is_active == 1)
                                <span class=" text-sm fw-semibold text-success-600 bg-success-100 tw-px-2 tw-py-0.5 tw-rounded-lg text-white">{{$lang->data['active'] ?? 'Active'}}</span>
                                @else
                                <span class=" text-sm fw-semibold text-danger-600 tw-bg-red-100 tw-px-2 tw-py-0.5 tw-rounded-lg text-white">{{$lang->data['inactive'] ?? 'InActive'}}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    @can('service_edit')
                                    <a type="button" href="{{route('service.edit',$item->id)}}" class="tw-bg-blue-100 tw-text-blue-600 hover:tw-bg-blue-300 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                    </a>
                                    @endcan
                                    @can('service_delete')
                                    <button type="button" wire:click="delete({{$item->id}})" class="remove-item-button bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle">
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
                @if(count($services) == 0)
                    <x-empty-item/>
                @endif
            </div>  
        </div>
    </div>
</div>