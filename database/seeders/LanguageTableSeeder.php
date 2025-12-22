<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class LanguageTableSeeder
 */
class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permission only if not exists
        $manageLang = Permission::firstOrCreate([
            'name' => 'manage_language',
        ], [
            'display_name' => 'Manage Language',
        ]);

        /** @var Role|null $adminRole */
        $adminRole = Role::whereName('super_admin')->first();

        // 🔥 Prevent crash if role not present
        if ($adminRole) {
            $adminRole->givePermissionTo($manageLang);
        }

        // Languages seeding (safe)
        Language::firstOrCreate(['iso_code' => 'ar'], ['name' => 'Arabic', 'is_default' => false]);
        Language::firstOrCreate(['iso_code' => 'zh'], ['name' => 'Chinese', 'is_default' => false]);
        Language::firstOrCreate(['iso_code' => 'en'], ['name' => 'English', 'is_default' => true]);
        Language::firstOrCreate(['iso_code' => 'fr'], ['name' => 'French', 'is_default' => false]);
        Language::firstOrCreate(['iso_code' => 'de'], ['name' => 'German', 'is_default' => false]);
        Language::firstOrCreate(['iso_code' => 'pt'], ['name' => 'Portuguese', 'is_default' => false]);
        Language::firstOrCreate(['iso_code' => 'ru'], ['name' => 'Russian', 'is_default' => false]);
        Language::firstOrCreate(['iso_code' => 'es'], ['name' => 'Spanish', 'is_default' => false]);
        Language::firstOrCreate(['iso_code' => 'tr'], ['name' => 'Turkish', 'is_default' => false]);
    }
}
