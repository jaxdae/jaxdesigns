<?php

$context = Timber::get_context();
$context['post'] = new TimberPost();

$context['page_404'] = [
    'headline' => __('Seite wurde leider nicht gefunden', 'towa'),
    'content' => get_field('404_content', 'options'),
];

if ($request = $_SERVER['REQUEST_URI']) {
    $keywords = array_filter(explode('/', $request));

    $posts = collect($keywords)
        ->map(function ($keyword) {
            return Timber::get_posts([
                'post_type' => 'any',
                'posts_per_page' => 10,
                's' => $keyword,
            ]);
        })
        ->filter()
        ->flatten(1)
        ->unique('ID');

    $context['maybe'] = [
        'headline' => __('Haben Sie vielleicht nach folgendem gesucht?', 'towa'),
        'posts' => $posts,
    ];
}

Timber::render(view_path('templates/404.twig'), $context);
