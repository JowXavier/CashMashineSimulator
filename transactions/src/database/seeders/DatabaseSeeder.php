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
            OperationTypeSeeder::class,
        ]);

        //\App\Models\Transaction::factory(10)->create();
    }
}
