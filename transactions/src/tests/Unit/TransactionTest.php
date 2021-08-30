<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\OperationType;
use Database\Seeders\OperationTypeSeeder;

class TransactionTest extends TestCase
{
    protected $operationType;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(OperationTypeSeeder::class);
        $this->operationType = OperationType::first();
    }

    /**
     * Check columns mass assignable
     *
     * @return void
     */
    public function testCheckColumns()
    {
        $transaction = new Transaction;
        $columns = [
            'account_id',
            'operation_type_id',
            'value'
        ];
        $data = array_diff($columns, $transaction->getFillable());

        $this->assertEquals(0, count($data));
    }

    /**
     * List all
     *
     * @return void
     */
    public function testListAll()
    {
        $transactions = Transaction::factory(10)->create();
        $this->assertEquals(10, $transactions->count());
    }

    /**
     * List single
     *
     * @return void
     */
    public function testListSingle()
    {
        $created = Transaction::factory()->create();
        $transaction = Transaction::find($created->id);

        $this->assertEquals($created->value, $transaction->value);
    }

    /**
     * Store
     *
     * @return void
     */
    public function testStore()
    {
        $account = Account::factory()->create();

        $data = [
            'account_id' => $account->id,
            'operation_type_id' => $this->operationType->id,
            'value' => 100.00
        ];
        $transaction = Transaction::create($data);

        $this->assertEquals($data['value'], $transaction->value);
    }

    /**
     * Update
     *
     * @return void
     */
    public function testUpdate()
    {
        $account = Account::factory()->create();
        $created = Transaction::factory()->create();

        $data = [
            'account_id' => $account->id,
            'operation_type_id' => $this->operationType->id,
            'value' => 100.00
        ];

        $transaction = Transaction::find($created->id);
        $transaction->update($data);

        $this->assertEquals($data['value'], $transaction->value);
    }

    /**
     * Delete
     *
     * @return void
     */
    public function testDelete()
    {
        $transaction = Transaction::factory()->create();
        $transaction->delete();

        $deleted = Transaction::find($transaction->id);

        $this->assertEmpty($deleted);
    }
}