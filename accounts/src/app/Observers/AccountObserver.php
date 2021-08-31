<?php

namespace App\Observers;

use App\Models\Account;
use Illuminate\Support\Str;
use PHPAbstractKafka\KafkaProducer;
use Psr\Container\ContainerInterface;

class AccountObserver
{
    protected $producer;

    public function __construct(ContainerInterface $container)
    {
        $topicConf = $container->get("KafkaTopicConfig");
        $brokerCollection = $container->get("KafkaBrokerCollection");

        $this->producer = new KafkaProducer(
            $brokerCollection,
            "accounts",
            $topicConf
        );
    }

    /**
     * Handle the user "creating" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function creating(Account $account)
    {
        $account->uuid = Str::uuid();
    }

    /**
     * Handle the Account "created" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function created(Account $account)
    {
        $account->user;
        $this->producer->produce($account);
    }

    /**
     * Handle the Account "updated" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function updated(Account $account)
    {
        $account->user;
        $this->producer->produce($account);
    }
}
