<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use App\Exceptions\ApiException;
use App\Http\Requests\TransactionRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    protected $model;

    public function __construct(Transaction $transaction)
    {
        $this->model = $transaction;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $transactions = $this->model->paginate();

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
            $transaction = $this->model->find($id);

            if (empty($transaction)) {
                return response()->json(
                    [
                        'message' => "Não existe o registro {$id}"
                    ],
                    404
                );
            }

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
