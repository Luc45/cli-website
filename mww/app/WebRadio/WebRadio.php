<?php

namespace App\WebRadio;

use App\Exceptions\WebRadioException;
use App\WebRadio\Playlists\DefaultPlaylist;
use App\WebRadio\Playlists\MetalPlaylist;

class WebRadio {
    /** @var string This is the $_SESSION key that will store web radio information. */
    const SESSION_KEY = 'playlist';

    /** @var array */
    const VALID_PLAYLISTS = ['default', 'metal'];

    /** @var DefaultPlaylist $default_playlist */
    protected $default_playlist;

    /** @var MetalPlaylist $metal_playlist */
    protected $metal_playlist;

    /**
     * WebRadio constructor.
     *
     * @param DefaultPlaylist $default_playlist
     * @param MetalPlaylist   $metal_playlist
     */
    public function __construct(DefaultPlaylist $default_playlist, MetalPlaylist $metal_playlist)
    {
        $this->default_playlist = $default_playlist;
        $this->metal_playlist = $metal_playlist;
    }

    /**
     * Generate the HTML script tag for the Web Radio.
     *
     * @return string
     */
    public function generateScript() : string
    {
        // Do the visitor want a web radio?
        if ( ! $this->hasSelectedWebRadio()) {
            return '';
        }

        try {
            $protocol = is_ssl() ? 'https' : 'http';
            $string = '<script src="' . $protocol . '://scmplayer.co/script.js" data-config="' . $this->generateConfigString() . '"></script>';
            return $string;
        } catch(WebRadioException $e) {
            return '';
        }
    }

    /**
     * Determines whether a playlist is allowed or not.
     *
     * @param string $playlist
     *
     * @return bool
     */
    public static function validatePlaylist(string $playlist) : bool
    {
        return in_array($playlist, self::VALID_PLAYLISTS);
    }

    /**
     * Asserts visitor has selected a web radio of his preference.
     *
     * @return bool
     */
    public static function hasSelectedWebRadio() : bool
    {
        return ! empty($_SESSION[self::SESSION_KEY]);
    }

    /**
     * @throws WebRadioException
     */
    protected function generateConfigString() : string
    {
        $musics = $this->getMusicsFromPlaylist($_SESSION[self::SESSION_KEY]);
        $musics_string = $this->transformMusicArrayIntoString($musics);

        $string = "
            {
                'skin':'skins/black/skin.css',
                'volume':50,
                'autoplay':false,
                'shuffle':true,
                'repeat':1,
                'placement':'bottom',
                'showplaylist':false,
                'playlist': [" . $musics_string . "]
            }
        ";

        // Removes line breaks and multiple spaces.
        $string = preg_replace("/[\n\r]/","", $string);
        $string = preg_replace("/\s{2,}/","", $string);

        return $string;
    }

    /**
     * Returns an array of musics for given playlist.
     *
     * @param $playlist
     *
     * @throws WebRadioException
     */
    protected function getMusicsFromPlaylist($playlist) : array
    {
        switch ($playlist) {
            case 'default':
                return $this->default_playlist->get();
                break;
            case 'metal':
                return $this->metal_playlist->get();
                break;
            default:
                throw WebRadioException::unexpected_playlist_value($playlist);
        }
    }

    /**
     * Receives an array of musics, and returns a string of musics.
     *
     * @param array $musics
     *
     * @return string
     */
    protected function transformMusicArrayIntoString(array $musics) : string
    {
        $string = '';
        foreach ($musics as $artist => $url) {
            $string .= "{'title':'$artist', 'url':'$url'},";
        }
        // Removes the last comma.
        $string = rtrim($string, ',');
        return $string;
    }
}