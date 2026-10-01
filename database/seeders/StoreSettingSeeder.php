<?php

namespace Database\Seeders;

use App\Models\StoreSetting;
use Illuminate\Database\Seeder;

class StoreSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'store_name', 'value' => 'متجر الإلكترونيات'],
            ['key' => 'store_email', 'value' => 'info@store.com'],
            ['key' => 'store_phone', 'value' => '+966500000000'],
            ['key' => 'store_address', 'value' => 'الرياض، السعودية'],
            ['key' => 'currency', 'value' => 'SAR'],
            ['key' => 'tax_rate', 'value' => '15'],
            ['key' => 'shipping_cost', 'value' => '25'],
            ['key' => 'free_shipping_threshold', 'value' => '200'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/mystore'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/mystore'],
            ['key' => 'maintenance_mode', 'value' => '0'],
        ];

        foreach ($settings as $setting) {
            StoreSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}