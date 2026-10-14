<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allPermissions = [
            ['name' => 'order_list','display_name' => 'Order List','category' => 'Order'],
            ['name' => 'order_view','display_name' => 'Order View','category' => 'Order'],
            ['name' => 'order_create','display_name' => 'Order Create','category' => 'Order'],
            ['name' => 'order_edit','display_name' => 'Order Edit','category' => 'Order'],
            ['name' => 'order_delete','display_name' => 'Order Delete','category' => 'Order'],
            ['name' => 'order_print','display_name' => 'Print Order','category' => 'Order'],
            ['name' => 'order_status_change','display_name' => 'Change Order Status','category' => 'Order'],

            ['name' => 'customer_list','display_name' => 'Customer List','category' => 'Customer'],
            ['name' => 'customer_view','display_name' => 'Customer View','category' => 'Customer'],
            ['name' => 'customer_create','display_name' => 'Customer Create','category' => 'Customer'],
            ['name' => 'customer_edit','display_name' => 'Customer Edit','category' => 'Customer'],
            ['name' => 'customer_delete','display_name' => 'Customer Delete','category' => 'Customer'],

            ['name' => 'service_type_list', 'display_name' => 'Service Type List', 'category' => 'Service Type'],
            ['name' => 'service_type_view', 'display_name' => 'Service Type View', 'category' => 'Service Type'],
            ['name' => 'service_type_create', 'display_name' => 'Service Type Create', 'category' => 'Service Type'],
            ['name' => 'service_type_edit', 'display_name' => 'Service Type Edit', 'category' => 'Service Type'],
            ['name' => 'service_type_delete', 'display_name' => 'Service Type Delete', 'category' => 'Service Type'],

            ['name' => 'service_list', 'display_name' => 'Service List', 'category' => 'Service'],
            ['name' => 'service_view', 'display_name' => 'Service View', 'category' => 'Service'],
            ['name' => 'service_create', 'display_name' => 'Service Create', 'category' => 'Service'],
            ['name' => 'service_edit', 'display_name' => 'Service Edit', 'category' => 'Service'],
            ['name' => 'service_delete', 'display_name' => 'Service Delete', 'category' => 'Service'],

            ['name' => 'addon_list', 'display_name' => 'Addon List', 'category' => 'Addon'],
            ['name' => 'addon_view', 'display_name' => 'Addon View', 'category' => 'Addon'],
            ['name' => 'addon_create', 'display_name' => 'Addon Create', 'category' => 'Addon'],
            ['name' => 'addon_edit', 'display_name' => 'Addon Edit', 'category' => 'Addon'],
            ['name' => 'addon_delete', 'display_name' => 'Addon Delete', 'category' => 'Addon'],

            ['name' => 'expense_list', 'display_name' => 'Expense List', 'category' => 'Expense'],
            ['name' => 'expense_view', 'display_name' => 'Expense View', 'category' => 'Expense'],
            ['name' => 'expense_create', 'display_name' => 'Expense Create', 'category' => 'Expense'],
            ['name' => 'expense_edit', 'display_name' => 'Expense Edit', 'category' => 'Expense'],
            ['name' => 'expense_delete', 'display_name' => 'Expense Delete', 'category' => 'Expense'],

            ['name' => 'expense_category_list', 'display_name' => 'Expense Category List', 'category' => 'Expense Category'],
            ['name' => 'expense_category_view', 'display_name' => 'Expense Category View', 'category' => 'Expense Category'],
            ['name' => 'expense_category_create', 'display_name' => 'Expense Category Create', 'category' => 'Expense Category'],
            ['name' => 'expense_category_edit', 'display_name' => 'Expense Category Edit', 'category' => 'Expense Category'],
            ['name' => 'expense_category_delete', 'display_name' => 'Expense Category Delete', 'category' => 'Expense Category'],


            ['name' => 'payment_list', 'display_name' => 'Payment List', 'category' => 'Payment'],
            ['name' => 'payment_view', 'display_name' => 'Payment View', 'category' => 'Payment'],
            ['name' => 'payment_create', 'display_name' => 'Payment Create', 'category' => 'Payment'],
            ['name' => 'payment_edit', 'display_name' => 'Payment Edit', 'category' => 'Payment'],
            ['name' => 'payment_delete', 'display_name' => 'Payment Delete', 'category' => 'Payment'],

            ['name' => 'report_download', 'display_name' => 'Report Download', 'category' => 'Report'],
            ['name' => 'report_print', 'display_name' => 'Report Print', 'category' => 'Report'],
            ['name' => 'report_daily', 'display_name' => 'Daily Report', 'category' => 'Report'],
            ['name' => 'report_expense', 'display_name' => 'Expense Report', 'category' => 'Report'],
            ['name' => 'report_order', 'display_name' => 'Order Report', 'category' => 'Report'],
            ['name' => 'report_ledger', 'display_name' => 'Ledger Report', 'category' => 'Report'],
            ['name' => 'report_tax', 'display_name' => 'Tax Report', 'category' => 'Report'],
            ['name' => 'report_sales', 'display_name' => 'Sales Report', 'category' => 'Report'],

            ['name' => 'setting_view', 'display_name' => 'Setting View', 'category' => 'Setting'],
            ['name' => 'setting_file_tools', 'display_name' => 'File Tools Settings', 'category' => 'Setting'],
            ['name' => 'setting_financial_year', 'display_name' => 'Financial Year Settings', 'category' => 'Setting'],
            ['name' => 'setting_mail', 'display_name' => 'Mail Settings', 'category' => 'Setting'],
            ['name' => 'setting_sms', 'display_name' => 'SMS Settings', 'category' => 'Setting'],
            ['name' => 'setting_master', 'display_name' => 'Master Settings', 'category' => 'Setting'],
            ['name' => 'setting_theme', 'display_name' => 'Theme Settings', 'category' => 'Setting'],
            

            ['name' => 'user_list', 'display_name' => 'User List', 'category' => 'User'],
            ['name' => 'user_view', 'display_name' => 'User View', 'category' => 'User'],
            ['name' => 'user_create', 'display_name' => 'User Create', 'category' => 'User'],
            ['name' => 'user_edit', 'display_name' => 'User Edit', 'category' => 'User'],
            ['name' => 'user_delete', 'display_name' => 'User Delete', 'category' => 'User'],

            ['name' => 'role_list', 'display_name' => 'Role List', 'category' => 'Role'],
            ['name' => 'role_view', 'display_name' => 'Role View', 'category' => 'Role'],
            ['name' => 'role_create', 'display_name' => 'Role Create', 'category' => 'Role'],
            ['name' => 'role_edit', 'display_name' => 'Role Edit', 'category' => 'Role'],
            ['name' => 'role_delete', 'display_name' => 'Role Delete', 'category' => 'Role'],

            ['name' => 'translation_list', 'display_name' => 'Translation List', 'category' => 'Translation'],
            ['name' => 'translation_view', 'display_name' => 'Translation View', 'category' => 'Translation'],
            ['name' => 'translation_create', 'display_name' => 'Translation Create', 'category' => 'Translation'],
            ['name' => 'translation_edit', 'display_name' => 'Translation Edit', 'category' => 'Translation'],
            ['name' => 'translation_delete', 'display_name' => 'Translation Delete', 'category' => 'Translation'],

            //suppliers
            ['name' => 'supplier_list', 'display_name' => 'Supplier List', 'category' => 'Supplier'],
            ['name' => 'supplier_view', 'display_name' => 'Supplier View', 'category' => 'Supplier'],
            ['name' => 'supplier_create', 'display_name' => 'Supplier Create', 'category' => 'Supplier'],
            ['name' => 'supplier_edit', 'display_name' => 'Supplier Edit', 'category' => 'Supplier'],
            ['name' => 'supplier_delete', 'display_name' => 'Supplier Delete', 'category' => 'Supplier'],

            //inventory
            ['name' => 'inventory_list', 'display_name' => 'Inventory List', 'category' => 'Inventory'],
            ['name' => 'inventory_view', 'display_name' => 'Inventory View', 'category' => 'Inventory'],
            ['name' => 'inventory_create', 'display_name' => 'Inventory Create', 'category' => 'Inventory'],
            ['name' => 'inventory_edit', 'display_name' => 'Inventory Edit', 'category' => 'Inventory'],
            ['name' => 'inventory_delete', 'display_name' => 'Inventory Delete', 'category' => 'Inventory'],

            //purchase
            ['name' => 'purchase_list', 'display_name' => 'Purchase List', 'category' => 'Purchase'],
            ['name' => 'purchase_view', 'display_name' => 'Purchase View', 'category' => 'Purchase'],
            ['name' => 'purchase_create', 'display_name' => 'Purchase Create', 'category' => 'Purchase'],
            ['name' => 'purchase_edit', 'display_name' => 'Purchase Edit', 'category' => 'Purchase'],
            ['name' => 'purchase_delete', 'display_name' => 'Purchase Delete', 'category' => 'Purchase'],


            ['name' => 'purchase_payment_list', 'display_name' => 'Purchase Payment List', 'category' => 'Purchase'],
            ['name' => 'purchase_payment_create', 'display_name' => 'Purchase Payment Create', 'category' => 'Purchase'],
            ['name' => 'purchase_payment_edit', 'display_name' => 'Purchase Payment Edit', 'category' => 'Purchase'],
            ['name' => 'purchase_payment_delete', 'display_name' => 'Purchase Payment Delete', 'category' => 'Purchase'],

            //purchase return
            ['name' => 'purchase_return_list', 'display_name' => 'Purchase Return List', 'category' => 'Purchase Return'],
            ['name' => 'purchase_return_view', 'display_name' => 'Purchase Return View', 'category' => 'Purchase Return'],
            ['name' => 'purchase_return_create', 'display_name' => 'Purchase Return Create', 'category' => 'Purchase Return'],
            ['name' => 'purchase_return_edit', 'display_name' => 'Purchase Return Edit', 'category' => 'Purchase Return'],
            ['name' => 'purchase_return_delete', 'display_name' => 'Purchase Return Delete', 'category' => 'Purchase Return'],

            ['name' => 'purchase_return_payment_list', 'display_name' => 'Purchase Return Payment List', 'category' => 'Purchase Return'],
            ['name' => 'purchase_return_payment_create', 'display_name' => 'Purchase Return Payment Create', 'category' => 'Purchase Return'],
            ['name' => 'purchase_return_payment_edit', 'display_name' => 'Purchase Return Payment Edit', 'category' => 'Purchase Return'],
            ['name' => 'purchase_return_payment_delete', 'display_name' => 'Purchase Return Payment Delete', 'category' => 'Purchase Return'],

        ];

        //update or create permission
        foreach ($allPermissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
