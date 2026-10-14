<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\ExpenseCategory;
use App\Models\FinancialYear;
use App\Models\Order;
use App\Models\ServiceDetail;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Sample Somali customers, orders, payments and expenses for the last 3 months.
 * Run manually: php artisan db:seed --class=SampleDataSeeder
 */
class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        mt_srand(2026);

        $end = Carbon::today();
        $start = $end->copy()->subMonths(3)->addDay();
        $taxPercent = (float) (DB::table('master_settings')->where('master_title', 'default_tax_percentage')->value('master_value') ?? 0);

        /* each section is skipped when it already has data, so the seeder is safe to re-run */
        if (Order::count() == 0) {
            $customers = $this->seedCustomers($start);
            $this->seedOrders($start, $end, $customers, $taxPercent);
        } else {
            $this->command?->warn('Orders already exist, sample orders skipped.');
        }
        if (DB::table('expenses')->count() == 0) {
            $this->seedExpenses($start, $end);
        } else {
            $this->command?->warn('Expenses already exist, sample expenses skipped.');
        }
        if (DB::table('purchases')->count() == 0) {
            $this->seedInventory($start, $end, $taxPercent);
        } else {
            $this->command?->warn('Purchases already exist, sample purchases skipped.');
        }
        if (DB::table('stock_usages')->count() == 0) {
            $this->seedStockUsage($start, $end);
        } else {
            $this->command?->warn('Stock usage already exists, sample usage skipped.');
        }
    }

    private function financialYearId(Carbon $date)
    {
        return FinancialYear::whereDate('starting_date', '<=', $date)->whereDate('ending_date', '>=', $date)->value('id')
            ?? FinancialYear::latest('id')->value('id');
    }

    private function seedCustomers(Carbon $start)
    {
        $names = [
            'Cabdiraxmaan Maxamed Cali', 'Faadumo Xasan Axmed', 'Maxamed Cabdullaahi Nuur', 'Hodan Cumar Faarax',
            'Axmed Yuusuf Warsame', 'Sahra Maxamuud Jaamac', 'Cali Xuseen Guuleed', 'Ayaan Cabdi Shire',
            'Yuusuf Aadan Ducaale', 'Khadra Ismaaciil Aw-Cali', 'Cabdullaahi Faarax Samatar', 'Nimco Axmed Rooble',
            'Xasan Cali Mire', 'Deeqa Maxamed Xirsi', 'Mustafe Cabdiqaadir Ibraahim', 'Ifraax Siciid Cilmi',
            'Ibraahim Cusmaan Geedi', 'Hibaaq Yuusuf Cabdi', 'Cumar Xaaji Maxamuud', 'Leylo Cabdirashiid Aadan',
            'Saciid Jaamac Kaahiye', 'Muna Xuseen Cabdullaahi', 'Bashiir Cabdiwali Nuur', 'Ubax Maxamed Faarax',
            'Abuukar Shariif Xasan', 'Farxiya Cali Warsame', 'Cabdiweli Aadan Hiiraan', 'Istar Maxamuud Cumar',
            'Guuleed Faysal Axmed', 'Najma Cabdi Yuusuf', 'Mahad Ismaaciil Xaashi', 'Raxma Saciid Jaamac',
            'Khaalid Maxamed Aw-Cabdi', 'Sagal Axmed Cilmi', 'Zakariye Cabdirisaaq Ali', 'Fardowsa Xasan Muuse',
            'Shire Cabdulqaadir Geelle', 'Asha Cumar Dirie', 'Warsame Liibaan Maxamed', 'Hawo Cabdikariim Nuur',
        ];
        $districts = ['Hodan', 'Wadajir', 'Hawl-Wadaag', 'Waberi', 'Dharkenley', 'Yaaqshiid', 'Kaaraan', 'Shibis',
            'Boondheere', 'Xamar Weyne', 'Xamar Jajab', 'Wardhiigley', 'Shangaani', 'Dayniile', 'Heliwaa', 'Kaxda'];
        $streets = ['Isgoyska KM4', 'Wadada Makka Al-Mukarama', 'Suuqa Bakaaraha', 'Taleex', 'Isgoyska Soobe',
            'Wadada Warshadaha', 'Isgoyska Ex-Control Afgooye', 'Suuqa Xamar Weyne', 'Jidka Sodonka', 'Tarabuunka'];
        $prefixes = ['61', '61', '61', '62', '63', '77'];

        $ids = [];
        foreach ($names as $i => $name) {
            $created = $start->copy()->subDays(mt_rand(5, 60))->setTime(mt_rand(8, 18), mt_rand(0, 59));
            $customer = Customer::firstOrCreate(
                ['name' => $name],
                [
                    'phone'      => $prefixes[array_rand($prefixes)] . mt_rand(1000000, 9999999),
                    'address'    => $districts[array_rand($districts)] . ', ' . $streets[array_rand($streets)] . ', Muqdisho',
                    'is_active'  => 1,
                    'created_by' => 1,
                ]
            );
            DB::table('customers')->where('id', $customer->id)->update(['created_at' => $created, 'updated_at' => $created]);
            $ids[] = $customer;
        }
        return $ids;
    }

    private function seedOrders(Carbon $start, Carbon $end, array $customers, float $taxPercent)
    {
        $details = ServiceDetail::join('services', 'services.id', '=', 'service_details.service_id')
            ->join('service_types', 'service_types.id', '=', 'service_details.service_type_id')
            ->get(['service_details.service_id', 'service_details.service_price', 'service_types.service_type_name', 'services.service_name']);
        /* everyday clothes are ordered far more often than carpets or shoes */
        $weights = ['Shaati' => 10, 'Surwaal' => 9, 'Khamiis' => 6, 'Macawis' => 6, 'Funaanad' => 5, 'Jiinis' => 5,
            'Dirac' => 6, 'Jalbaab' => 5, 'Garbasaar' => 4, 'Dharka Carruurta' => 4, 'Koodh' => 3, 'Suud' => 3,
            "Go' Sariir" => 4, 'Jaakad' => 2, 'Sweater' => 2, 'Buste' => 2, 'Barkin' => 2, 'Roog' => 1,
            'Kabo' => 1, 'Shandad' => 1, 'Koofiyad' => 1, 'Sharabaad' => 1];
        $typeWeights = ['Dhaqid' => 3, 'Feero' => 3, 'Dhaqid iyo Feero' => 6, 'Dry Cleaning' => 2, 'Dhaqid Degdeg ah' => 1];
        $pool = [];
        foreach ($details as $d) {
            $n = ($weights[$d->service_name] ?? 1) * ($typeWeights[$d->service_type_name] ?? 1);
            for ($k = 0; $k < $n; $k++) {
                $pool[] = $d;
            }
        }
        $colors = ['#ffffff', '#000000', '#1e3a8a', '#6b7280', '#b91c1c', '#15803d', '#a16207', '#f5f5dc'];
        $notes = [null, null, null, null, 'Si taxadar leh u feer', 'Ha isticmaalin kulayl badan', 'Waa degdeg',
            'Badhamada ka ilaali', 'Macmiil joogto ah', 'Kala saar midabada'];

        $orderNo = 0;
        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            /* Friday is quieter, weekends before Friday are busier */
            $count = $day->isFriday() ? mt_rand(2, 4) : ($day->isThursday() ? mt_rand(7, 11) : mt_rand(4, 8));
            $daysAgo = $day->diffInDays($end);
            for ($o = 0; $o < $count; $o++) {
                $orderNo++;
                $orderDate = $day->copy()->setTime(mt_rand(7, 20), mt_rand(0, 59));
                $delivery = $orderDate->copy()->addDays(mt_rand(1, 3))->setTime(mt_rand(9, 18), 0);
                $customer = mt_rand(1, 100) <= 85 ? $customers[array_rand($customers)] : null;

                $lines = [];
                $subTotal = 0;
                $itemCount = mt_rand(1, 100) <= 60 ? mt_rand(1, 3) : mt_rand(4, 6);
                for ($l = 0; $l < $itemCount; $l++) {
                    $d = $pool[array_rand($pool)];
                    $qty = in_array($d->service_name, ['Roog', 'Buste', 'Suud', 'Kabo', 'Shandad']) ? mt_rand(1, 2) : mt_rand(1, 6);
                    $lineTotal = $d->service_price * $qty;
                    $subTotal += $lineTotal;
                    $lines[] = [
                        'service_id'           => $d->service_id,
                        'service_name'         => $d->service_type_name,
                        'service_price'        => $d->service_price,
                        'service_quantity'     => (string) $qty,
                        'service_detail_total' => $lineTotal,
                        'color_code'           => $colors[array_rand($colors)],
                    ];
                }
                $discount = ($subTotal >= 10 && mt_rand(1, 100) <= 15) ? round($subTotal * 0.05 * 4) / 4 : 0;
                $tax = round($subTotal * $taxPercent / 100, 2);
                $total = round($subTotal + $tax - $discount, 2);

                /* older orders are finished; recent ones are still in the pipeline */
                if ($daysAgo > 5) {
                    $status = mt_rand(1, 100) <= 97 ? 3 : 4;
                } elseif ($daysAgo > 2) {
                    $status = [1, 2, 2, 3, 3][mt_rand(0, 4)];
                } else {
                    $status = [0, 0, 1, 1, 2][mt_rand(0, 4)];
                }

                $orderId = DB::table('orders')->insertGetId([
                    'order_number'      => 'ORD-' . str_pad($orderNo, 4, '0', STR_PAD_LEFT),
                    'customer_id'       => $customer?->id,
                    'customer_name'     => $customer?->name,
                    'phone_number'      => $customer?->phone,
                    'order_date'        => $orderDate,
                    'delivery_date'     => $delivery,
                    'sub_total'         => $subTotal,
                    'addon_total'       => 0,
                    'discount'          => $discount,
                    'tax_type'          => 1,
                    'taxable_amount'    => $subTotal,
                    'tax_percentage'    => $taxPercent,
                    'tax_amount'        => $tax,
                    'total'             => $total,
                    'note'              => $notes[array_rand($notes)],
                    'status'            => $status,
                    'order_type'        => 1,
                    'created_by'        => 1,
                    'financial_year_id' => $this->financialYearId($orderDate),
                    'created_at'        => $orderDate,
                    'updated_at'        => $orderDate,
                ]);
                foreach ($lines as &$line) {
                    $line += ['order_id' => $orderId, 'created_at' => $orderDate, 'updated_at' => $orderDate];
                }
                DB::table('order_details')->insert($lines);

                /* walk-in customers always pay in full; registered customers sometimes pay later */
                $payments = [];
                $method = $this->paymentMethod();
                if (!$customer || $status == 3 || mt_rand(1, 100) <= 45) {
                    $payments[] = [$orderDate, $total];
                } elseif (mt_rand(1, 100) <= 50) {
                    $advance = round($total * 0.5 * 4) / 4;
                    $payments[] = [$orderDate, $advance];
                    if ($status >= 2) {
                        $payments[] = [$delivery->copy()->min($end->copy()->endOfDay()), round($total - $advance, 2)];
                    }
                }
                foreach ($payments as [$date, $amount]) {
                    if ($amount <= 0) {
                        continue;
                    }
                    DB::table('payments')->insert([
                        'payment_date'      => $date,
                        'customer_id'       => $customer?->id,
                        'customer_name'     => $customer?->name,
                        'order_id'          => $orderId,
                        'received_amount'   => $amount,
                        'payment_type'      => $method,
                        'payment_note'      => null,
                        'created_by'        => 1,
                        'financial_year_id' => $this->financialYearId($date),
                        'created_at'        => $date,
                        'updated_at'        => $date,
                    ]);
                }
            }
        }
        $this->command?->info("Created {$orderNo} sample orders.");
    }

    /* 1 Sahal, 2 Edahab, 3 Premier Wallet, 4 Mycash, 5 T-plus */
    private function paymentMethod()
    {
        $r = mt_rand(1, 100);
        return $r <= 35 ? 1 : ($r <= 60 ? 2 : ($r <= 80 ? 3 : ($r <= 90 ? 4 : 5)));
    }

    /**
     * Running costs only. Soap, chemicals, packaging and equipment are bought
     * through Inventory > Purchases instead (see seedInventory).
     */
    private function seedExpenses(Carbon $start, Carbon $end)
    {
        $categories = [
            'Kirada Dukaanka'          => 2,
            'Mushaharka Shaqaalaha'    => 2,
            'Korontada'                => 2,
            'Biyaha'                   => 2,
            'Internet iyo Taleefan'    => 2,
            'Shidaalka Matoorka'       => 2,
            'Gaadiidka iyo Keenista'   => 2,
            'Dayactirka Mashiinada'    => 2,
            'Qashinka iyo Nadaafadda'  => 2,
            'Ruqsadda iyo Canshuuraha' => 2,
        ];
        $cat = [];
        foreach ($categories as $name => $type) {
            $cat[$name] = ExpenseCategory::firstOrCreate(
                ['expense_category_name' => $name],
                ['expense_category_type' => $type, 'created_by' => 1]
            )->id;
        }

        $rows = [];
        $add = function (Carbon $date, $category, $amount, $note) use (&$rows, $cat) {
            $time = $date->copy()->setTime(mt_rand(8, 17), mt_rand(0, 59));
            $rows[] = [
                'expense_date'        => $date->toDateString(),
                'expense_category_id' => $cat[$category],
                'expense_amount'      => $amount,
                'payment_mode'        => $this->paymentMethod(),
                'tax_included'        => 0,
                'tax_percentage'      => 0,
                'note'                => $note,
                'financial_year_id'   => $this->financialYearId($date),
                'created_by'          => 1,
                'created_at'          => $time,
                'updated_at'          => $time,
            ];
        };

        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            $month = $day->translatedFormat('F Y');
            if ($day->day == 1) {
                $add($day, 'Kirada Dukaanka', 300, "Kirada dukaanka bisha $month");
                $add($day, 'Internet iyo Taleefan', 30, "Internet iyo khadka taleefanka - $month");
            }
            if ($day->day == 5) {
                $add($day, 'Korontada', mt_rand(110, 150), "Biilka korontada - $month");
                $add($day, 'Biyaha', mt_rand(30, 45), "Biilka biyaha - $month");
                $add($day, 'Qashinka iyo Nadaafadda', 15, "Qaadista qashinka - $month");
            }
            if ($day->day == 28) {
                $add($day, 'Mushaharka Shaqaalaha', 750, "Mushaharka 3 shaqaale - $month");
            }
            if ($day->isSunday() || $day->isWednesday()) {
                $add($day, 'Shidaalka Matoorka', mt_rand(15, 30), 'Naafto matoorka korontada');
            }
            if (mt_rand(1, 100) <= 12) {
                $add($day, 'Gaadiidka iyo Keenista', mt_rand(3, 12), 'Bajaaj keenista dharka macaamiisha');
            }
            if (mt_rand(1, 100) <= 3) {
                $add($day, 'Dayactirka Mashiinada', mt_rand(25, 90), 'Dayactirka mashiinka dhaqista');
            }
        }
        $add($start->copy()->addDays(10), 'Ruqsadda iyo Canshuuraha', 120, 'Ruqsadda ganacsiga - Dowladda Hoose ee Muqdisho');
        DB::table('expenses')->insert($rows);
        $this->command?->info('Created ' . count($rows) . ' sample expenses.');
    }

    /**
     * Suppliers, stock products and purchase orders with supplier payments.
     */
    private function seedInventory(Carbon $start, Carbon $end, float $taxPercent)
    {
        $units = [
            'Litir'   => ['L', 'Dareeraha (liquid) - litir'],
            'Xabbo'   => ['pcs', 'Hal xabbo (piece)'],
            'Baakad'  => ['pkt', 'Baakad / xirmo (pack)'],
            'Rool'    => ['roll', 'Rool (roll)'],
            'Kartoon' => ['ctn', 'Kartoon (carton)'],
        ];
        $unit = ['Kilogram' => DB::table('units')->where('short_form', 'kg')->value('id')];
        foreach ($units as $name => [$short, $desc]) {
            $unit[$name] = DB::table('units')->where('name', $name)->value('id') ?? DB::table('units')->insertGetId([
                'name' => $name, 'short_form' => $short, 'description' => $desc, 'is_active' => 1,
                'created_by' => 1, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        $category = [];
        foreach (['Saabuun iyo Nadiifiye', 'Kiimikaad', 'Baakadaha', 'Qalabka Dukaanka'] as $name) {
            $category[$name] = DB::table('categories')->where('name', $name)->value('id') ?? DB::table('categories')->insertGetId([
                'name' => $name, 'is_active' => 1, 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        /* name => [unit, category, sku, price, opening stock, minimum level, consumable, typical qty per order] */
        $products = [
            'Oomo'                            => ['Kilogram', 'Saabuun iyo Nadiifiye', 'SB-001', 1.80, 10, 15, 1, [10, 25]],
            'Shaambo'                         => ['Litir', 'Saabuun iyo Nadiifiye', 'SB-002', 2.50, 5, 10, 1, [5, 12]],
            'Kaloor (Bleach)'                 => ['Litir', 'Kiimikaad', 'KM-001', 1.20, 5, 10, 1, [5, 12]],
            'Kiimikaadka Dry Cleaning'        => ['Litir', 'Kiimikaad', 'KM-004', 6.00, 5, 10, 1, [4, 8]],
            'Bac'                             => ['Baakad', 'Baakadaha', 'BK-001', 4.00, 5, 5, 1, [4, 8]],
            'Katiinado Dharka (Hangers x50)'  => ['Kartoon', 'Baakadaha', 'BK-002', 12.00, 2, 2, 1, [1, 3]],
            'Calaamadaha Dharka (Tags)'       => ['Baakad', 'Baakadaha', 'BK-003', 2.00, 5, 5, 1, [2, 5]],
            'Xarig Xirmo (Packing Tape)'      => ['Rool', 'Baakadaha', 'BK-004', 1.50, 6, 6, 1, [3, 6]],
            'Feero Steam (Steam Iron)'        => ['Xabbo', 'Qalabka Dukaanka', 'QD-001', 150.00, 2, 1, 0, [1, 2]],
            'Miiska Feerada (Ironing Board)'  => ['Xabbo', 'Qalabka Dukaanka', 'QD-002', 45.00, 2, 1, 0, [1, 1]],
            'Dambiil Dharka (Laundry Basket)' => ['Xabbo', 'Qalabka Dukaanka', 'QD-003', 8.00, 6, 4, 0, [2, 6]],
        ];
        $product = [];
        foreach ($products as $name => [$u, $c, $sku, $price, $opening, $min, $consumable, $qty]) {
            $id = DB::table('products')->where('sku', $sku)->value('id') ?? DB::table('products')->insertGetId([
                'name' => $name, 'unit_id' => $unit[$u], 'category_id' => $category[$c], 'sku' => $sku,
                'purchase_price' => $price, 'opening_stock' => $opening, 'minimum_stock_level' => $min,
                'description' => null, 'is_consumable' => $consumable, 'is_active' => 1, 'created_by' => 1,
                'created_at' => $start->copy()->subDays(10), 'updated_at' => $start->copy()->subDays(10),
            ]);
            $product[$name] = ['id' => $id, 'price' => $price, 'qty' => $qty, 'category' => $c];
        }

        /* supplier => [phone, address, what they sell] */
        $suppliers = [
            'Xamar Jumlo Supplies'      => ['615223344', 'Suuqa Bakaaraha, Xamar Weyne, Muqdisho', ['Saabuun iyo Nadiifiye']],
            'Bakaaraha Kiimikaad Store' => ['617889900', 'Suuqa Bakaaraha, Hawl-Wadaag, Muqdisho', ['Kiimikaad']],
            'Banadir General Trading'   => ['618334455', 'Wadada Makka Al-Mukarama, Hodan, Muqdisho', ['Saabuun iyo Nadiifiye', 'Kiimikaad']],
            'Shabelle Packaging'        => ['619556677', 'Isgoyska KM4, Wadajir, Muqdisho', ['Baakadaha']],
            'Daru Salaam Electronics'   => ['612667788', 'Isgoyska Soobe, Waberi, Muqdisho', ['Qalabka Dukaanka']],
        ];
        $supplier = [];
        foreach ($suppliers as $name => [$phone, $address, $sells]) {
            $id = DB::table('suppliers')->where('name', $name)->value('id') ?? DB::table('suppliers')->insertGetId([
                'name' => $name, 'phone' => $phone, 'address' => $address, 'opening_balance' => 0,
                'is_active' => 1, 'created_by' => 1,
                'created_at' => $start->copy()->subDays(10), 'updated_at' => $start->copy()->subDays(10),
            ]);
            $supplier[$name] = ['id' => $id, 'sells' => $sells];
        }

        /* restocking plan: consumables every week or two, packaging monthly, equipment once */
        $plan = [];
        for ($day = $start->copy()->addDays(1); $day->lte($end); $day->addDays(mt_rand(10, 14))) {
            $plan[] = [$day->copy(), 'Xamar Jumlo Supplies'];
            if (mt_rand(0, 1)) {
                $plan[] = [$day->copy()->addDays(2), 'Bakaaraha Kiimikaad Store'];
            }
        }
        for ($day = $start->copy()->addDays(4); $day->lte($end); $day->addDays(mt_rand(28, 35))) {
            $plan[] = [$day->copy(), 'Shabelle Packaging'];
            $plan[] = [$day->copy()->addDays(12), 'Banadir General Trading'];
        }
        $plan[] = [$start->copy()->addDays(40), 'Daru Salaam Electronics'];
        $plan = array_values(array_filter($plan, fn ($p) => $p[0]->lte($end)));
        usort($plan, fn ($a, $b) => $a[0] <=> $b[0]);

        $number = 0;
        foreach ($plan as [$date, $supplierName]) {
            $number++;
            $date = $date->copy()->setTime(mt_rand(8, 16), mt_rand(0, 59));
            $sup = $supplier[$supplierName];
            $items = array_filter($product, fn ($p) => in_array($p['category'], $sup['sells']));
            $keys = array_keys($items);
            shuffle($keys);
            $keys = array_slice($keys, 0, min(count($keys), mt_rand(2, 4)));
            if ($supplierName == 'Daru Salaam Electronics') {
                $keys = array_keys($items);
            }

            $lines = [];
            $subTotal = $taxTotal = $grandTotal = $qtyTotal = 0;
            foreach ($keys as $name) {
                $p = $items[$name];
                $qty = mt_rand($p['qty'][0], $p['qty'][1]);
                $rate = $p['price'];
                $lineSub = $rate * $qty;
                $lineTax = round($lineSub * $taxPercent / 100, 2);
                $lineTotal = round($lineSub + $lineTax, 2);
                $subTotal += $lineSub;
                $taxTotal += $lineTax;
                $grandTotal += $lineTotal;
                $qtyTotal += $qty;
                $lines[] = [
                    'type' => 1, 'quantity' => $qty, 'product_id' => $p['id'], 'product_name' => $name,
                    'rate' => $rate, 'purchase_price' => $rate, 'total' => $lineTotal, 'discount' => 0,
                    'tax_percentage' => $taxPercent, 'tax_amount' => $lineTax,
                    'created_at' => $date, 'updated_at' => $date,
                ];
            }

            $purchaseId = DB::table('purchases')->insertGetId([
                'purchase_date'     => $date,
                'purchase_number'   => (string) $number,
                'invoice_number'    => strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $supplierName), 0, 3)) . '-' . $date->format('ymd') . '-' . mt_rand(100, 999),
                'invoice_date'      => $date->toDateString(),
                'supplier_name'     => $supplierName,
                'supplier_id'       => $sup['id'],
                'discount'          => $taxPercent,
                'discount_total'    => 0,
                'sub_total'         => $subTotal,
                'tax_amount'        => $taxTotal,
                'taxable_amount'    => $subTotal,
                'total'             => round($grandTotal, 2),
                'status'            => 1,
                'notes'             => null,
                'total_quantity'    => $qtyTotal,
                'created_by'        => 1,
                'financial_year_id' => null,
                'created_at'        => $date,
                'updated_at'        => $date,
            ]);
            foreach ($lines as &$line) {
                $line['purchase_id'] = $purchaseId;
            }
            DB::table('purchase_details')->insert($lines);

            /* most suppliers are paid on the spot; a few purchases are on credit or part-paid */
            $total = round($grandTotal, 2);
            $roll = mt_rand(1, 100);
            $paid = $date->diffInDays($end) < 10 && $roll <= 40 ? 0 : ($roll <= 80 ? $total : round($total * 0.5, 2));
            if ($paid > 0) {
                DB::table('purchase_payments')->insert([
                    'purchase_id' => $purchaseId, 'supplier_id' => $sup['id'], 'paid_amount' => $paid,
                    'payment_method' => $this->paymentMethod(), 'note' => null,
                    'payment_remarks' => $paid < $total ? 'Qayb ka mid ah lacagta' : null,
                    'created_by' => 1, 'created_at' => $date, 'updated_at' => $date,
                ]);
            }
        }
        $this->command?->info("Created {$number} sample purchases.");
    }

    /**
     * Weekly stock usage based on how many orders (and dry cleaning items) were
     * processed that week, never using more than was in stock on that day.
     */
    private function seedStockUsage(Carbon $start, Carbon $end)
    {
        /* sku => [usage per order, note] ; KM-004 is per dry cleaning item */
        $rates = [
            'SB-001' => [0.30, 'Saabuunta mashiinada dhaqista'],
            'SB-002' => [0.12, 'Dhaqista gacanta iyo dharka jilicsan'],
            'KM-001' => [0.08, 'Dharka cadcad'],
            'KM-004' => [0.12, 'Dry cleaning suudadka iyo koodhadka'],
            'BK-001' => [0.09, 'Baakadaynta dharka la diyaariyay'],
            'BK-002' => [0.015, 'Katiinadaha suudadka iyo shaatiyada'],
            'BK-003' => [0.04, 'Calaamadaynta dalabyada'],
            'BK-004' => [0.03, 'Xirxirka baakadaha'],
        ];
        $products = DB::table('products')->whereIn('sku', array_keys($rates))->get()->keyBy('sku');
        $dryCleaningType = DB::table('service_types')->where('service_type_name', 'Dry Cleaning')->value('id');
        $dryCleaningServices = $dryCleaningType ? ['Dry Cleaning'] : [];

        $used = array_fill_keys(array_keys($rates), 0);
        $rows = [];
        $weekStart = $start->copy();
        while ($weekStart->lte($end)) {
            $weekEnd = $weekStart->copy()->addDays(6)->min($end);
            $orders = DB::table('orders')->whereBetween('order_date', [$weekStart->copy()->startOfDay(), $weekEnd->copy()->endOfDay()])->count();
            $dryItems = DB::table('order_details')->join('orders', 'orders.id', '=', 'order_details.order_id')
                ->whereBetween('orders.order_date', [$weekStart->copy()->startOfDay(), $weekEnd->copy()->endOfDay()])
                ->whereIn('order_details.service_name', $dryCleaningServices)
                ->sum(DB::raw('CAST(order_details.service_quantity AS DECIMAL(10,2))'));

            foreach ($rates as $sku => [$rate, $note]) {
                $product = $products[$sku] ?? null;
                if (!$product) {
                    continue;
                }
                /* stock available at the end of this week */
                $purchased = DB::table('purchase_details')->join('purchases', 'purchases.id', '=', 'purchase_details.purchase_id')
                    ->where('purchase_details.product_id', $product->id)
                    ->where('purchases.purchase_date', '<=', $weekEnd->copy()->endOfDay())
                    ->selectRaw('COALESCE(SUM(purchase_details.quantity), 0) qty, COALESCE(SUM(purchase_details.quantity * purchase_details.rate), 0) amount')
                    ->first();
                $available = $product->opening_stock + $purchased->qty - $used[$sku];
                $wanted = ($sku == 'KM-004' ? $dryItems : $orders) * $rate * mt_rand(85, 115) / 100;
                $step = in_array($product->unit_id, DB::table('units')->whereIn('short_form', ['pcs', 'pkt', 'roll', 'ctn'])->pluck('id')->all()) ? 1 : 0.5;
                $qty = floor(min($wanted, max($available - $step, 0)) / $step) * $step;
                if ($qty <= 0) {
                    continue;
                }
                /* weighted average cost of everything bought up to this week */
                $totalQty = $product->opening_stock + $purchased->qty;
                $unitCost = $totalQty > 0 ? round(($product->opening_stock * $product->purchase_price + $purchased->amount) / $totalQty, 4) : $product->purchase_price;
                $used[$sku] += $qty;
                $time = $weekEnd->copy()->setTime(18, mt_rand(0, 59));
                $rows[] = [
                    'usage_date'        => $weekEnd->toDateString(),
                    'product_id'        => $product->id,
                    'quantity'          => $qty,
                    'unit_cost'         => $unitCost,
                    'total_cost'        => round($unitCost * $qty, 2),
                    'note'              => $note,
                    'financial_year_id' => $this->financialYearId($weekEnd),
                    'created_by'        => 1,
                    'created_at'        => $time,
                    'updated_at'        => $time,
                ];
            }
            $weekStart->addDays(7);
        }
        DB::table('stock_usages')->insert($rows);
        $this->command?->info('Created ' . count($rows) . ' sample stock usage entries.');
    }
}
