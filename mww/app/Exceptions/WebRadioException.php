<?php

namespace App\Exceptions;

class WebRadioException extends \Exception {
    /**
     * Throws when desired playlist is not found or not supported.
     *
     * @param $playlist
     *
     * @return WebRadioException
     */
    public static function unexpected_playlist_value($playlist)
    {
        return new self(__('Unexpected playlist value', 'lucas-cli'));
    }
}