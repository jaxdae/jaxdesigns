<?php

use Towa\Theme\Cpt\Post;
//use Towa\Theme\Acf\Groups\DefaultHero;
use Towa\Theme\Controller\SectionsCtr;

$context = Timber::get_context();

$context['post'] = new Post();
$context['sections'] = ( new SectionsCtr($context[ 'post' ]) )->build();
//$context['Hero'] = SectionsCtr::get_hero($context['post']);

//Timber::render(view_path('templates/components.twig'), $context);
Timber::render(view_path('templates/default.twig'), $context);
 