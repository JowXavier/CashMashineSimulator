<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Support\Str;
use PHPAbstractKafka\KafkaProducer;
use Psr\Container\ContainerInterface;

class TransactionObserver
{
    protected $producer;

    public function __construct(ContainerInterface $container)
    {
        $topicConf = $container->get("KafkaTopicConfig");
        $brokerCollection = $container->get("KafkaBrokerCollection");

        $this->producer = new KafkaProducer(
            $brokerCollection,
            "transactions",
            $topicConf
        );
    }

    /**
     * Handle the user "creating" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function creating(Transaction $transaction)
    {
        $transaction->uuid = Str::uuid();
    }

    /**
     * Handle the Transaction "created" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $transaction->account;
        $this->producer->produce($transaction);
    }

    /**
     * Handle the Transaction "updated" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        $transaction->account;
        $this->producer->produce($transaction);
    }
}
