<?php

namespace WPG_BSC\REST\Controller;

use WPG_BSC\Class_Model;
use WPG_BSC\Parsers\Parser;

class REST_Controller
{

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_rest_routes']);
    }

    public function register_rest_routes()
    {
        register_rest_route(
            WPG_BSC_API_NAMESPACE,
            'test_get',
            [
                'methods' => 'GET',
                'callback' => [$this, 'REST_test_get'],
                'permission_callback' => [$this, 'permissions_check'],
            ]
        );

        register_rest_route(
            WPG_BSC_API_NAMESPACE,
            'delete_bricks_globals',
            [
                'methods' => 'GET',
                'callback' => [$this, 'REST_delete_bricks_globals'],
                'permission_callback' => [$this, 'permissions_check'],
            ]
        );

        register_rest_route(
            WPG_BSC_API_NAMESPACE,
            'get_class_list',
            [
                'methods' => 'GET',
                'callback' => [$this, 'REST_get_class_list'],
                'permission_callback' => [$this, 'permissions_check'],
            ]
        );

        register_rest_route(
            WPG_BSC_API_NAMESPACE,
            'parse_css_from_url',
            [
                'methods' => 'POST',
                'callback' => [$this, 'REST_parse_css_from_url'],
                'permission_callback' => [$this, 'permissions_check'],
            ]
        );

        register_rest_route(
            WPG_BSC_API_NAMESPACE,
            'update_class_list',
            [
                'methods' => 'POST',
                'callback' => [$this, 'REST_update_class_list'],
                'permission_callback' => [$this, 'permissions_check'],
            ]
        );

        register_rest_route(
            WPG_BSC_API_NAMESPACE,
            'add_to_imported_class_list',
            [
                'methods' => 'POST',
                'callback' => [$this, 'REST_add_to_imported_class_list'],
                'permission_callback' => [$this, 'permissions_check'],
            ]
        );

        register_rest_route(
            WPG_BSC_API_NAMESPACE,
            'get_imported_class_list',
            [
                'methods' => 'GET',
                'callback' => [$this, 'REST_get_imported_class_list'],
                'permission_callback' => [$this, 'permissions_check'],
            ]
        );

        register_rest_route(
            WPG_BSC_API_NAMESPACE,
            'delete_from_imported_class_list',
            [
                'methods' => 'POST',
                'callback' => [$this, 'REST_delete_from_imported_class_list'],
                'permission_callback' => [$this, 'permissions_check'],
            ]
        );

        register_rest_route(
            WPG_BSC_API_NAMESPACE,
            'update_status',
            [
                'methods' => 'POST',
                'callback' => [$this, 'REST_update_status'],
                'permission_callback' => [$this, 'permissions_check'],
            ]
        );

    }

    public function permissions_check($request)
    {
        if (WPG_BSC_DEBUG) {
            return true;
        }

        if (!current_user_can('manage_options')) {
            return new \WP_Error(403, __('Permission Denied'));
        } else {
            return true;
        }
    }


    public function REST_test_get()
    {
        return new \WP_REST_Response(
            [
                'status' => 200,
                'response' => __(__METHOD__),
                'body_response' => [
                    'WPG_BSC_CSS_UPLOAD_DIR' => WPG_BSC_CSS_UPLOAD_DIR,
                    'WPG_BSC_CSS_UPLOAD_URL' => WPG_BSC_CSS_UPLOAD_URL
                ]
            ]
        );
    }

    public function REST_get_class_list()
    {
        return new \WP_REST_Response(
            [
                'status' => 200,
                'response' => __(__METHOD__),
                'body_response' => Class_Model::get_bricks_global_class_list()
            ]
        );
    }

    public function REST_update_class_list(\WP_REST_Request $request)
    {
        $JSON_ok = $this->_REST_JSON_check($request);
        if (is_wp_error($JSON_ok))
            return $JSON_ok;

        Class_Model::update_bricks_global_class_list($json = $request->get_json_params());
        return new \WP_REST_Response(
            [
                'status' => 200,
                'response' => __(__METHOD__)
            ]
        );
    }

    public function REST_add_to_imported_class_list(\WP_REST_Request $request)
    {
        $json = $request->get_json_params();
        if (!is_array($json))
            return new \WP_Error(400, 'Error JSON must be an array');

        Class_Model::add_to_imported_class_list($json);
        return new \WP_REST_Response(
            [
                'status' => 200,
                'response' => __(__METHOD__)
            ]
        );

    }

    public function REST_get_imported_class_list(\WP_REST_Request $request)
    {
        return new \WP_REST_Response(
            [
                'status' => 200,
                'response' => __(__METHOD__),
                'body_response' => Class_Model::get_imported_class_list()
            ]
        );
    }


    public function REST_delete_from_imported_class_list(\WP_REST_Request $request)
    {
        $params = $request->get_json_params();
        if (!is_array($params))
            return new \WP_Error(400, 'Error JSON must be an array');

        if (!key_exists('set_name', $params))
            return new \WP_Error(400, 'Error Must gave a set_name');

        $result = Class_Model::delete_from_imported_class_list($params['set_name']);
        if($result === true){
            $status = 200;
            $message = __('Deleted from imported classes');
        }else{
            $status = 400;
            $message = $result;
        }

        return new \WP_REST_Response(
            [
                'status' => $status,
                'response' => $message
            ],
            $status
        );
    }

    public function REST_update_status(\WP_REST_Request $request)
    {

        $JSON_ok = $this->_REST_JSON_check($request);
        if (is_wp_error($JSON_ok))
            return $JSON_ok;

        $params = $request->get_json_params();

        if (!isset($params['set_name']))
            return new \WP_Error(400, 'set_name is not provided');

        if (!isset($params['status']))
            return new \WP_Error(400, 'status is not provided');

        Class_Model::update_status($params['set_name'], $params['status']);

        return new \WP_REST_Response(
            [
                'status' => 200,
                'response' => __(__METHOD__)
            ]
        );
    }


    public function REST_parse_css_from_url(\WP_REST_Request $request)
    {
        $JSON_ok = $this->_REST_JSON_check($request);
        if (is_wp_error($JSON_ok))
            return $JSON_ok;

        $params = $request->get_json_params();
        if (!isset($params['url']))
            return new \WP_Error(400, 'URL is not provided');

        if (empty($params['set_name']))
            return new \WP_Error(400, 'source_name is not provided');

        if (empty($params['comment']))
            return new \WP_Error(400, 'Comment is not provided');

        $set_name = $params['set_name'];

        /* Parse */
        $parser = new Parser($set_name);
        $valid = $parser->get_and_process_url($params['url']);
        if (is_wp_error($valid))
            return $valid;

        /*Store Locally */
        if(!file_exists(WPG_BSC_CSS_UPLOAD_DIR))
            mkdir(WPG_BSC_CSS_UPLOAD_DIR);

        $name = md5($params['url']) . '.css';
        file_put_contents(WPG_BSC_CSS_UPLOAD_DIR . $name, $parser->get_original_file());

        /* Return results */
        $data = [
            $set_name => [
                "original_src" => $params["url"],
                "local_src" => WPG_BSC_CSS_UPLOAD_URL . $name,
                "status" => [
                    "local" => false,
                    "enabled" => false,
                    "enqueue" => false
                ],
                "comment" => $params["comment"],
                "classes" => $parser->get_parsed_classes(),
                "vars" => $parser->get_parsed_variables()
            ]
        ];

        return new \WP_REST_Response(
            [
                'status' => 200,
                'response' => __(__METHOD__),
                'body_response' => $data
            ]
        );
    }

    public function REST_delete_bricks_globals()
    {
        return __METHOD__;
    }


    /* Private Utils */
    private function _REST_JSON_check(\WP_REST_Request $request, $check_value = null)
    {
        $json = $request->get_json_params();
        if (!is_array($json))
            return new \WP_Error('Request does not have JSON Array');

        if ($check_value && !isset($json[$check_value]))
            return new \WP_Error(400, $check_value . " is not provided in request");

        return true;
    }
}