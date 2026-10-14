<?php
/* get expense category type */

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

function getExpenseCategoryType($type)
{
    if (session()->has('selected_language')) {
        $lang = \App\Models\Translation::where('id', session()->get('selected_language'))->first();
    } else {
        $lang = \App\Models\Translation::where('default', 1)->first();
    }
    if ($lang) {
        switch ($type) {
            case 1:
                return $lang->data['asset'] ?? 'Asset';
            case 2:
                return  $lang->data['liability'] ?? 'Liability';
            default:
                return '';
        }
    }
    switch ($type) {
        case 1:
            return 'Asset';
        case 2:
            return 'Liability';
        default:
            return '';
    }
}
/* get payment mode */
function getpaymentMode($type)
{
    if (session()->has('selected_language')) {
        $lang = \App\Models\Translation::where('id', session()->get('selected_language'))->first();
    } else {
        $lang = \App\Models\Translation::where('default', 1)->first();
    }
    if ($lang) {
        switch ($type) {
            case 1:
                return 'Sahal';
            case 2:
                return 'Edahab';
            case 3:
                return 'Premier Wallet';
            case 4:
                return 'Mycash';
            case 5:
                return 'T-plus';
            default:
                return '';
        }
    } else {
    switch ($type) {
        case 1:
            return 'Sahal';
        case 2:
            return 'Edahab';
        case 3:
            return 'Premier Wallet';
        case 4:
            return 'Mycash';
        case 5:
            return 'T-plus';
        default:
            return '';
    }
}
}
/* get financial year */
function getFinancialYearId()
{
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if (isset($site['default_financial_year'])) {
        $year_id = (($site['default_financial_year']) && ($site['default_financial_year'] != "")) ? $site['default_financial_year'] : '';
        return $year_id;
    }
    return null;
}
/* get Currency */
function getCurrency()
{
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if (isset($site['default_currency'])) {
        $currency = (($site['default_currency']) && ($site['default_currency'] != "")) ? $site['default_currency'] : '$';
        return $currency;
    }
    return '$';
}
/* get Tax percentage */
if(!function_exists('getTaxPercentage'))
{
    function getTaxPercentage()
    {
        $settings = new App\Models\MasterSettings();
        $site = $settings->siteData();
        if(isset($site['default_tax_percentage']))
        {
            $currency = (($site['default_tax_percentage']) && ($site['default_tax_percentage'] !=""))? $site['default_tax_percentage'] : 0;
            return $currency;
        }
        return 0;
    }
}



/* get order status */
function getOrderStatus($status, $preventlang = null)
{
    if (session()->has('selected_language')) {
        $lang = \App\Models\Translation::where('id', session()->get('selected_language'))->first();
    } else {
        $lang = \App\Models\Translation::where('default', 1)->first();
    }
    if ($lang == null || $preventlang) {
        switch ($status) {
            case -1:
                return 'All Orders';
            case 0:
                return 'Pending';
            case 1:
                return 'Processing';
            case 2:
                return 'Ready To Deliver';
            case 3:
                return 'Delivered';
            case 4:
                return 'Returned';
        }
    } else {
        switch ($status) {
            case -1:
                return 'All Orders';
            case 0:
                return $lang->data['pending'] ?? 'Pending';
            case 1:
                return $lang->data['processing'] ?? 'Processing';
            case 2:
                return $lang->data['ready_to_deliver'] ?? 'Ready To Deliver';
            case 3:
                return $lang->data['delivered'] ?? 'Delivered';
            case 4:
                return $lang->data['returned'] ?? 'Returned';
        }
    }
}
/* get order status wit color */
function getOrderStatusWithColor($status)
{
    switch ($status) {
        case 0:
            return 'today-task-pending';
        case 1:
            return 'today-task-processing';
        case 2:
            return 'today-task-ready';
        case 3:
            return 'today-task-delivered';
        case 4:
            return 'today-task-returned';
    }
}
/* get order status with color for change status screen */
function getOrderStatusWithColorKan($status)
{
    switch ($status) {
        case 0:
            return 'scrum-task-pending';
        case 1:
            return 'scrum-task-processing';
        case 2:
            return 'scrum-task-ready';
    }
}
/* get priner type */
function getPrinterType()
{
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if (isset($site['default_printer'])) {
        $printerType = (($site['default_printer']) && ($site['default_printer'] != "")) ? $site['default_printer'] : 1;
        return $printerType;
    }
    return 1;
}

