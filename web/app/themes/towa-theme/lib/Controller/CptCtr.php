<?php

namespace Towa\Theme\Controller;

use Towa\Theme\Cpt\Person;

class CptCtr
{
    public function register_cpts()
    {
        $Cpts = [
             //Person::class,
        ];

        array_walk($Cpts, function ($Cpt) {
            ( new $Cpt() )->register();
        });
    }
}
