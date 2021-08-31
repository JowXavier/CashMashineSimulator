<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;

class AccountTest extends TestCase
{
    /**
     * Check columns mass assignable
     *
     * @return void
     */
    public function testCheckColumns()
    {
        $account = new Account;
        $columns = [
            'user_id',
            'agency',
            'account',
            'type',
            'balance'
        ];
        $data = array_diff($columns, $account->getFillable());

        $this->assertEquals(0, count($data));
    }

    /**
     * List all
     *
     * @return void
     */
    public function testListAll()
    {
        $accounts = Account::factory(10)->create();
        $this->assertEquals(10, $accounts->count());
    }

    /**
     * List single
     *
     * @return void
     */
    public function testListSingle()
    {
        $created = Account::factory()->create();
        $account = Account::find($created->id);

        $this->assertEquals($created->agency, $account->agency);
        $this->assertEquals($created->account, $account->account);
        $this->assertEquals($created->type, $account->type);
        $this->assertEquals($created->balance, $account->balance);
    }

    /**
     * Store
     *
     * @return void
     */
    public function testStore()
    {
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'agency' => '5520',
            'account' => '10213-5',
            'type' => 'CORRENTE',
            'balance' => 100.00
        ];
        $account = Account::create($data);

        $this->assertEquals($data['agency'], $account->agency);
        $this->assertEquals($data['account'], $account->account);
        $this->assertEquals($data['type'], $account->type);
        $this->assertEquals($data['balance'], $account->balance);
    }

    /**
     * Update
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = User::factory()->create();
        $created = Account::factory()->create();
        $data = [
            'user_id' => $user->id,
            'agency' => '5520',
            'account' => '10213-5',
            'type' => 'CORRENTE',
            'balance' => 100.00
        ];

        $account = Account::find($created->id);
        $account->update($data);

        $this->assertEquals($data['agency'], $account->agency);
        $this->assertEquals($data['account'], $account->account);
        $this->assertEquals($data['type'], $account->type);
        $this->assertEquals($data['balance'], $account->balance);
    }

    /**
     * Delete
     *
     * @return void
     */
    public function testDelete()
    {
        $account = Account::factory()->create();
        $account->delete();

        $deleted = Account::find($account->id);

        $this->assertEmpty($deleted);
    }
}