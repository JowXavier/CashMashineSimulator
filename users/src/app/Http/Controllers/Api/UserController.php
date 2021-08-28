<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $users = $this->model->paginate();
            if (isset($request->filter)) {
                $users = $this->model->ofFilter($request->filter)->paginate();
            }

            return UserResource::collection($users);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            return new UserResource($this->model->create($request->all()));
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = $this->model->find($id);

            if (empty($user)) {
                return response()->json(
                    [
                        'message' => "Não existe o registro {$id}"
                    ],
                    404
                );
            }

            return new UserResource($user);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $user = $this->model->find($id);

            if (empty($user)) {
                return response()->json(
                    [
                        'message' => "Não existe o registro {$id}"
                    ],
                    404
                );
            }

            $user->update($request->all());

            return new UserResource($user);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = $this->model->find($id);

            if (empty($user)) {
                return response()->json(
                    [
                        'message' => "Não existe o registro {$id}"
                    ],
                    404
                );
            }

            $user->delete();

            return new UserResource($user);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }
}