/* get favicon */
function getFavIcon()
{
    return 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><rect width="32" height="32" rx="6" fill="#487fff"/><text x="16" y="23" font-family="Arial" font-size="20" font-weight="bold" fill="#fff" text-anchor="middle">L</text></svg>');
}


/* get getAppliation Name */
function getApplicationName()
{
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if (isset($site['default_application_name'])) {
        $favicon = (($site['default_application_name']) && ($site['default_application_name'] != "")) ? $site['default_application_name'] : 'Laundry Management System';
        return $favicon;
    }
    return 'Laundry Management System';
}


/* get site logo */
function getSiteLogo()
{
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if (isset($site['default_logo']) && file_exists(public_path($site['default_logo']))) {
        $favicon = (($site['default_logo']) && ($site['default_logo'] != "")) ? $site['default_logo'] : '/assets/images/logo.png';
        return $favicon;
    }
    return asset('assets/images/logo.png');
}

//Checks if Selected language is RTL
function isRTL()
{
    if (session()->has('selected_language')) {
        $lang = \App\Models\Translation::where('id', session()->get('selected_language'))->first();
        if ($lang) {
            if ($lang->is_rtl) {
                return true;
            }
        }
    }
    return false;
}

function getCountryCode()
{
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if (isset($site['country_code']) && $site['country_code'] != '') {
        return '+'.$site['country_code'];
    }
    return '+91';
}

function smsOrderDeliveredOnly()
{
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if (isset($site['sms_delivered_only']) && $site['sms_delivered_only'] == 1) {
        return true;
    }
    return false;
}

function smsOrderReadyToDeliverOnly()
{
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if (isset($site['sms_ready_to_deliver_only']) && $site['sms_ready_to_deliver_only'] == 1) {
        return true;
    }
    return false;
}


function isSMSEnabled()
{
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if (isset($site['sms_enabled']) && ($site['sms_enabled'] == 1)) {
        return true;
    }
    return false;
}

function sendOrderCreateSMS($order, $to)
{

    if (isSMSEnabled() == true) {
        $settings = new App\Models\MasterSettings();
        $site = $settings->siteData();
        $messageerror = null;
        try {
            $myorder = Order::find($order);
            if (smsOrderDeliveredOnly() && smsOrderReadyToDeliverOnly()) {
                return;
            }
            if (smsOrderDeliveredOnly()) {
                return;
            }
            if (smsOrderReadyToDeliverOnly()) {
                return;
            }

            $account_sid = (($site['sms_account_sid']) && ($site['sms_account_sid'] != "")) ? $site['sms_account_sid'] : '';
            $auth_token = (($site['sms_auth_token']) && ($site['sms_auth_token'] != "")) ? $site['sms_auth_token'] : '';
            $twilio_number = (($site['sms_twilio_number']) && ($site['sms_twilio_number'] != "")) ? $site['sms_twilio_number'] : '';

            $client = new Client($account_sid, $auth_token);
            $customer = Customer::find($to);
            if ($customer) {
                $phoneInt = (int)$customer->phone;
                $message = getFormatedTextSMS($order, 1);
                $client->messages->create(
                    getCountryCode() . $phoneInt,
                    ['from' => $twilio_number, 'body' => $message]
                );
            }
        } catch (\Exception $e) {
            $messageerror = $e->getMessage();
            if ($e->getCode() == 21211) {
                $messageerror = 'Could not send SMS,Because the phone number is invalid';
            }
        }
        return $messageerror;
    }
}

