<?php

namespace App\Livewire\Orders;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Customer;
use App\Models\MasterSettings;
use App\Models\Order;
use App\Models\OrderAddonDetail;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Translation;

class PrintOrder extends Component
{
    public $order, $orderdetails, $orderaddons, $balance, $total, $customer, $payments, $sitename, $address, $phone, $paid_amount, $payment_type, $zipcode, $tax_number, $store_email, $from_date, $to_date;

    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.orders.print-order');
    }

    /* process before render */
    public function mount($id)
    {
        if(!\Illuminate\Support\Facades\Gate::allows('order_print')){
            abort(404);
        }
        $this->order = Order::where('id', $id)->first();
        /* if order is empty */
        if (!$this->order) {
            abort(404);
        }
        $this->customer = Customer::where('id', $this->order->customer_id)->first();
        $this->orderaddons = OrderAddonDetail::where('order_id', $this->order->id)->get();
        $this->orderdetails = OrderDetail::where('order_id', $this->order->id)->get();
        $this->payments = Payment::where('order_id', $this->order->id)->get();
        $settings = new MasterSettings();
        $site = $settings->siteData();

        /* if site has default appplication name */
        if (isset($site['default_application_name'])) {
            $sitename = (($site['default_application_name']) && ($site['default_application_name'] != "")) ? $site['default_application_name'] : 'Laundry Management System';
            $this->sitename = $sitename;
        }
        /* if site has default phone number */
        if (isset($site['default_phone_number'])) {
            $phone = (($site['default_phone_number']) && ($site['default_phone_number'] != "")) ? $site['default_phone_number'] : '123456789';
            $this->phone = $phone;
        }
        /* if site has default address */
        if (isset($site['default_address'])) {
            $address = (($site['default_address']) && ($site['default_address'] != "")) ? $site['default_address'] : 'Address';
            $this->address = $address;
        }
        /* if site has default zip code */
        if (isset($site['default_zip_code'])) {
            $zipcode = (($site['default_zip_code']) && ($site['default_zip_code'] != "")) ? $site['default_zip_code'] : 'ZipCode';
            $this->zipcode = $zipcode;
        }
        /* if site has store tax number */
        if (isset($site['store_tax_number'])) {
            $tax_number = (($site['store_tax_number']) && ($site['store_tax_number'] != "")) ? $site['store_tax_number'] : 'Tax Number';
            $this->tax_number = $tax_number;
        }
        /* if site has store email */
        if (isset($site['store_email'])) {
            $store_email = (($site['store_email']) && ($site['store_email'] != "")) ? $site['store_email'] : 'store@store.com';
            $this->store_email = $store_email;
        }
        $this->balance = $this->order->total -  Payment::where('order_id', $this->order->id)->sum('received_amount');
        $this->paid_amount = $this->balance;
        if (session()->has('selected_language')) {  /* if session has selected language */
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            /* if session has no selected language */
            $this->lang = Translation::where('default', 1)->first();
        }
    }
}
