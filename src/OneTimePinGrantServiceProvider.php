<?php

namespace MoeenBasra\OneTimePinGrant;

use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\GrantTypeInterface;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use MoeenBasra\OneTimePinGrant\Bridge\UserRepository;

class OneTimePinGrantServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->resolving(AuthorizationServer::class, function (AuthorizationServer $server) {
            $server->enableGrantType($this->makeOneTimePinGrant(), Passport::tokensExpireIn());
        });
    }

    protected function makeOneTimePinGrant(): GrantTypeInterface
    {
        $grant = (new OneTimePinGrant(
            $this->app->make(UserRepository::class),
            $this->app->make(RefreshTokenRepository::class)
        ));

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }
}
