<?php

namespace Database\Seeders;

use App\Enums\ActiveStatus;
use App\Enums\UserChangeInfo;
use App\Enums\UserChangePassword;
use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use App\Traits\RenderIdNumberTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserListTestSeeder extends Seeder
{
    use RenderIdNumberTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("TRUNCATE TABLE companies");
        DB::statement("TRUNCATE TABLE customers");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::updateOrCreate([
            'name' => "Admin",
            'email' => "admin@yopmail.com",
            'password' => bcrypt("admin@123"),
            'status' => ActiveStatus::ACTIVE,
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::whereNotIn('email', ['admin@yopmail.com'])->forceDelete();

        for ($i = 0; $i < 20; $i++) {
            $faker = \Faker\Factory::create();
            $email = $i == 19 ? 'user@yopmail.com' : $faker->email;
            $company = Company::create(['name' => $faker->company]);

            $customer = Customer::create([
                'name' => $faker->name,
                'email' => $email,
                'phone_number' => $faker->e164PhoneNumber,
                'company_id' => $company->id,
                'user_number' => $this->renderNumber(app(Customer::class)),
            ]);

            User::create([
                'name' => $faker->name,
                'email' => $email,
                'password' => bcrypt("admin@123"),
                'status' => ActiveStatus::ACTIVE,
                'is_changed_password' => UserChangePassword::CHANGED,
                'is_changed_info' => UserChangeInfo::CHANGED,
                'userable_id' => $customer->id,
                'userable_type' => 'App\Models\Customer',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
