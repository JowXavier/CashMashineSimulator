<?php

namespace App\Kafka;

use App\Models\User;
use PHPAbstractKafka\Contracts\KafkaConsumerHandlerInterface;

class UserHandler implements KafkaConsumerHandlerInterface
{
    public function __invoke(\RdKafka\Message $message, \RdKafka\KafkaConsumer $consumer)
    {
        $payload = json_decode($message->payload);

        $user = User::firstOrCreate(
            ['uuid' => $payload->uuid],
            [
                'uuid' => $payload->uuid,
                'name' => $payload->name,
                'birth_date' => $payload->birth_date,
                'cpf' => $payload->cpf
            ]
        );

        print_r($user->toJson());
    }
}