<?php

namespace Towa\Theme\Controller;

use WP_Error;
use Timber\Timber;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;

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
                'args' => [],
            ],
        ]);
    }

    /**
     * get terms by taxonomy
     *
     * @param WP_REST_Request $request
     * @return WP_Error|WP_REST_Response
     */
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
        ]))->map(function ($term) {
            return [
                'id' => $term->ID,
                'name' => $term->name,
                'active' => false,
            ];
        })->prepend([
            'id' => '*',
            'name' => __('Alle ', 'towa') . get_post_type_object($cpt)->label,
            'active' => true,
        ])->toArray();

        return new WP_REST_Response($response, 200);
    }
}