function sendOrderStatusChangeSMS($order, $to_status)
{
    if (isSMSEnabled() == true) {
        $settings = new App\Models\MasterSettings();
        $site = $settings->siteData();
        $messageerror = null;
        try {
            $myorder = Order::find($order);
            if (smsOrderDeliveredOnly() && smsOrderReadyToDeliverOnly()) {
                if ($myorder->status != 3 && $myorder->status != 2) {
                    return;
                }
            }
            if (smsOrderDeliveredOnly() && (!smsOrderReadyToDeliverOnly())) {
                if (smsOrderDeliveredOnly() && $myorder->status != 3) {
                    return;
                }
            }
            if ((!smsOrderDeliveredOnly()) && (smsOrderReadyToDeliverOnly())) {
                if (smsOrderReadyToDeliverOnly() && $myorder->status != 2) {
                    return;
                }
            }
            $account_sid = (($site['sms_account_sid']) && ($site['sms_account_sid'] != "")) ? $site['sms_account_sid'] : '';
            $auth_token = (($site['sms_auth_token']) && ($site['sms_auth_token'] != "")) ? $site['sms_auth_token'] : '';
            $twilio_number = (($site['sms_twilio_number']) && ($site['sms_twilio_number'] != "")) ? $site['sms_twilio_number'] : '';
            $client = new Client($account_sid, $auth_token);
            $customer = Customer::find($myorder->customer_id);
            if ($customer) {
                if ($to_status == 2) {
                    $message = getFormatedTextSMS($order, 3);
                } else {
                    $message = getFormatedTextSMS($order, 2);
                }
                $phoneInt = (int)$customer->phone;
                $client->messages->create(
                    getCountryCode() . $phoneInt,
                    ['from' => $twilio_number, 'body' => $message]
                );
            }
        } catch (\Exception $e) {
            $messageerror = $e->getMessage();
            if ($e->getCode() == 21211) {
                $messageerror = 'Could not send SMS,Because the phone number is invalid';
            }
        }
        return $messageerror;
    }
}

//get formatted currency
function getFormattedCurrency($value)
{
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    $symbol = $site['default_currency'] ?? '$';
    $alignment = $site['default_currency_alignment'] ?? 1;
    $value = number_format($value, 2);
    if ($alignment == 1) {
        return $symbol . ' ' . $value;
    }
    return $value . ' ' . $symbol;
}


function getFormatedTextSMS($order, $type)
{
    $myorder = Order::find($order);
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    $string = null;
    if ($type == 1) {
        if (isset($site['sms_createorder']) && $site['sms_createorder'] != '') {
            $string = $site['sms_createorder'] ?? 'Hi <name> An Order #<order_number> was created and will be delivered on <delivery_date> Your Order Total is <total>.';
        } else {
            $string = 'Hi <name> An Order #<order_number> was created and will be delivered on <delivery_date> Your Order Total is <total>.';
        }
    } else {
        if (isset($site['sms_statuschange']) && $site['sms_statuschange'] != '') {
            $string = $site['sms_statuschange'] ?? 'Hi <name> Your Order #<order_number> status has been changed to <status> on <current_time>';
        } else {
            $string =  'Hi <name> Your Order #<order_number> status has been changed to <status> on <current_time>';
        }
    }

    $replacer = [
        '<name>' => 'Customer Name',
        '<order_date>' => 'Order Date',
        '<delivery_date>' => 'Delivery Date',
        '<no_of_products>' => 'No Of Products',
        '<total>' => 'Total',
        '<discount>' => 'Discount',
        '<paid>' => 'Paid Amount',
        '<status>'  => 'Status',
        '<order_number>'    => 'Order Number',
        '<current_time>'    => 'Current Time'
    ];
    $count = \App\Models\OrderDetail::where('order_id', $order)->count();
    $paid = \App\Models\Payment::where('order_id', $order)->sum('received_amount');
    $replacement = [
        $myorder->customer_name,
        \Carbon\Carbon::parse($myorder->order_date)->format('d/m/Y'),
        \Carbon\Carbon::parse($myorder->delivery_date)->format('d/m/Y'),
        $count,
        getCurrency() . number_format($myorder->total, 2),
        getCurrency() . number_format($myorder->discount, 2),
        getCurrency() . number_format($paid, 2),
        getOrderStatus($myorder->status),
        $myorder->order_number,
        \Carbon\Carbon::now()->format('d/m/Y h:i A')
    ];
    return str_replace(array_keys($replacer), array_values($replacement), $string);
}

if(!function_exists('getTaxType'))
{
    function getTaxType()
    {
        $settings = new App\Models\MasterSettings();
        $site = $settings->siteData();
        if(isset($site['default_tax_mode']))
        {
            $tax_type = (($site['default_tax_mode']) && ($site['default_tax_mode'] !=""))? $site['default_tax_mode'] : 1;
            return $tax_type;
        }
        return 1;
    }
}