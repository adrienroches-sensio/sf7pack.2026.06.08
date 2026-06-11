<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private PasswordHasherFactoryInterface $hasherFactory)
    {
    }

    public static function class(): string
    {
        return User::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'email' => self::faker()->email(),
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
            'roles' => [],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
             ->afterInstantiate(function(User $user): void {
                 $user->setPassword($this->hasherFactory->getPasswordHasher(User::class)->hash($user->getEmail()));
             })
        ;
    }
}
