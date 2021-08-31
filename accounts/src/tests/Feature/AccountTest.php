<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;

class AccountTest extends TestCase
{
    protected $endpoint = '/api/accounts';

    /**
     * List all
     *
     * @return void
     */
    public function testListAll()
    {
        Account::factory(10)->create();
        $response = $this->getJson($this->endpoint);

        $response
            ->assertStatus(200)
            ->assertJsonCount(10, 'data');
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
        $account = Account::factory()->create();
        $response = $this->getJson("{$this->endpoint}/{$account->id}");

        $response
            ->assertStatus(200);

        $this->assertEquals($account->id, $response['data']['id']);
        $this->assertEquals($account->agency, $response['data']['agency']);
        $this->assertEquals($account->account, $response['data']['account']);
        $this->assertEquals($account->type, $response['data']['type']);
        $this->assertEquals($account->balance, $response['data']['balance']);
    }

    /**
     * Validation Store
     *
     * @return void
     */
    public function testValidationStore()
    {
        $response = $this->postJson($this->endpoint, [
            'user_id' => '',
            'agency' => '',
            'account' => '',
            'type' => '',
            'balance' => ''
        ]);

        $response
            ->assertJsonCount(5, 'errors')
            ->assertStatus(422);
    }

    /**
     * Store
     *
     * @return void
     */
    public function testStore()
    {
        $user = User::factory()->create();
        $response = $this->postJson($this->endpoint, [
            'user_id' => $user->id,
            'agency' => '5520',
            'account' => '10213-5',
            'type' => 'CORRENTE',
            'balance' => 100.00
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => $response['data']['id'],
                    'agency' => $response['data']['agency'],
                    'account' => $response['data']['account'],
                    'type' => $response['data']['type'],
                    'balance' => $response['data']['balance']
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
        $account = Account::factory()->create();
        $response = $this->putJson("{$this->endpoint}/{$account->id}", [
            'user_id' => '',
            'agency' => '',
            'account' => '',
            'type' => '',
            'balance' => ''
        ]);

        $response
            ->assertJsonCount(5, 'errors')
            ->assertStatus(422);
    }

    /**
     * Update
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();
        $response = $this->putJson("{$this->endpoint}/{$account->id}", [
            'user_id' => $user->id,
            'agency' => '5520',
            'account' => '10213-5',
            'type' => 'CORRENTE',
            'balance' => 100.00
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $response['data']['id'],
                    'agency' => $response['data']['agency'],
                    'account' => $response['data']['account'],
                    'type' => $response['data']['type'],
                    'balance' => $response['data']['balance']
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
        $account = Account::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/{$account->id}");
        $response->assertStatus(200);
    }
}