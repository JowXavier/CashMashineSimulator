<?php

namespace App\Observers;

use App\Models\Account;
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
     * Handle the Account "created" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function created(Account $account)
    {
        $data = [
            'id' => $account->id,
            'user_id' => $account->user_id,
            'agency' => $account->agency,
            'account' => $account->account,
            'type' => $account->type,
            'balance' => $account->balance,
            'users' => [
                'name' => $account->user->name
            ]
        ];

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
        $this->producer->produce($account->toJson());
    }

    /**
     * Handle the Account "deleted" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function deleted(Account $account)
    {
        //
    }

    /**
     * Handle the Account "restored" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function restored(Account $account)
    {
        //
    }

    /**
     * Handle the Account "force deleted" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function forceDeleted(Account $account)
    {
        //
    }
}
