<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\Account as AccountService;

class TransactionController extends Controller
{
    protected $model;
    protected $accountService;

    public function __construct(Transaction $transaction, AccountService $accountService)
    {
        $this->model = $transaction;
        $this->accountService = $accountService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $transactions = $this->model->paginate();

            $expire = 60;
            $key = "extract";

            $transactions = Cache::tags('extracts')->remember($key, $expire, function () use ($request) {
                return $this->model->ofExtract([
                    'operation_type_id' => $request->operation_type_id,
                    'value' => $request->value,
                    'datetime' => $request->datetime,
                ])->paginate();
            });

            return TransactionResource::collection($transactions);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        try {
            $account = Account::find($request->account_id);

            $params = [
                'operation' => $request->operation_type_id,
                'balance' => $account->balance,
                'value' => $request->value,
            ];

            $balance = $this->accountService->calculateBalance($params);
            $account->update(['balance' => $balance]);

            return new TransactionResource($this->model->create($request->all()));
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
            $transaction = $this->model->find($id);

            if (empty($transaction)) {
                return response()->json(
                    [
                        'message' => "Não existe o registro {$id}"
                    ],
                    404
                );
            }

            return new TransactionResource($transaction);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TransactionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, $id)
    {
        try {
            $account = Account::find($request->account_id);

            $params = [
                'operation' => $request->operation_type_id,
                'balance' => $account->balance,
                'value' => $request->value,
            ];

            $balance = $this->accountService->calculateBalance($params);
            $account->update(['balance' => $balance]);

            $transaction = $this->model->find($id);
            $transaction->update($request->all());

            return new TransactionResource($transaction);
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
            $transaction = $this->model->find($id);

            if (empty($transaction)) {
                return response()->json(
                    [
                        'message' => "Não existe o registro {$id}"
                    ],
                    404
                );
            }

            $transaction->delete();

            return new TransactionResource($transaction);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }
}
