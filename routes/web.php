<?php

use App\Http\Controllers\MainPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Store;

Route::get('/reset-password/{token}',\App\Livewire\Auth\ForgotPassword::class);

Route::get('/', \App\Livewire\Auth\Login::class)->name('login');
Route::group(['prefix' => 'admin', 'middleware' => [Store::class]], function () {
    Route::get('/dashboard', \App\Livewire\HomePage::class)->name('admin.dashboard');
    Route::get('/pos', \App\Livewire\Orders\PosScreen::class)->name('orders.pos');
    Route::get('/pos/edit/{id}', \App\Livewire\Orders\PosScreen::class)->name('orders.pos.edit');
    Route::get('/order-status-screen', \App\Livewire\Orders\OrderStatusScreen::class)->name('orders.status-screen');
    Route::group(['prefix' => 'orders/'], function () {
        Route::get('/', \App\Livewire\Orders\OrdersList::class)->name('orders');
        Route::get('/view/{id}', \App\Livewire\Orders\ViewOrder::class)->name('order.view');
        Route::get('/print/{id}', \App\Livewire\Orders\PrintOrder::class)->name('order.print');
        Route::get('/print-job-card/{id}/{detailId?}', \App\Livewire\Orders\PrintJobCard::class)->name('order.print-job-card');
    });
    Route::group(['prefix' => 'customers/'], function () {
        Route::get('/', \App\Livewire\Customers\CustomersList::class)->name('customers');
        Route::get('/{id}', \App\Livewire\Customers\CustomerView::class)->name('customers.view');
        Route::get('/ledger/{id}', \App\Livewire\Customers\CustomerLedger::class)->name('customers.ledger');
    });
    Route::group(['prefix' => 'inventory/'], function () {
        Route::get('/products', \App\Livewire\Inventory\Products\ProductsList::class)->name('inventory.products');
        Route::get('/categories', \App\Livewire\Inventory\Categories\CategoriesList::class)->name('inventory.categories');
        Route::get('/units', \App\Livewire\Inventory\Units\UnitsList::class)->name('inventory.units');
        Route::get('/stock-usage', \App\Livewire\Inventory\StockUsage\StockUsageList::class)->name('inventory.stock-usage');
        Route::get('/suppliers', \App\Livewire\Inventory\Suppliers\SuppliersList::class)->name('inventory.suppliers');
    });

    Route::group(['prefix' => 'purchase/'], function () {
        Route::get('/', \App\Livewire\Inventory\Purchase\PurchaseList::class)->name('inventory.purchase.list');
        Route::get('/manage/{id?}', \App\Livewire\Inventory\Purchase\PurchaseManage::class)->name('inventory.purchase.manage');
        Route::get('/view/{id?}', \App\Livewire\Inventory\Purchase\PurchaseView::class)->name('inventory.purchase.view');
        Route::get('/payments', \App\Livewire\Inventory\Purchase\PurchasePayments::class)->name('inventory.purchase.payments');
    });

    Route::group(['prefix' => 'purchase-return'], function () {
        Route::get('/', \App\Livewire\Inventory\Purchase\PurchaseReturnList::class)->name('inventory.purchase-return.list');
        Route::get('/manage/{id?}', \App\Livewire\Inventory\Purchase\PurchaseReturnManage::class)->name('inventory.purchase-return.manage');
        Route::get('/view/{id?}', \App\Livewire\Inventory\Purchase\PurchaseReturnView::class)->name('inventory.purchase-return.view');
        Route::get('/payments', \App\Livewire\Inventory\Purchase\PurchaseReturnPayments::class)->name('inventory.purchase.return.payments');
    });
    
    Route::group(['prefix' => 'payments/'], function () {
        Route::get('/receipt', \App\Livewire\Payments\PaymentsReceiptView::class)->name('payments.receipt');
    });
    Route::group(['prefix' => 'service/'], function () {
        Route::get('/', \App\Livewire\Service\ServiceList::class)->name('service');
        Route::get('/manage/{id?}', \App\Livewire\Service\ServiceManage::class)->name('service.manage');
        Route::get('/edit/{id?}', \App\Livewire\Service\ServiceEdit::class)->name('service.edit');
        Route::get('/addons', \App\Livewire\Service\ServiceAddonsList::class)->name('service.addons');
        Route::get('/types', \App\Livewire\Service\ServiceTypesList::class)->name('service.types');
    });
    Route::group(['prefix' => 'reports/'], function () {
        Route::get('/daily', \App\Livewire\Reports\DailyReport::class)->name('reports.daily');
        Route::get('/expense', \App\Livewire\Reports\ExpenseReport::class)->name('reports.expense');
        Route::get('/ledger', \App\Livewire\Reports\LedgerReport::class)->name('reports.ledger');
        Route::get('/order', \App\Livewire\Reports\OrderReport::class)->name('reports.order');
        Route::get('/sales', \App\Livewire\Reports\SalesReport::class)->name('reports.sales');
        Route::get('/tax', \App\Livewire\Reports\TaxReport::class)->name('reports.tax');
        Route::get('/purchase', \App\Livewire\Reports\PurchaseReports::class)->name('reports.purchase');
        Route::get('/purchase-return', \App\Livewire\Reports\PurchaseReturnReport::class)->name('reports.purchase.return');
        Route::get('/stock', \App\Livewire\Reports\StockReport::class)->name('reports.stock');
        /* print reports */
        Route::group(['prefix' => 'print-report/', 'middleware' => 'admin'], function () {
            Route::get('expense/{from_date}/{to_date}', \App\Livewire\Reports\PrintReport\ExpenseReport::class);
            Route::get('sales/{from_date}/{to_date}', \App\Livewire\Reports\PrintReport\SalesReport::class);
            Route::get('tax/{from_date}/{to_date}/{category}', \App\Livewire\Reports\PrintReport\TaxReport::class);
            Route::get('order/{from_date}/{to_date}/{status}', \App\Livewire\Reports\PrintReport\OrderReport::class);
            Route::get('daily/{today}', \App\Livewire\Reports\PrintReport\DailyReport::class);
            Route::get('purchase/{from_date}/{to_date}', \App\Livewire\Reports\PrintReport\PurchaseReport::class);
            Route::get('purchase-return/{from_date}/{to_date}', \App\Livewire\Reports\PrintReport\PurchaseReturnReport::class);
            Route::get('stock-print', \App\Livewire\Reports\PrintReport\StockReport::class);
        });
        /* download reports */
        Route::group(['prefix' => 'download-report/', 'middleware' => 'admin'], function () {
            Route::get('expense/{from_date}/{to_date}', \App\Livewire\Reports\DownloadReport\ExpenseReport::class);
            Route::get('sales/{from_date}/{to_date}', \App\Livewire\Reports\DownloadReport\SalesReport::class);
            Route::get('tax/{from_date}/{to_date}/{category}', \App\Livewire\Reports\DownloadReport\TaxReport::class);
            Route::get('order/{from_date}/{to_date}/{status}', \App\Livewire\Reports\DownloadReport\OrderReport::class);
            Route::get('purchase/{from_date}/{to_date}', \App\Livewire\Reports\DownloadReport\PurchaseReport::class);
            Route::get('stock-download/', \App\Livewire\Reports\DownloadReport\StockReport::class);
        });
    });
     /* expense */
    Route::group(['prefix' => 'expense/'], function () {
        Route::get('/', \App\Livewire\Expense\ExpenseList::class)->name('expense');
        Route::get('/category', \App\Livewire\Expense\ExpenseCategoryList::class)->name('expense.category');
    });
    /* settings */
    Route::group(['prefix' => 'settings/'], function () {
        Route::get('/master-settings', \App\Livewire\Settings\MasterSetting::class)->name('settings.master-settings');
        Route::get('/mail', \App\Livewire\Settings\MailSettings::class)->name('settings.mail-settings');
        Route::get('/financial-year', \App\Livewire\Settings\FinancialYearSettings::class)->name('settings.financial-year');
        Route::get('/sms', \App\Livewire\Settings\SmsSettings::class)->name('settings.sms');
        Route::get('/theme', \App\Livewire\Settings\ThemeSettings::class)->name('settings.theme');
        Route::get('/file', \App\Livewire\Settings\FileTools::class)->name('settings.file');
        Route::group(['prefix' => 'translations/'], function () {
            Route::get('/', \App\Livewire\Settings\Translations::class)->name('settings.translations');
            Route::get('/create', \App\Livewire\Settings\Translations\CreateTranslations::class)->name('settings.translations-create');
            Route::get('/edit/{id}', \App\Livewire\Settings\Translations\EditTranslations::class)->name('settings.translations-edit');
        });
        Route::get('/roles', \App\Livewire\Roles\RolesList::class)->name('settings.roles');
        Route::group(['prefix' => 'staff/'], function () {
            Route::get('/', \App\Livewire\Settings\Staff\StaffList::class)->name('settings.staff');
        });
    });
});
/* logout */
Route::get('/logout', \App\Livewire\Auth\Logout::class)->name('logout');
Route::get('/store', [MainPageController::class,'index']);

Route::get('/store/{any}', [MainPageController::class,'index'])->where('any', '.*');
