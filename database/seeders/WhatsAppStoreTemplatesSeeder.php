<?php

namespace Database\Seeders;

use App\Models\WpStoreTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhatsAppStoreTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $templates = [
            'beauty_products' => ('assets/img/whatsapp_store_templates/beauty_product.png'),
            'ecommerce' => ('assets/img/whatsapp_store_templates/ecommerce.png'),
            'restaurant' => ('assets/img/whatsapp_store_templates/restaurant.png'),
            'grocery_store' => ('assets/img/whatsapp_store_templates/grocery_store.png'),
            'cloth_store' => ('assets/img/whatsapp_store_templates/cloth_store.png'),
            'home_decor' => ('assets/img/whatsapp_store_templates/home_decor.png'),
            'jewellery' => ('assets/img/whatsapp_store_templates/jewellery.png'),
            'travel' => ('assets/img/whatsapp_store_templates/travel.png'),
        ];

        foreach ($templates as $name => $template) {
            $templates = WpStoreTemplate::where('name', $name)->exists();
            if (!$templates) {
                WpStoreTemplate::create(['name' => $name, 'path' => $template]);
            }
        }

    }
}
