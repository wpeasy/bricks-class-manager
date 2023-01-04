<?php

namespace WPG_BSC;

use WPG_BSC\REST\Controller\REST_Controller;

class Application
{
    private static $_instance = null;

    private $_REST_Controller;

    public static function get_instance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {

        add_action('admin_menu', [$this, 'add_submenu_page']);
        add_action('admin_enqueue_scripts', [$this, 'register_scripts'], 999);

        $this->_REST_Controller = new REST_Controller();

    }

    public function add_submenu_page()
    {
        if(current_user_can('manage_options')){
            add_submenu_page(
                'bricks',
                'Manage Global Classes',
                'WPG Manage Classes',
                'manage_options',
                WPG_BSC_SLUG . '-order-classes',
                [$this, 'print_page']
            );
        }

    }

    public function register_scripts()
    {
        wp_register_script('bsc', WPG_BSC_PLUGIN_URL . 'vue-app/dist/assets/index.js', [], false, true);
        wp_register_style('bsc', WPG_BSC_PLUGIN_URL . 'vue-app/dist/assets/index.css');
    }

    public function print_page($stats)
    {
        wp_enqueue_script('bsc');
        wp_enqueue_style('bsc');
        wp_localize_script(
                'bsc',
                'bsc',
            [
                'root'  => esc_url_raw( rest_url() ) . WPG_BSC_API_NAMESPACE . '/',
                'nonce' => wp_create_nonce( 'wp_rest' )
            ]
        );
        ?>
        <div class="wrap">
            <h2>WPGet Bricks Class Manager</h2>
            <div id="app"></div>
        <?php
    }
}