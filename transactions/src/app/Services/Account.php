<?php

namespace App\Services;

class Account
{
    public function operationCalculate($params = [])
    {
        try {
            $operation = $params['operation'];
            $balance = $params['balance'];
            $value = $params['value'];

            if ($operation == 1) {
                $withdrawal = $this->withdrawal($params);

                $data['result'] = $withdrawal;

                if (!isset($withdrawal['error'])) {
                    $data['balance'] = $balance - $value;
                }

                return $data;

            }

            return [
                'result' => [
                    'message' => 'Operação realizada com sucesso.'
                ],
                'balance' => $balance + $value
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function withdrawal($params = [])
    {
        try {
            $balance = $params['balance'];
            $money = $params['value'];

            $messageFailure = 'Falha na Operação';
            $bills = [100, 50, 20];
            $values = [];

            if ($money < end($bills)) {
                return [
                    "message" => $messageFailure,
                    'error' => [
                        'Valor minimo para saque é de R$ 20,00.'
                    ]
                ];
            }

            $moneyQtyBills = $money / count($bills);
            if ($moneyQtyBills == end($bills)) {
                asort($bills);
            }

            if ($money > $balance) {
                return [
                    "message" => $messageFailure,
                    'error' => [
                        'Saldo insuficiente.'
                    ]
                ];
            }

            $moneyValue = $money;
            foreach ($bills as $value) {
                while ($value <= $money) {
                    array_push($values, $value);
                    $money -= $value;
                }
            }

            $total = array_reduce($values, function($sum, $value) {
                $sum += $value;
                return $sum;
            });

            if ($total < $moneyValue) {
                return [
                    "message" => $messageFailure,
                    'error' => [
                        'Não é possível realizar o saque.'
                    ]
                ];
            }

            $values = array_filter($values, function($value) {
                return (float) $value;
            });

            return [
                'bills' => $values
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}