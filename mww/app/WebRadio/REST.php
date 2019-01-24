<?php

namespace App\WebRadio;

class REST {
    public function registerRoutes()
    {
        register_rest_route('lucas/v1', 'session', [
            [
                'methods'             => \WP_REST_Server::CREATABLE,
                'callback'            => [$this, 'set_session'],
                'permission_callback' => function() {
                    return true;
                },
                'args'                => [
                    'playlist' => [
                        'sanitize_callback' => 'sanitize_text_field',
                        'validate_callback' => function($playlist) {
                            return WebRadio::validatePlaylist($playlist);
                        }
                    ]
                ],
            ],
        ]);
    }

    /**
     * @param \WP_REST_Request $request
     */
    public function set_session(\WP_REST_Request $request)
    {
        if ($request['playlist'] == 'stop') {
            unset($_SESSION[WebRadio::SESSION_KEY]);
        } else {
            $_SESSION[WebRadio::SESSION_KEY] = $request['playlist'];
        }
    }
}