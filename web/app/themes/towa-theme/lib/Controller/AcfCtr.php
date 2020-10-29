<?php

namespace Towa\Theme\Controller;

use Towa\Theme\Acf\Groups\DefaultHero;
use Towa\Theme\Acf\Groups\Person;
use Towa\Theme\Acf\Groups\Sections;
use Towa\Theme\Acf\Groups\WSOptions;

class AcfCtr
{
    public function register_groups()
    {
        $Groups = [
            Sections::class,
            WSOptions::class,
            DefaultHero::class,
            Person::class,
        ];

        array_walk($Groups, function ($Group) {
            (new $Group())->register();
        });
    }
}
