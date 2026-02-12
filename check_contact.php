<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::where('id', '!=', 1)->whereHas('roles', function ($q) {
  $q->whereIn('name', ['super_admin', 'sales']);
})->take(5)->get(['id', 'first_name', 'contact']);

foreach ($users as $user) {
  echo "ID: {$user->id}, Name: {$user->first_name}, Contact: " . ($user->contact ?? 'null') . "\n";
}
