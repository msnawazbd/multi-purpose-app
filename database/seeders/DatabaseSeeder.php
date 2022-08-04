<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountryTableSeeder::class,
            UserTableSeeder::class,
            ClientTableSeeder::class,
            AppointmentTableSeeder::class,
            TaskTableSeeder::class,
            TaskUserTableSeeder::class,
            TaxTableSeeder::class,
            ServiceTableSeeder::class,
            InvoiceTableSeeder::class,
            InvoiceDetailTableSeeder::class,
            RoleTableSeeder::class,
            PermissionTableSeeder::class,
            PlanTableSeeder::class,
            FaqTableSeeder::class,
            BlogCategoryTableSeeder::class,
            BlogPostTableSeeder::class,
            ContactMessageTableSeeder::class,
            PageTableSeeder::class,
            SubscribeTableSeeder::class,
            TestimonialTableSeeder::class,
            StateTableSeeder::class,
            CityTableSeeder::class,
        ]);
    }
}
