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
    // Use raw SQL to modify foreign key constraints to add CASCADE DELETE
    DB::statement('ALTER TABLE affiliate_users DROP FOREIGN KEY affiliate_users_affiliated_by_foreign');
    DB::statement('ALTER TABLE affiliate_users ADD CONSTRAINT affiliate_users_affiliated_by_foreign FOREIGN KEY (affiliated_by) REFERENCES users(id) ON DELETE CASCADE');

    DB::statement('ALTER TABLE affiliate_users DROP FOREIGN KEY affiliate_users_user_id_foreign');
    DB::statement('ALTER TABLE affiliate_users ADD CONSTRAINT affiliate_users_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    // Reverse to no cascade
    DB::statement('ALTER TABLE affiliate_users DROP FOREIGN KEY affiliate_users_affiliated_by_foreign');
    DB::statement('ALTER TABLE affiliate_users ADD CONSTRAINT affiliate_users_affiliated_by_foreign FOREIGN KEY (affiliated_by) REFERENCES users(id)');

    DB::statement('ALTER TABLE affiliate_users DROP FOREIGN KEY affiliate_users_user_id_foreign');
    DB::statement('ALTER TABLE affiliate_users ADD CONSTRAINT affiliate_users_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id)');
  }
};
