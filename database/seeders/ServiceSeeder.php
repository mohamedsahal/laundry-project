<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Seed Somali laundry services and service types with default icons.
     */
    public function run(): void
    {
        /* service type => price multiplier of the item's base price */
        $types = [
            'Dhaqid'             => 1,
            'Feero'              => 0.5,
            'Dhaqid iyo Feero'   => 1.4,
            'Dry Cleaning'       => 2.5,
            'Dhaqid Degdeg ah'   => 1.8,
        ];
        $typeIds = [];
        foreach ($types as $name => $multiplier) {
            $typeIds[$name] = ServiceType::firstOrCreate(
                ['service_type_name' => $name],
                ['is_active' => 1]
            )->id;
        }

        /* service name => [default icon, base price, can be ironed] */
        $services = [
            'Shaati'           => ['shirt.png', 0.50, true],
            'Surwaal'          => ['pants.png', 0.50, true],
            'Funaanad'         => ['tshirt.png', 0.40, true],
            'Jiinis'           => ['jeans.png', 0.60, true],
            'Khamiis'          => ['shirt.png', 0.75, true],
            'Macawis'          => ['pants.png', 0.50, true],
            'Koodh'            => ['blazer.png', 1.50, true],
            'Suud'             => ['full-suit.png', 3.00, true],
            'Jaakad'           => ['jacket.png', 2.00, true],
            'Sweater'          => ['sweater.png', 1.00, true],
            'Dirac'            => ['woman-clothes.png', 1.00, true],
            'Jalbaab'          => ['women-suit.png', 1.25, true],
            'Garbasaar'        => ['women-top.png', 0.50, true],
            'Koofiyad'         => ['cap.png', 0.25, false],
            'Sharabaad'        => ['socks.png', 0.25, false],
            'Dharka Carruurta' => ['kids-cloths.png', 0.30, true],
            "Go' Sariir"       => ['bed-sheets.png', 1.00, true],
            'Barkin'           => ['pillow.png', 0.75, false],
            'Buste'            => ['bed-sheets.png', 3.00, false],
            'Roog'             => ['carpet.png', 5.00, false],
            'Kabo'             => ['shoes.png', 2.00, false],
            'Shandad'          => ['bag.png', 2.00, false],
        ];

        foreach ($services as $name => [$icon, $basePrice, $canIron]) {
            $service = Service::firstOrCreate(
                ['service_name' => $name],
                ['icon' => $icon, 'icon_type' => 1, 'is_active' => 1]
            );
            foreach ($types as $typeName => $multiplier) {
                if (!$canIron && in_array($typeName, ['Feero', 'Dhaqid iyo Feero'])) {
                    continue;
                }
                ServiceDetail::firstOrCreate(
                    ['service_id' => $service->id, 'service_type_id' => $typeIds[$typeName]],
                    ['service_price' => round($basePrice * $multiplier * 4) / 4 ?: 0.25]
                );
            }
        }
    }
}
