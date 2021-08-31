<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\OperationType;
use Database\Seeders\OperationTypeSeeder;

class TransactiontTest extends TestCase
{
    protected $endpoint = '/api/transactions';
    protected $operationType;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(OperationTypeSeeder::class);
        $this->operationType = OperationType::first();
    }

    /**
     * Deposit Exception Cents
     *
     * @return void
     */
    public function testDepositExceptionCents()
    {
        $account = Account::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'account_id' => $account->id,
            'operation_type_id' => $this->operationType->id,
            'value' => 60.10
        ]);

        //dd($response);

        $response
            ->assertJsonCount(1, 'errors')
            ->assertStatus(422);

        $this->assertEquals('O campo value deve possuir apenas números', $response['errors']['value'][0]);
    }

    /**
     * List all
     *
     * @return void
     */
    public function testListAll()
    {
        Transaction::factory(10)->create();
        $response = $this->getJson($this->endpoint);

        $response
            ->assertStatus(200);
    }

    /**
     * Error list single
     *
     * @return void
     */
    public function testErrorListSingle()
    {
        $id = 20;
        $response = $this->getJson("{$this->endpoint}/{$id}");

        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => "Não existe o registro {$id}"
            ]);
    }

    /**
     * List single
     *
     * @return void
     */
    public function testListSingle()
    {
        $transaction = Transaction::factory()->create();
        $response = $this->getJson("{$this->endpoint}/{$transaction->id}");

        $response
            ->assertStatus(200);

        $this->assertEquals($transaction->id, $response['data']['id']);
    }

    /**
     * Validation Store
     *
     * @return void
     */
    public function testValidationStore()
    {
        $response = $this->postJson($this->endpoint, [
            'account_id' => '',
            'operation_type_id' => '',
            'value' => ''
        ]);

        $response
            ->assertJsonCount(3, 'errors')
            ->assertStatus(422);
    }

    /**
     * Store
     *
     * @return void
     */
    public function testStore()
    {
        $account = Account::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'account_id' => $account->id,
            'operation_type_id' => $this->operationType->id,
            'value' => 100.00
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => $response['data']['id'],
                    'value' => $response['data']['value']
                ]
            ]);
    }

    /**
     * Validation Update
     *
     * @return void
     */
    public function testValidationUpdate()
    {
        $transaction = Transaction::factory()->create();
        $response = $this->putJson("{$this->endpoint}/{$transaction->id}", [
            'account_id' => '',
            'operation_type_id' => '',
            'value' => ''
        ]);

        $response
            ->assertJsonCount(3, 'errors')
            ->assertStatus(422);
    }

    /**
     * Update
     *
     * @return void
     */
    public function testUpdate()
    {
        $account = Account::factory()->create();
        $transaction = Transaction::factory()->create();

        $response = $this->putJson("{$this->endpoint}/{$transaction->id}", [
            'account_id' => $account->id,
            'operation_type_id' => $this->operationType->id,
            'value' => 100.00
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $response['data']['id'],
                    'value' => $response['data']['value']
                ]
            ]);
    }

    /**
     * Delete
     *
     * @return void
     */
    public function testDelete()
    {
        $transaction = Transaction::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/{$transaction->id}");
        $response->assertStatus(200);
    }
}