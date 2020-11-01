<?php

use Towa\Theme\Controller\SectionsCtr;
use Towa\Theme\Cpt\Post;

$context = Timber::get_context();

$context['post'] = new Post();
$context['sections'] = ( new SectionsCtr($context['post']) )->build();
$context['image'] = SectionsCtr::get_image($context['post']);

 Timber::render(view_path('templates/singlePost.twig'), $context);