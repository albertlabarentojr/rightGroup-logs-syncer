<?php

namespace App\Tests\Factory;

use App\Entity\ServiceLog;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<ServiceLog>
 */
final class ServiceLogFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return ServiceLog::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'http_verb' => self::faker()->randomElement(['GET', 'POST', 'PUT', 'DELETE']),
            'log_date' => self::faker()->dateTimeBetween('-3 months'),
            'service_name' => self::faker()->randomElement(['user-service', 'invoice-service']),
            'status_code' => self::faker()->numberBetween(200, 400),
            'url' => self::faker()->randomElement(['/user', '/invoice', '/others']),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(ServiceLog $serviceLog): void {})
        ;
    }
}
