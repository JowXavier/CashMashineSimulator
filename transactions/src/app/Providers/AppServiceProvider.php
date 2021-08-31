<?php

namespace App\Providers;

use App\Models\Transaction;
use PHPAbstractKafka\Broker;
use App\Observers\TransactionObserver;
use PHPAbstractKafka\BrokerCollection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Faker\Generator::class, function () {
            return \Faker\Factory::create('pt_BR');
        });

        $this->app->bind("KafkaBrokerCollection", function () {
            $broker = new Broker(config('kafka.host'), config('kafka.port'));
            $kafkaBrokerCollection = new BrokerCollection();
            $kafkaBrokerCollection->addBroker($broker);
            return $kafkaBrokerCollection;
        });

        $this->app->bind("KafkaTopicConfig", function () {
            return [
                'topic' => [
                    'auto.offset.reset' => 'largest'
                ],
                'consumer' => [
                    'enable.auto.commit' => "true",
                    'auto.commit.interval.ms' => "100",
                    'offset.store.method' => 'broker'
                ]
            ];
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Transaction::observe(TransactionObserver::class);
    }
}
