<?php

namespace Webtaxi\MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WebtaxiMainBundle extends Bundle
{
    /**
     * not accepted travel expires in TRAVEL_EXPIRE_TIME minutes
     */
    const TRAVEL_EXPIRE_TIME = 30;

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
