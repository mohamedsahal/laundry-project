<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo tw-w-full" title="{{ getApplicationName() }}">
            <span class="brand-mark">L</span>
            <span class="brand-word">Laundry</span>
        </a>
        <style>
            .sidebar-logo { gap: 0.625rem; text-decoration: none; }
            .sidebar-logo .brand-mark {
                flex-shrink: 0; width: 2.5rem; height: 2.5rem; border-radius: 0.625rem;
                background: var(--primary-600, #487fff); color: #fff;
                display: inline-flex; align-items: center; justify-content: center;
                font-size: 1.375rem; font-weight: 800; line-height: 1;
            }
            .sidebar-logo .brand-word {
                font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em;
                color: var(--text-primary-light, #111827); white-space: nowrap;
            }
            .sidebar.active .sidebar-logo { justify-content: center; }
            .sidebar.active .sidebar-logo .brand-word { display: none; }
            .sidebar.active:hover .sidebar-logo { justify-content: flex-start; }
            .sidebar.active:hover .sidebar-logo .brand-word { display: inline; }
        </style>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['dashboard'] ?? 'Dashboard'}}</span>
                </a>
            </li>
            @canany(['order_create','order_list','order_status_change'])
            <li class="sidebar-menu-group-title">{{$lang->data['orders'] ?? 'Orders'}}</li>
            @endcan
            @can('order_create')
            <li>
                <a href="{{route('orders.pos')}}">
                    <iconify-icon icon="mdi-light:monitor" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['pos'] ?? 'POS' }}</span>
                </a>
            </li>
            @endcan
            @can('order_list')
            <li>
                <a href="{{ route('orders') }}">
                    <iconify-icon icon="akar-icons:cart" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['orders'] ?? 'Orders' }}</span>
                </a>
            </li>
            @endcan
            @can('order_status_change')
            <li>
                <a href="{{ route('orders.status-screen') }}">
                    <iconify-icon icon="line-md:list-3-filled" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['order_status_screen'] ?? 'Order Status Screen' }}</span>
                </a>
            </li>
            @endcan
            <li class="sidebar-menu-group-title">{{ $lang->data['application'] ?? 'Application' }}</li>
            @can('customer_list')
            <li class="@if(Request::is('admin/customers*')) active-page @endif">
                <a href="{{ route('customers') }}" class="@if(Request::is('admin/customers*')) active-page @endif">
                    <iconify-icon icon="uil:user" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['customers'] ?? 'Customers' }}</span>
                </a>
            </li>
            @endcan
            @canany(['service_list','service_type_list','addon_list'])
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="material-symbols-light:design-services-outline-sharp" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['services'] ?? 'Services'}}</span>
                </a>
                <ul class="sidebar-submenu">
                    @can('service_list')
                    <li>
                        <a href="{{ route('service') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['service_list'] ?? 'Service List'}}</a>
                    </li>
                    @endcan
                    @can('service_type_list')
                    <li>
                        <a href="{{ route('service.types') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['service_type'] ?? 'Service Type'}}</a>
                    </li>
                    @endcan
                    @can('addon_list')
                    <li>
                        <a href="{{ route('service.addons') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i> {{$lang->data['addons'] ?? 'Addons'}}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @canany(['expense_list','expense_category_list'])
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="iconoir:wallet" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['expense'] ?? 'Expense'}}</span>
                </a>
                <ul class="sidebar-submenu">
                    @can('expense_list')
                    <li>
                        <a href="{{ route('expense') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>
                            {{ $lang->data['expense_list'] ?? 'Expense List' }}</a>
                    </li>
                    @endcan
                    @can('expense_category_list')
                    <li>
                        <a href="{{ route('expense.category') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>
                            {{ $lang->data['expense_category'] ?? 'Expense Category' }}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('payment_list')
            <li>
                <a href="{{ route('payments.receipt') }}">
                    <iconify-icon icon="fluent:receipt-48-regular" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['payment_receipt'] ?? 'Payment Receipt'}}</span>
                </a>
            </li>
            @endcan
            @canany(['inventory_list'])
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:warehouse" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['inventory'] ?? 'Inventory'}}</span>
                </a>
                <ul class="sidebar-submenu">
                    @can('inventory_list')
                    <li>
                        <a href="{{ route('inventory.products') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['products'] ?? 'Products'}}</a>
                    </li>
                    @endcan
                    @can('inventory_list')
                    <li>
                        <a href="{{ route('inventory.categories') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['categories'] ?? 'Categories'}}</a>
                    </li>
                    @endcan
                    @can('inventory_list')
                    <li>
                        <a href="{{ route('inventory.units') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i> {{$lang->data['units'] ?? 'Units'}}</a>
                    </li>
                    @endcan
                    @can('inventory_list')
                    <li>
                        <a href="{{ route('inventory.stock-usage') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i> {{$lang->data['stock_usage'] ?? 'Stock Usage'}}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @canany(['suppliers_list','purchase_list','purchase_return_list','purchase_payment_list','purchase_return_payment_list'])
            <li class="dropdown {{Request::is('admin/purchase*') ? 'open' : ''}}">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:cart-arrow-down" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['purchase'] ?? 'Purchase'}}</span>
                </a>
                <ul class="sidebar-submenu">
                    @can('purchase_list')
                    <li class="{{Route::is('inventory.purchase.view') || Route::is('inventory.purchase.manage') ? 'active-page' : ''}}">
                        <a href="{{ route('inventory.purchase.list') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['purchase_list'] ?? 'Purchase List'}}</a>
                    </li>
                    @endcan
                    @can('supplier_list')
                    <li>
                        <a href="{{ route('inventory.suppliers') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['suppliers'] ?? 'Suppliers'}}</a>
                    </li>
                    @endcan
                    @can('purchase_return_list')
                    <li class="{{Request::is('admin/purchase-return*') &&  !Request::is('admin/purchase-return/payments') ? 'active-page' : ''}}">
                        <a href="{{ route('inventory.purchase-return.list') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['purchase_returns'] ?? 'Purchase Returns'}}</a>
                    </li>
                    @endcan
                    @can('purchase_payment_list')
                    <li>
                        <a href="{{ route('inventory.purchase.payments') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['purchase_payments'] ?? 'Purchase Payments'}}</a>
                    </li>
                    @endcan
                    @can('purchase_return_payment_list')
                    <li>
                        <a href="{{ route('inventory.purchase.return.payments') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['purchase_return_payments'] ?? 'Purchase Return Payments'}}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @canany(['report_daily','report_order','report_sales','report_expense','report_ledger','report_tax'])
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="iconoir:reports" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['reports'] ?? 'Reports'}}</span>
                </a>
                <ul class="sidebar-submenu">
                    @can('report_daily')
                    <li>
                        <a href="{{ route('reports.daily') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['daily_report'] ?? 'Daily Report'}}</a>
                    </li>
                    @endcan
                    @can('report_order')
                    <li>
                        <a href="{{ route('reports.order') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['order_report'] ?? 'Order Report'}}</a>
                    </li>
                    @endcan
                    @can('report_sales')
                    <li>
                        <a href="{{ route('reports.sales') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['sales_report'] ?? 'Sales Report'}}</a>
                    </li>
                    @endcan
                    @can('report_ledger')
                    <li>
                        <a href="{{ route('reports.ledger') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['ledger_report'] ?? 'Ledger Report'}}</a>
                    </li>
                    @endcan
                    @can('report_expense')
                    <li>
                        <a href="{{ route('reports.expense') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i> {{$lang->data['expense_report'] ?? 'Expense Report'}}</a>
                    </li>
                    @endcan
                    @can('report_tax')
                    <li>
                        <a href="{{ route('reports.tax') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['tax_report'] ?? 'Tax Report'}}</a>
                    </li>
                    @endcan
                    @can('report_tax')
                    <li>
                        <a href="{{ route('reports.purchase') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['purchase_report'] ?? 'Purchase Report'}}</a>
                    </li>
                    @endcan
                    @can('report_tax')
                    <li>
                        <a href="{{ route('reports.purchase.return') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['purchase_return_report'] ?? 'Purchase Return Report'}}</a>
                    </li>
                    @endcan
                    @can('report_tax')
                    <li>
                        <a href="{{ route('reports.stock') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['stock_report'] ?? 'Stock Report'}}</a>
                    </li>
                    @endcan
                </ul>
            </li>
          
            @endcan
            <li class="sidebar-menu-group-title">{{$lang->data['account'] ?? 'Account'}}</li>
            @can('setting_view')
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['tools'] ?? 'Tools'}}</span>
                </a>
                <ul class="sidebar-submenu">
                    @can('setting_financial_year')
                    <li>
                        <a href="{{ route('settings.financial-year') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['financial_year'] ?? 'Financial Year'}}</a>
                    </li>
                    @endcan
                    @can('setting_mail')
                    <li>
                        <a href="{{ route('settings.mail-settings') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i> {{$lang->data['mail_settings'] ?? 'Mail Settings'}}</a>
                    </li>
                    @endcan

                    @can('setting_mail')
                    <li>
                        <a href="{{ route('settings.file') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['file_tools'] ?? 'File Tools'}} </a>
                    </li>
                    @endcan
                    @can('setting_sms')
                    <li>
                        <a href="{{ route('settings.sms') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i>{{$lang->data['sms_settings'] ?? 'SMS Settings'}} </a>
                    </li>
                    @endcan
                    @can('role_list')
                    <li>
                        <a href="{{ route('settings.roles') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i> {{$lang->data['roles'] ?? 'Roles'}} </a>
                    </li>
                    @endcan
                    @can('user_list')
                    <li>
                        <a href="{{ route('settings.staff') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i> {{$lang->data['staff'] ?? 'Staff'}} </a>
                    </li>
                    @endcan
                    @can('setting_master')
                    <li>
                        <a href="{{ route('settings.master-settings') }}"><i
                                class="w-auto ri-circle-fill circle-icon text-primary-600"></i> {{$lang->data['master_settings'] ?? 'Master Settings'}}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            <li>
                <a href="{{route('logout')}}" wire:click.prevent="logout()">
                    <iconify-icon icon="material-symbols:logout" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['logout'] ?? 'Logout' }}</span>
                </a>
            </li>
        </ul>
    </div>
</aside>