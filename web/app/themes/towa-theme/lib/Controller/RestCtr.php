<?php

namespace Towa\Theme\Controller;

use Timber\Timber;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

class RestCtr
{
    public $version;

    public $namespace;

    public function __construct()
    {
        $this->version = 1;
        $this->namespace = 'towa/v' . $this->version;
    }

    public function register_routes()
    {
        add_action('rest_api_init', [$this, 'add_routes']);
    }

    /**
     * Register the routes for the objects of the controller.
     */
    public function add_routes()
    {
        register_rest_route($this->namespace, '/terms/(?P<taxonomy>\w+)', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'terms'],
            ],
        ]);

        register_rest_route($this->namespace, '/posts/(?P<cpt>\w+)', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'posts'],
            ],
        ]);
    }

    public function terms(WP_REST_Request $request)
    {
        $response = [];
        $taxonomy = $request->get_param('taxonomy');
        $cpt = $request->get_param('cpt');

        if (! taxonomy_exists($taxonomy)) {
            return new WP_Error('invalid_taxonomy', 'Invalid Taxonomy Name', ['status' => 400]);
        }

        $response['terms'] = collect(Timber::get_terms([
            'taxonomy' => $taxonomy,
            'order' => 'DESC',
        ]))
            ->filter(function ($term) {
                return $term->count;
            })
            ->map(function ($term) {
                return [
                    'id' => $term->ID,
                    'name' => $term->name,
                    'active' => false,
                ];
            })
            ->prepend([
                'id' => '*',
                'name' => __('Alle ', 'towa') . get_post_type_object($cpt)->label,
                'active' => true,
            ])
            ->toArray();

        return new WP_REST_Response($response, 200);
    }

    public function posts(WP_REST_Request $request)
    {
        $response = [];
        $cpt = $request->get_param('cpt');
        $taxonomy = $request->get_param('taxonomy');
        $term_id = $request->get_param('termId') ?: '*';
        $offset = $request->get_param('offset');
        $posts_per_page = $request->get_param('count') ?: 12;

        if (! post_type_exists($cpt)) {
            return new WP_Error('invalid_cpt', 'Invalid CPT Name', ['status' => 400]);
        }

        $args = [
            'post_type' => $cpt,
            'posts_per_page' => $posts_per_page,
            'post_status' => 'publish',
            'no_found_rows' => true,
        ];

        if ($term_id && $term_id !== '*') {
            $args['tax_query'][] = [
                'taxonomy' => $taxonomy,
                'terms' => [$term_id],
            ];
        }

        if ($offset) {
            $args['offset'] = $offset;
        }

        $posts = collect(Timber::get_posts($args))->map->transform;

        if ($posts->count() < $posts_per_page) {
            $response['done'] = true;
        }

        $response['posts'] = $posts->toArray();

        return new WP_REST_Response($response, 200);
    }
}
