<?php

namespace Database\Seeders;

use App\Models\OperationType;
use Illuminate\Database\Seeder;

class OperationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operationType = [
            [
                'name' => 'Saque'
            ],
            [
                'name' => 'Depósito'
            ]
        ];

        foreach ($operationType as $operation) {
            OperationType::create($operation);
        }
    }
}
