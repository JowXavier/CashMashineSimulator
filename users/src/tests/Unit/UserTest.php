<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * Check columns mass assignable
     *
     * @return void
     */
    public function testCheckColumns()
    {
        $user = new User;
        $columns = [
            'name',
            'birth_date',
            'cpf'
        ];
        $data = array_diff($columns, $user->getFillable());

        $this->assertEquals(0, count($data));
    }

    /**
     * List all
     *
     * @return void
     */
    public function testListAll()
    {
        $users = User::factory(10)->create();
        $this->assertEquals(10, $users->count());
    }

    /**
     * List single
     *
     * @return void
     */
    public function testListSingle()
    {
        $created = User::factory()->create();
        $user = User::find($created->id);

        $this->assertEquals($created->name, $user->name);
        $this->assertEquals($created->birth_data, $user->birth_data);
        $this->assertEquals($created->cpf, $user->cpf);
    }

    /**
     * Store
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'name' => 'Jonathan Xavier Ribeiro',
            'birth_date' => '1987-03-27',
            'cpf' => '34418916865'
        ];
        $user = User::create($data);

        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['birth_date'], $user->birth_date);
        $this->assertEquals($data['cpf'], $user->cpf);
    }

    /**
     * Update
     *
     * @return void
     */
    public function testUpdate()
    {
        $created = User::factory()->create();
        $data = [
            'name' => 'Jonathan Xavier Ribeiro',
            'birth_date' => '1987-03-27',
            'cpf' => '34418916865'
        ];

        $user = User::find($created->id);
        $user->update($data);

        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['birth_date'], $user->birth_date);
        $this->assertEquals($data['cpf'], $user->cpf);
    }

    /**
     * Delete
     *
     * @return void
     */
    public function testDelete()
    {
        $user = User::factory()->create();
        $user->delete();

        $deleted = User::find($user->id);

        $this->assertEmpty($deleted);
    }
}
