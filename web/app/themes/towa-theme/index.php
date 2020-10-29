<?php

use Timber\Timber;
use Towa\Theme\Controller\SectionsCtr;
use Towa\Theme\Cpt\Post;

$context = Timber::get_context();

$context['post'] = new Post();
$context['sections'] = (new SectionsCtr($context['post']))->build();
$context['Hero'] = SectionsCtr::get_hero($context['post']);

//Timber::render(view_path('templates/components.twig'), $context);
Timber::render(view_path('templates/default.twig'), $context);
