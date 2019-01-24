<?php

namespace App\Pages;

use App\WebRadio\WebRadio;
use MWW\Pages\Page;

class Home extends Page
{
    /** @var WebRadio $web_radio */
    protected $web_radio;

    /**
     * Home constructor.
     *
     * @param WebRadio $web_radio
     */
    public function __construct(WebRadio $web_radio)
    {
        parent::__construct();
        $this->web_radio = $web_radio;
    }

    /**
     * Home Page
     */
    public function index()
    {
        $webradio = $this->web_radio->generateScript();

        $this->template->include('header');
        $this->template->include('pages.home');
        $this->template->include('footer', [
            'webradio' => $webradio
        ]);
    }
}
