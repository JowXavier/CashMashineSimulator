<?php

namespace App\Services;

class Account
{
    public function calculateBalance($params = [])
    {
        try {
            $operation = $params['operation'];
            $balance = $params['balance'];
            $value = $params['value'];

            if ($operation == 1) {
                return $balance - $value;
            }

            return $balance + $value;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}