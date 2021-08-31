<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;
use PHPAbstractKafka\KafkaProducer;
use Psr\Container\ContainerInterface;

class UserObserver
{
    protected $producer;

    public function __construct(ContainerInterface $container)
    {
        $topicConf = $container->get("KafkaTopicConfig");
        $brokerCollection = $container->get("KafkaBrokerCollection");

        $this->producer = new KafkaProducer(
            $brokerCollection,
            "users",
            $topicConf
        );
    }

    /**
     * Handle the user "creating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        $user->uuid = Str::uuid();
    }

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $this->producer->produce($user);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $this->producer->produce($user);
    }
}
