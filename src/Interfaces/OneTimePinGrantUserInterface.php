<?php

namespace MoeenBasra\OneTimePinGrant\Interfaces;

use League\OAuth2\Server\Entities\UserEntityInterface;

interface OneTimePinGrantUserInterface
{
    /**
     * Check the verification code is valid.
     *
     * @param string $mobile_number
     * @param string $code
     *
     * @return null|UserEntityInterface
     */
    public function validateForPassportOtpGrant(string $mobile_number, string $code);
}
