<?php

namespace App\WebRadio\Playlists;

interface PlaylistInterface {
    /**
     * Returns the playlist array
     *
     * @return array
     */
    public function get() : array;
}