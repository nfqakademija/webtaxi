<?php

namespace Webtaxi\MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WebtaxiMainBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
