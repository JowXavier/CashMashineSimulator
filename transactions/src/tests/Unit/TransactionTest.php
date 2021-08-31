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
        $this->service = new \App\Services\Account();
    }

    /**
     * Validation Not Bills
     *
     * @return void
     */
    public function testValidationNotBills()
    {
        $params = [
            'operation' => 1,
            'balance' => 100.00,
            'value' => 80.00
        ];
        $operation = $this->service->operationCalculate($params);
        $this->assertEquals(1, count($operation['result']['error']));
    }

    /**
     * Validation withdrawal from 50
     *
     * @return void
     */
    public function testValidationWithdrawalFrom50()
    {
        $params = [
            'operation' => 1,
            'balance' => 200.00,
            'value' => 150.00
        ];
        $operation = $this->service->operationCalculate($params);

        $this->assertEquals(2, count($operation['result']['bills']));
        $this->assertEquals(100, $operation['result']['bills'][0]);
        $this->assertEquals(50, $operation['result']['bills'][1]);
    }

    /**
     * Validation withdrawal from 60
     *
     * @return void
     */
    public function testValidationWithdrawalFrom60()
    {
        $params = [
            'operation' => 1,
            'balance' => 100.00,
            'value' => 60.00
        ];
        $operation = $this->service->operationCalculate($params);

        $this->assertEquals(3, count($operation['result']['bills']));
        $this->assertEquals(20, $operation['result']['bills'][0]);
        $this->assertEquals(20, $operation['result']['bills'][1]);
        $this->assertEquals(20, $operation['result']['bills'][2]);
    }

    /**
     * Validation withdrawal not balance
     *
     * @return void
     */
    public function testValidationWithdrawalNotBalance()
    {
        $params = [
            'operation' => 1,
            'balance' => 100.00,
            'value' => 200.00
        ];
        $operation = $this->service->operationCalculate($params);

        $this->assertEquals(1, count($operation['result']['error']));
    }

    /**
     * Validation withdrawal not bills from 15
     *
     * @return void
     */
    public function testValidationWithdrawalNotBillsFrom15()
    {
        $params = [
            'operation' => 1,
            'balance' => 100.00,
            'value' => 15.00
        ];
        $operation = $this->service->operationCalculate($params);

        $this->assertEquals(1, count($operation['result']['error']));
        $this->assertEquals('Valor minimo para saque é de R$ 20,00.', $operation['result']['error'][0]);
    }

    /**
     * Validation withdrawal not bills from 30
     *
     * @return void
     */
    public function testValidationWithdrawalNotBillsFrom30()
    {
        $params = [
            'operation' => 1,
            'balance' => 100.00,
            'value' => 30.00
        ];
        $operation = $this->service->operationCalculate($params);

        $this->assertEquals(1, count($operation['result']['error']));
        $this->assertEquals('Não é possível realizar o saque.', $operation['result']['error'][0]);
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

        $this->assertEquals($created->uuid, $transaction->uuid);
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