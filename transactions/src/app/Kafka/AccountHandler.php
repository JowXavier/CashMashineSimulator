<?php

namespace App\Kafka;

use App\Models\User;
use App\Models\Account;
use PHPAbstractKafka\Contracts\KafkaConsumerHandlerInterface;

class AccountHandler implements KafkaConsumerHandlerInterface
{
    public function __invoke(\RdKafka\Message $message, \RdKafka\KafkaConsumer $consumer)
    {
        $payload = json_decode($message->payload);

        $user = User::firstOrCreate(
            [ 'id' => $payload->user->id],
            [
                'id' => $payload->user->id,
                'name' => $payload->user->name,
                'birth_date' => $payload->user->birth_date,
                'cpf' => $payload->user->cpf
            ]
        );

        $account = Account::firstOrCreate(
            [ 'id' => $payload->id],
            [
                'user_id' => $user->id,
                'agency' => $payload->agency,
                'account' => $payload->account,
                'type' => $payload->type,
                'balance' => $payload->balance
            ]
        );

        print_r($account->toJson());
    }
}