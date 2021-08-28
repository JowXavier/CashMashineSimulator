<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    protected $endpoint = '/api/users';

    /**
     * List all
     *
     * @return void
     */
    public function testListAll()
    {
        User::factory(10)->create();
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
        $user = User::factory()->create();
        $response = $this->getJson("{$this->endpoint}/{$user->id}");

        $response
            ->assertStatus(200);

        $this->assertEquals($user->name, $response['data']['name']);
        $this->assertEquals($user->birth_date, $response['data']['birth_date']);
        $this->assertEquals($user->cpf, $response['data']['cpf']);
    }

    /**
     * Validation Store
     *
     * @return void
     */
    public function testValidationStore()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => '',
            'birth_date' => '',
            'cpf' => ''
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
        $response = $this->postJson($this->endpoint, [
            'name' => 'Jonathan Xavier Ribeiro',
            'birth_date' => '1987-03-27',
            'cpf' => '34418916865'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => $response['data']['id'],
                    'name' => $response['data']['name'],
                    'birth_date' => $response['data']['birth_date'],
                    'cpf' => $response['data']['cpf']
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
        $user = User::factory()->create();
        $response = $this->putJson("{$this->endpoint}/{$user->id}", [
            'name' => '',
            'birth_date' => '',
            'cpf' => ''
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
        $user = User::factory()->create();
        $response = $this->putJson("{$this->endpoint}/{$user->id}", [
            'name' => 'Jonathan Xavier Ribeiro',
            'birth_date' => '1987-03-27',
            'cpf' => '34418916865'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $response['data']['id'],
                    'name' => $response['data']['name'],
                    'birth_date' => $response['data']['birth_date'],
                    'cpf' => $response['data']['cpf']
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
        $user = User::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/{$user->id}");
        $response->assertStatus(200);
    }
}
