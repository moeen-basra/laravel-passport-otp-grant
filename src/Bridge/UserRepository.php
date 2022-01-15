<?php

namespace MoeenBasra\OneTimePinGrant\Bridge;

use RuntimeException;
use Laravel\Passport\Bridge\User;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use MoeenBasra\OneTimePinGrant\Interfaces\OneTimePinGrantUserInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        $provider = $clientEntity->provider ?: config('auth.guards.api.provider');

        if (is_null($model = config('auth.providers.' . $provider . '.model'))) {
            throw new RuntimeException('Unable to determine authentication model from configuration.');
        }

        $instance = new $model;

        if (!$instance instanceof OneTimePinGrantUserInterface) {
            $interface = OneTimePinGrantUserInterface::class;

            throw new RuntimeException(sprintf(
                'The model %s must implement the %s interface',
                $model,
                $interface
            ));
        }

        $user = (new $model)
            ->findAndValidateForPassportOtpGrant($username, $password);

        if ($user) {
            return new User($user->getAuthIdentifier());
        }
        return null;
    }
}
