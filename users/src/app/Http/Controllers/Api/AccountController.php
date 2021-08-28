<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\AccountResource;

class AccountController extends Controller
{
    protected $model;

    public function __construct(Account $account)
    {
        $this->model = $account;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $accounts = $this->model->paginate();
            if (isset($request->filter)) {
                $accounts = $this->model->ofFilter($request->filter)->paginate();
            }

            return AccountResource::collection($accounts);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountRequest $request)
    {
        try {
            return new AccountResource($this->model->create($request->all()));
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
            $account = $this->model->find($id);

            if (empty($account)) {
                return response()->json(
                    [
                        'message' => "Não existe o registro {$id}"
                    ],
                    404
                );
            }

            return new AccountResource($account);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AccountRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountRequest $request, $id)
    {
        try {
            $account = $this->model->find($id);

            if (empty($account)) {
                return response()->json(
                    [
                        'message' => "Não existe o registro {$id}"
                    ],
                    404
                );
            }

            $account->update($request->all());

            return new AccountResource($account);
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
            $account = $this->model->find($id);

            if (empty($account)) {
                return response()->json(
                    [
                        'message' => "Não existe o registro {$id}"
                    ],
                    404
                );
            }

            $account->delete();

            return new AccountResource($account);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }
}
