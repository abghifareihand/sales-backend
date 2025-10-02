<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Mas Owner',
            'username' => 'owner',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        User::create([
            'name' => 'Admin Pusat',
            'username' => 'pusat',
            'password' => Hash::make('password'),
            'role' => 'pusat',
        ]);

        User::create([
            'name' => 'Admin Cabang',
            'username' => 'cabang',
            'password' => Hash::make('password'),
            'role' => 'cabang',
        ]);

        // Products
        $products = [
            ['name'=>'Voucher 3GB','description'=>'Kuota 3GB, berlaku 30 hari','cost_price'=>10000,'selling_price'=>15000,'provider'=>'Telkomsel','category'=>'Internet','zona'=>'Jabodetabek','kuota'=>'3GB','expired'=>Carbon::now()->addMonths(1)],
            ['name'=>'Voucher 5GB','description'=>'Kuota 5GB, berlaku 30 hari','cost_price'=>15000,'selling_price'=>20000,'provider'=>'Indosat','category'=>'Internet','zona'=>'Jawa Barat','kuota'=>'5GB','expired'=>Carbon::now()->addMonths(1)],
            ['name'=>'Voucher 10GB','description'=>'Kuota 10GB, berlaku 30 hari','cost_price'=>25000,'selling_price'=>30000,'provider'=>'XL','category'=>'Internet','zona'=>'Jawa Timur','kuota'=>'10GB','expired'=>Carbon::now()->addMonths(2)],
            ['name'=>'Voucher 1GB','description'=>'Kuota 1GB, berlaku 7 hari','cost_price'=>5000,'selling_price'=>8000,'provider'=>'Tri','category'=>'Internet','zona'=>'Sumatera','kuota'=>'1GB','expired'=>Carbon::now()->addWeeks(1)],
            ['name'=>'Voucher 20GB','description'=>'Kuota 20GB, berlaku 30 hari','cost_price'=>40000,'selling_price'=>50000,'provider'=>'Smartfren','category'=>'Internet','zona'=>'Seluruh Indonesia','kuota'=>'20GB','expired'=>Carbon::now()->addMonths(3)],
            ['name'=>'Kuota 2GB','description'=>'Kuota 2GB, berlaku 14 hari','cost_price'=>8000,'selling_price'=>12000,'provider'=>'Telkomsel','category'=>'Internet','zona'=>'Bali','kuota'=>'2GB','expired'=>Carbon::now()->addWeeks(2)],
            ['name'=>'Kuota Malam 5GB','description'=>'Kuota khusus malam, 5GB','cost_price'=>12000,'selling_price'=>17000,'provider'=>'Indosat','category'=>'Internet Malam','zona'=>'Jabodetabek','kuota'=>'5GB','expired'=>Carbon::now()->addMonths(1)],
            ['name'=>'Kuota 15GB + Telepon','description'=>'15GB + 100 menit telepon','cost_price'=>35000,'selling_price'=>45000,'provider'=>'XL','category'=>'Combo','zona'=>'Jawa Tengah','kuota'=>'15GB','expired'=>Carbon::now()->addMonths(2)],
            ['name'=>'Kuota Unlimited 1 Hari','description'=>'Akses unlimited selama 1 hari','cost_price'=>7000,'selling_price'=>10000,'provider'=>'Tri','category'=>'Internet Harian','zona'=>'Seluruh Indonesia','kuota'=>'Unlimited','expired'=>Carbon::now()->addDay()],
            ['name'=>'Kuota 50GB','description'=>'Kuota 50GB, berlaku 30 hari','cost_price'=>100000,'selling_price'=>120000,'provider'=>'Smartfren','category'=>'Internet','zona'=>'Seluruh Indonesia','kuota'=>'50GB','expired'=>Carbon::now()->addMonths(3)],
            ['name'=>'Voucher 500MB','description'=>'Kuota 500MB, berlaku 3 hari','cost_price'=>3000,'selling_price'=>5000,'provider'=>'Telkomsel','category'=>'Internet Harian','zona'=>'Jabodetabek','kuota'=>'500MB','expired'=>Carbon::now()->addDays(3)],
            ['name'=>'Kuota 7GB','description'=>'Kuota 7GB, berlaku 30 hari','cost_price'=>20000,'selling_price'=>25000,'provider'=>'Indosat','category'=>'Internet','zona'=>'Jawa Barat','kuota'=>'7GB','expired'=>Carbon::now()->addMonths(1)],
            ['name'=>'Kuota 12GB','description'=>'Kuota 12GB, berlaku 30 hari','cost_price'=>30000,'selling_price'=>40000,'provider'=>'XL','category'=>'Internet','zona'=>'Jawa Timur','kuota'=>'12GB','expired'=>Carbon::now()->addMonths(1)],
            ['name'=>'Kuota 25GB','description'=>'Kuota 25GB, berlaku 60 hari','cost_price'=>50000,'selling_price'=>60000,'provider'=>'Smartfren','category'=>'Internet','zona'=>'Seluruh Indonesia','kuota'=>'25GB','expired'=>Carbon::now()->addMonths(2)],
            ['name'=>'Kuota 8GB','description'=>'Kuota 8GB, berlaku 30 hari','cost_price'=>22000,'selling_price'=>30000,'provider'=>'Tri','category'=>'Internet','zona'=>'Sumatera','kuota'=>'8GB','expired'=>Carbon::now()->addMonths(1)],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
