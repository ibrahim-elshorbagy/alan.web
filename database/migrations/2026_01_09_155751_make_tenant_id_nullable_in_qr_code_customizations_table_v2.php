<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE qr_code_customizations DROP FOREIGN KEY qr_code_customizations_tenant_id_foreign');
        DB::statement('ALTER TABLE qr_code_customizations MODIFY tenant_id VARCHAR(255) NULL');
        DB::statement('ALTER TABLE qr_code_customizations ADD CONSTRAINT qr_code_customizations_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE qr_code_customizations DROP FOREIGN KEY qr_code_customizations_tenant_id_foreign');
        DB::statement('ALTER TABLE qr_code_customizations MODIFY tenant_id VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE qr_code_customizations ADD CONSTRAINT qr_code_customizations_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE');
    }
};
