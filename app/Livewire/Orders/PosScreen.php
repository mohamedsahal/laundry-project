<?php

namespace App\Livewire\Orders;

use Livewire\Component;

use App\Models\Addon;
use App\Models\Customer;
use App\Models\MasterSettings;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServiceType;
use App\Models\OrderAddonDetail;
use App\Models\Translation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class PosScreen extends Component
{
    public $services, $search_query, $order_id, $inputs = [], $selservices = [], $customer, $date, $delivery_date, $discount, $paid_amount, $payment_type = 1;
    public $payment_notes, $service_types, $service, $inputi, $prices = [], $selling_price = [], $quantity = [], $selected_type = [], $addons, $selected_addons = [], $colors = [];
    public $customer_name, $customer_phone, $email, $tax_no, $address, $selected_customer, $customers, $customer_query, $is_active = 1;
    public $total, $sub_total, $addon_total, $tax_percent, $tax, $balance, $flag = 0, $lang,$taxamount;
    public $taxable,$order;
    public $payments = [],$payment_amount,$notes;

    #[Layout('components.layouts.pos'),Title('POS')]
    public function render()
    {
        return view('livewire.orders.pos-screen');
    }

    public function mount($id = null)
    {
        if(!\Illuminate\Support\Facades\Gate::allows('order_create')){
            abort(404);
        }
        $this->services = Service::where('is_active', 1)->latest()->get();
        $this->date = Carbon::today()->toDateString();
        $this->addons = Addon::where('is_active', 1)->latest()->get();
        $this->delivery_date = Carbon::today()->toDateString();

        $settings = new MasterSettings();
        $site = $settings->siteData();
        if (isset($site['default_delivery_day']) && !empty($site['default_delivery_day']) && (float)$site['default_delivery_day'] > 0) {
            $this->delivery_date = Carbon::today()->addDay((float)$site['default_delivery_day'] )->toDateString();
        }
        $this->tax_percent = getTaxPercentage();
        $this->generateOrderID();

        if($id)
        {
            $this->order = Order::whereId($id)->firstOrFail();
            $payments = Payment::where('order_id', $this->order->id)->get();
            foreach($payments as $payment){
                array_push($this->payments,[
                    'payment_type' => $payment->payment_type,
                    'amount' => $payment->received_amount,
                    'notes' => $payment->notes
                ]);
            }
            if ($this->order->customer_id && $this->order->customer_id != NULL) {
                $this->selectCustomer($this->order->customer_id);
            }
            foreach ($this->order->details as $row) {
                $this->editItem($row);
            }
            $this->delivery_date = Carbon::parse($this->order->delivery_date)->toDateString();
            $this->date = Carbon::parse($this->order->order_date)->toDateString();
            $this->order_id = $this->order->order_number;
            $this->payment_notes = $this->order->notes;
            $this->discount = $this->order->discount;
            foreach ($this->order->addons as $row) {
                $this->selected_addons[$row->addon_id] = true;
            }
            
        }
        if (session()->has('selected_language')) {
            /* if session has selected language */
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            /* if session has no selected language */
            $this->lang = Translation::where('default', 1)->first();
        }
        $this->service_types = collect();
        $this->calculateTotal();
    }

    public function editItem($row){
        $this->add($this->inputi);
        $service = Service::whereId($row->service_id)->first();
        $servicedetails = ServiceDetail::where('service_id', $service->id)->first();
        $serviceType = ServiceType::where('service_type_name',$row->service_name)->first();
        $servicedetail = $servicedetails->where('service_type_id', $serviceType?->id)->where('service_id', $service->id)->first();
        if ($servicedetail) {
            $this->selservices[$this->inputi]['service'] = $service->id;
            $this->selservices[$this->inputi]['service_type']  = $serviceType?->id;

            if ($this->order->tax_type == 2) {
                $this->selling_price[$this->inputi] =  $servicedetail->service_price;
                $itemtotallocal =   $servicedetail->service_price  * (100 / (100 + $this->tax_percent ?? 0));
                $this->prices[$this->inputi] = number_format($itemtotallocal, 2);
            } else {
                $this->prices[$this->inputi] =  $servicedetail->service_price;
                $this->selling_price[$this->inputi] =  $servicedetail->service_price;
            }

            $this->colors[$this->inputi] = $row->color_code;
            $this->prices[$this->inputi] = $row->service_price;
            $this->quantity[$this->inputi] = $row->service_quantity;
        }
        $this->calculateTotal();
    }

    public function changeColor($id)
    {
        $this->colors[$id] = $this->colors[$id];
    }
    /* process while update element */
    public function updated($name, $value)
    {

        /* if updated value is empty set the value as null */
        if ($value == '') data_set($this, $name, null);
        /* if updated elemtnt is search_query */
        if ($name == 'search_query' && $value != '') {
            $this->services = Service::where('service_name', 'like', '%' . $value . '%')->latest()->get();
        } elseif ($name == 'search_query' && $value == '') {
            $this->services = Service::latest()->get();
        }
        /* if the updated value is customer_query */
        if ($name == 'customer_query' && $value != '') {
            $this->customers = Customer::where(function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%')->orWhere('phone', 'like', '%' . $value . '%');
            })->latest()->limit(5)->get();
        } elseif ($name == 'customer_query' && $value == '') {
            $this->customers = collect();
        }

        if ($name == 'discount' || strpos($name, 'selling_price') !== false || strpos($name, 'prices') !== false || strpos($name, 'quantity') !== false) {
            $this->calculateTotal();
        }
        $this->calculateTotal();
    }


    /* select service */
    public function selectService($id)
    {
        $this->selected_type = [];
        $this->service = Service::where('id', $id)->first();
        $this->service_types = collect();
        /* if service is not empty */
        if ($this->service) {
            $servicedetails = ServiceDetail::where('service_id', $id)->get();
            foreach ($servicedetails as $row) {
                $servicetype = ServiceType::where('id', $row->service_type_id)->first();
                $servicetype['price'] = getFormattedCurrency($row->service_price);
                $this->service_types->push($servicetype->toArray());
            }
        }
        if ($this->service_types) {
            if (count($this->service_types) > 0) {
                $first = $this->service_types->first();
                if ($first) {
                    $this->selected_type [$first['id']] = true;
                }
            }
        }
        $this->calculateTotal();
    }
    /* select services*/
    public function addItem()
    {

        if ($this->service) {
            $anyTicked = false;
            foreach($this->selected_type as $item){
                if($item == true){
                    $anyTicked = true;
                }
            }
            if (count($this->selected_type) > 0 && $anyTicked) {
                $tax_type = getTaxType();
                foreach($this->selected_type as $item => $value){
                    if($value === true){
                        $this->add($this->inputi);
                        $this->selservices[$this->inputi]['service'] = $this->service->id;
                        $this->selservices[$this->inputi]['service_type']  = $item;
                        $servicedetail = ServiceDetail::where('service_id', $this->service->id)->where('service_type_id', $item)->first();
                        /* if service details is not empty */
                        if ($servicedetail) {
                            if ($tax_type == 2) {
                                $this->selling_price[$this->inputi] =  $servicedetail->service_price;
                                $itemtotallocal =   $servicedetail->service_price  * (100 / (100 + $this->tax_percent ?? 0));
                                $this->prices[$this->inputi] = number_format($itemtotallocal, 2);
                            } else {
                                $this->prices[$this->inputi] =  $servicedetail->service_price;
                                $this->selling_price[$this->inputi] =  $servicedetail->service_price;
                            }
                        }
                    }
                }
                $this->service_types = collect();
                $this->dispatch('closemodal');
                $this->calculateTotal();
            } else {
                $this->addError('service_error', 'Select a service type');
                return 0;
            }
        }
    }
    /* add the item to array */
    public function add($i)
    {
        $this->inputi = $i + 1;
        $this->inputs[$this->inputi] = 1;
        $this->prices[$this->inputi] = 100;
        $this->service_types[$this->inputi] = '';
        $this->quantity[$this->inputi]  = 1;
        $this->colors[$this->inputi]  = '';
    }
    /* increase the count */
    public function increase($key)
    {
        /* if quantity of key is exist */
        if (isset($this->quantity[$key])) {
            $this->quantity[$key]++;
            $this->calculateTotal();
        }
    }

    public function priceChange($key)
    {
        $this->calculateTotal();
    }
    /* decrease the count */
    public function decrease($key)
    {
        /* is quantity of key is exist */
        if (isset($this->quantity[$key])) {
            if ($this->quantity[$key] > 1) {
                /* if quantity of key is >1 */
                $this->quantity[$key]--;
            } else {
                /* unset the details if quantity of key is 1 */
                unset($this->quantity[$key]);
                unset($this->prices[$key]);
                unset($this->service_types[$key]);
                unset($this->selservices[$key]);
                unset($this->selling_price[$key]);
            }
            $this->calculateTotal();
        }
    }
    public function removeItem($key)
    {
        unset($this->quantity[$key]);
        unset($this->prices[$key]);
        unset($this->service_types[$key]);
        unset($this->selservices[$key]);
        unset($this->selling_price[$key]);
        $this->calculateTotal();
    }
    /* create customer */
    public function createCustomer()
    {   /* validation */
        $this->validate([
            'customer_name'  => 'required',
            'customer_phone'    => 'required',
        ]);
        $customer = Customer::create([
            'name'  => $this->customer_name,
            'phone' => $this->customer_phone,
            'email' => $this->email ?: null,
            'tax_number'    => $this->tax_no ?: null,
            'address'   => $this->address,
            'is_active' => $this->is_active ?? 0,
        ]);
        $this->selected_customer = $customer;
        $this->dispatch('closemodal');
        $this->customer_name = '';
        $this->customer_phone = '';
        $this->email    = '';
        $this->tax_no = '';
        $this->address = '';
        $this->is_active = 1;
    }
    /* select customer */
    public function selectCustomer($id)
    {
        $this->selected_customer = Customer::where('id', $id)->first();
        $this->customer_query = '';
        $this->customers = collect();
    }
    /* generate order Id */
    public function generateOrderID()
    {
        $code_prefix = 'ORD-';
        $ordernumber = Order::Orderby('id', 'desc')->first();
        /*if order number is exist*/
        if ($ordernumber && $ordernumber->order_number != "") {
            /* if invoice code not empty */
            $code = explode("-", $ordernumber->order_number);
            $new_code = $code[1] + 1;
            $new_code = str_pad($new_code, 4, "0", STR_PAD_LEFT);
            $this->order_id = $code_prefix . $new_code;
        } else {
            /* if order code is empty set start */
            $this->order_id = $code_prefix . '0001';
        }
    }
    /* calculate service total */
    public function calculateTotal()
    {
        $this->sub_total = 0;
        $this->addon_total = 0;

        $this->total = 0;
        $this->sub_total = 0;
        $this->taxamount = 0;
        $this->taxable = 0;

        $unitprice = 0;
        $itemtotal = 0;
        $itemtaxtotal2 = 0;
        $sub_total = 0;

        $tax_type = getTaxType();
        foreach ($this->selling_price as $key => $value) {
            $this->sub_total += $value * $this->quantity[$key];
            $itemtaxtotal = 0;
            if ($tax_type == 2) {
                $itemtotallocal =  ($this->selling_price[$key] * $this->quantity[$key])  * (100 / (100 + $this->tax_percent ?? 0));
                $itemtaxtotal +=  ($this->selling_price[$key] * $this->quantity[$key]) - $itemtotallocal ?? 0;

                $itemtotal += ($this->selling_price[$key] * $this->quantity[$key]);
                $itemtaxtotal2 += $itemtaxtotal;
                $this->taxable += $itemtotal;
                $sub_total += $itemtotallocal;
            } else {
                $itemtotallocal =  ($this->selling_price[$key] * $this->quantity[$key]);
                $itemtaxtotal += $itemtotallocal * $this->tax_percent / 100;
                $itemtotal += $itemtotallocal + $itemtaxtotal;
                $itemtaxtotal2 += $itemtaxtotal;
                $this->taxable += $itemtotallocal;
                $sub_total += $itemtotallocal;
            }
        }

        /* if any addons selected */
        if ($this->selected_addons) {
            foreach ($this->selected_addons as $key => $value) {
                if ($value === true) {
                    $itemtaxtotal = 0;
                    $addon = Addon::where('id', $key)->first();
                    if ($tax_type == 2) {
                        $itemtotallocal =  ($addon->addon_price)  * (100 / (100 + $this->tax_percent ?? 0));
                        $itemtaxtotal +=  ($addon->addon_price) - $itemtotallocal ?? 0;
                        $itemtotal +=  ($addon->addon_price);
                        $itemtaxtotal2 += $itemtaxtotal;
                        $this->taxable += $itemtotal;
                        $sub_total += $itemtotallocal;
                        $this->addon_total += $itemtotallocal;
                    } else {
                        $itemtotallocal =   ($addon->addon_price);
                        $itemtaxtotal += $itemtotallocal * $this->tax_percent / 100;
                        $itemtotal += $itemtotallocal + $itemtaxtotal;
                        $itemtaxtotal2 += $itemtaxtotal;
                        $this->taxable += $itemtotallocal;
                        $this->addon_total += $itemtotallocal;
                        $sub_total += $itemtotallocal;
                    }
                }
            }
        }
        $this->sub_total = $sub_total;
        $this->tax = $itemtaxtotal2;
        $this->total = ($this->sub_total + $itemtaxtotal2) - $this->discount;
        $this->total = round($this->total,3,PHP_ROUND_HALF_UP);
        $this->balance = $this->total - $this->paid_amount;
    }
    //add payment
    public function add_payment(){
        $this->validate([
            'payment_type'  => 'required',
            'payment_amount' => 'lte:'.$this->getPaymentBalance()
        ]);

        $payment = [
            'amount' => (float)$this->payment_amount,
            'notes' => $this->notes,
            'payment_type' => $this->payment_type,
            'payment_id' => null
        ];
        $this->payment_amount = '';
        $this->notes = '';
        $this->payment_type = 1;
        array_push($this->payments,$payment);
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => ' Payment has been created']
        );
    }

    #[Computed()]
    public function currentBalance(){
        return $this->getPaymentBalance();
    }

    /* save the order */
    public function save($type = null)
    {
        $amount = 0;
        if($type === 'cash'){
            $this->payments = [];
            array_push($this->payments,[
                'amount' => $this->total,
                'notes' => $this->payment_notes,
                'payment_type' => $this->payment_type,
                'payment_id' => null
            ]);
        }
        $this->calculateTotal();

        $this->validate([
            'payment_type'  => 'required'
        ]);
        /* if selected services > 0  send error alert*/
        if (count($this->selservices) <= 0) {
            $this->dispatch(
                'alert',
                ['type' => 'error',  'message' => ' You have not added any service to the cart']
            );
            $this->addError('error', 'Select a service');
            return 0;
        }
        $balance = $this->getPaymentBalance();
        /* if balance is <0 send error alert*/
        if ($balance < 0) {
            $this->dispatch(
                'alert',
                ['type' => 'error',  'message' => ' Paid Amount cannot be greater than total.']
            );
            $this->addError('paid_amount', 'Paid Amount cannot be greater than total.');
            return 0;
        }
        /* if customer not exist and has any balance to pay send the error alert */
        if ($balance != 0 && $this->selected_customer == null) {
            $this->addError('paid_amount_customer', 'The customer must be registered to use ledger.');
            return 0;
        }
        $this->generateOrderID();
        if ($this->flag == 0) {
            $order = $this->order;
            if($this->order)
            {
                Order::whereId($this->order->id)->update([
                    'customer_id'   => $this->selected_customer->id ?? null,
                    'customer_name' => $this->selected_customer->name ?? null,
                    'phone_number'  => $this->selected_customer->phone ?? null,
                    'order_date'    => Carbon::parse($this->date)->toDateTimeString(),
                    'delivery_date' => Carbon::parse($this->delivery_date)->toDateTimeString(),
                    'sub_total' => $this->sub_total,
                    'addon_total'   => $this->addon_total,
                    'discount'  => $this->discount ?? 0,
                    'tax_percentage'    => $this->tax_percent,
                    'tax_amount'    => $this->tax,
                    'tax_type'  => getTaxType(),
                    'taxable_amount'    => $this->taxable,
                    'total' => $this->total,
                    'note'  => $this->payment_notes,
                    'status'    => 0,
                    'order_type'    => 1,
                ],$this->order->id);
                OrderDetail::whereOrderId($this->order->id)->delete();
                OrderAddonDetail::whereOrderId($this->order->id)->delete();
                Payment::whereOrderId($this->order->id)->delete();
            }
            else{
                $order = Order::create([
                    'order_number'  => $this->order_id,
                    'customer_id'   => $this->selected_customer->id ?? null,
                    'customer_name' => $this->selected_customer->name ?? null,
                    'phone_number'  => $this->selected_customer->phone ?? null,
                    'order_date'    => Carbon::parse($this->date)->toDateTimeString(),
                    'delivery_date' => Carbon::parse($this->delivery_date)->toDateTimeString(),
                    'sub_total' => $this->sub_total,
                    'addon_total'   => $this->addon_total,
                    'discount'  => $this->discount ?? 0,
                    'tax_percentage'    => $this->tax_percent,
                    'tax_amount'    => $this->tax,
                    'tax_type'  => getTaxType(),
                    'taxable_amount'    => $this->taxable,
                    'total' => $this->total,
                    'note'  => $this->payment_notes,
                    'status'    => 0,
                    'order_type'    => 1,
                    'created_by'    => Auth::user()->id,
                    'financial_year_id' => getFinancialYearId()
                ]);
            }

           
            foreach ($this->selservices as $key => $value) {
                $service = Service::where('id', $value['service'])->first();
                $service_type = ServiceType::where('id', $value['service_type'])->first();
                $service_type_detail = ServiceDetail::where('service_type_id', $service_type->id)->first();
                $amount += $this->prices[$key];
               OrderDetail::create([
                    'order_id'  => $order->id,
                    'service_id'    => $service->id,
                    'service_name'  => $service_type->service_type_name,
                    'service_quantity'  => $this->quantity[$key],
                    'service_detail_total'  => $this->selling_price[$key] * $this->quantity[$key],
                    'service_price' => $this->selling_price[$key],
                    'color_code' => $this->colors[$key],
                ]);
            }
            if ($this->selected_addons) {
                foreach ($this->selected_addons as $key => $value) {
                    if ($value === true) {
                        $addon = Addon::where('id', $key)->first();
                        \App\Models\OrderAddonDetail::create([
                            'order_id'  => $order->id,
                            'addon_id'    => $addon->id,
                            'addon_name'    => $addon->addon_name,
                            'addon_price'   => $addon->addon_price,
                        ]);
                    }
                }
            }
            if (count($this->payments) > 0) {
                foreach ($this->payments as $payment) {
                    $payment = \App\Models\Payment::create([
                        'payment_date'  => $this->date,
                        'customer_id'   => $this->selected_customer->id ?? null,
                        'customer_name' => $this->selected_customer->name ?? null,
                        'order_id'  => $order->id,
                        'payment_type'  => $payment['payment_type'],
                        'received_amount'    => $payment['amount'],
                        'notes'  =>  $payment['notes'] ?? "Notes",
                        'financial_year_id' => getFinancialYearId(),
                        'created_by'    => Auth::user()->id,
                    ]);
                }
            }
            $this->flag = 1;
            if ($this->selected_customer) {
                $message = sendOrderCreateSMS($order->id, $this->selected_customer->id);
                if ($message) {
                    $this->dispatch(
                        'alert',
                        ['type' => 'error',  'message' => $message, 'title' => 'SMS Error']
                    );
                }
            }
            $this->dispatch(
                'alert',
                ['type' => 'success',  'message' => $order->order_number . ' Was Successfully Created!']
            );
        }
        if(\Illuminate\Support\Facades\Gate::allows('order_print')){
            if($this->order){
                $this->dispatch('printPageOrder', $order->id);
            }
            else{
                $this->dispatch('printPage', $order->id);
                $this->clearAll();
            }
        }
        if($this->order){
        }
        else{
            $this->clearAll();
        }
    }

    public function getPaymentBalance(){
        $orderBalance = $this->total;
        $paymentsTotal = 0;
        foreach($this->payments as $payment){
            $paymentsTotal += $payment['amount'];
        }
        return $orderBalance - $paymentsTotal;
    }

    public function magicFill()
    {
        if ($this->total) {
            $this->paid_amount = $this->total;
        } else {
            $this->paid_amount = 0;
        }
    }
    //Reload page on clicking clearall
    public function clearAll()
    {
        $this->dispatch('reloadpage');
    }

    //remove payment
    public function removePayment($paymentIndex){
        array_splice($this->payments,$paymentIndex,1);
    }
}