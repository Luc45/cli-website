<?php

namespace App;

use App\WebRadio\REST;
use App\WebRadio\WebRadio;
use MWW\Support\Setup;
use MWW\Routing\Router;

class Bootstrap
{
    /** @var Router $router */
    protected $router;

    /** @var Setup $setup */
    protected $setup;

    /** @var REST $web_radio_rest */
    protected $web_radio_rest;

    /**
     * Bootstrap constructor.
     *
     * @param Router $router
     * @param Setup  $setup
     */
    public function __construct(Router $router, Setup $setup, REST $web_radio_rest)
    {
        $this->router = $router;
        $this->setup = $setup;
        $this->web_radio_rest = $web_radio_rest;
    }

    /**
     * Bootstraps the website
     * Sets it up and handle the request
     */
    public function run()
    {
        $this->setUp();
        $this->router->routeRequest();
    }

    /**
     * Initial Setup
     */
    private function setUp()
    {
        /** Includes app/Support/helpers.php file */
        $this->setup->includeAppHelpers();

        /** Enqueues Assets */
        $this->setup->loadAppAssets();

        /** Registers Shortcodes */
        $this->setup->registerShortcodes();

        /** Registers "theme supports" functions */
        $this->setup->themeSupports(['post-thumbnails']);

        /** Disable WordPress emojis loading (Optional - Uncomment to use) */
        $this->setup->removeEmojis();

        // Listens for WebRadio REST
        add_action('rest_api_init', [$this->web_radio_rest, 'registerRoutes']);

        // We'll be using sessions
        session_start();

        /** Registers a Main Menu (Optional - Uncomment to use) */
        //register_nav_menu('main-menu', __('Main Menu'));

        /** Register image sizes suitable for Bootstrap (Optional - Uncomment to use) */
        //$setup->registerBootstrapImageSizes();
    }
}
