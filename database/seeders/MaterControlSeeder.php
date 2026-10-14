<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = new MasterSettings();
        $site = $settings->siteData();
        $site['default_currency'] = '$';
        $site['default_application_name'] = 'Laundry Management System';
        $site['default_phone_number'] = '123456';
        $site['default_tax_percentage'] = '5';
        $site['default_state'] = 'kerala';
        $site['default_city'] = 'kollam';
        $site['default_country'] = 'IN';
        $site['default_zip_code'] = '691001';
        $site['default_address'] = 'address';
        $site['store_email'] = 'store@store.com';
        $site['store_tax_number'] = 'tax@tax';
        $site['default_printer'] = '1';
        $site['forget_password_enable'] = 1;
        $site['country_code'] = +91;
        $site['default_currency_alignment'] = 1;
        $site['sms_createorder'] = 'Hi <name> An Order #<order_number> was created and will be delivered on <delivery_date> Your Order Total is <total>.';
        $site['sms_statuschange'] = 'Hi <name> Your Order #<order_number> status has been changed to <status> on <current_time>';
        foreach ($site as $key => $value) {
            MasterSettings::updateOrCreate(['master_title' => $key],['master_value' => $value]);
        }
    }
}
