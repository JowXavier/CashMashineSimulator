<?php

namespace App\Kafka;

use App\Models\Account;
use PHPAbstractKafka\Contracts\KafkaConsumerHandlerInterface;

class TransactionHandler implements KafkaConsumerHandlerInterface
{
    public function __invoke(\RdKafka\Message $message, \RdKafka\KafkaConsumer $consumer)
    {
        $payload = json_decode($message->payload);

        if (isset($payload->account->uuid)) {
            $account = Account::where('uuid', $payload->account->uuid)->first();
            $account->update([
                'balance' => $payload->account->balance
            ]);

            print_r($account->toJson());
        } else {
            print_r($message->payload);
        }
    }
}