<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // first add languages if not exists
        Artisan::call('db:seed', ['--class' => 'LanguageTableSeeder', '--force' => true]);
        // now seed email templates for each language
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesItSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesArSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesZhSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesEnSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesFrSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesDeSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesPtSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesRuSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesEsSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesTrSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesHiSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesViSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'EmailTemplatesFaSeeder', '--force' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
