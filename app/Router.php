<?php
class Router {

    private static $instance;
    private $routes;
    private $uri;

    public static function getInstance(){
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Router constructor
     */
    public function __construct() {
        $this->parseRoutesMap();
    }

    /**
     * Parses routes map to property
     */
    private function parseRoutesMap() {
        include_once ROOTDIR.'/config/routes_map.php';
        $this->routes = $routes;
    }

    /**
     * Executes an action mapped to a specific URI
     *
     * @param $uri string Requested URI
     */
    public function executeAction($uri) {
        $parsed_uri = parse_url($uri);
        $this->uri = $parsed_uri['path'];
        if (array_key_exists($parsed_uri['path'], $this->routes)) {
            $action = $this->routes[$parsed_uri['path']];
            $method = $action[0];
            if (isset($action[1]) && $action[1] === 'auth') {
                if (!$this->checkAuth()) {
                    echo AUTH_ERROR['text'];
                    exit;
                }
            }
        } else {
            readfile(ROOTDIR.'/app/views/404.html');
            exit;
        }
        $controller = Controller::getInstance();
        echo $controller->$method();
    }

    private function checkAuth() {
        if (!isset($_COOKIE['token'])) {
            return false;
        } else {
            $auth = Config::get('auth_domain');
            $request = new Request("$auth/token/check");
            $authcheck = $request->sendRequestJSON('POST',
                'Content-type: application/x-www-form-urlencoded',
                http_build_query(['token'=>$_COOKIE['token']]));
            if ($authcheck['is_valid'] == true) {
                if (!$this->checkPermissions()) {
                    return false;
                }
                Controller::$user_id = Cookie::getUserId();
                return true;
            } else {
                return false;
            }
        }
    }

    private function checkPermissions() {
        $auth = Config::get('auth_domain');
        $request = new Request("$auth/permissions/check");
        $http_query = http_build_query(['token'=>$_COOKIE['token'], 'action' => $this->uri, 'service_name' => 'cmsium_address']);
        $authcheck = $request->sendRequestJSON('POST',
            'Content-type: application/x-www-form-urlencoded',
            $http_query);
        if ($authcheck['status'] === 'ok') {
            return true;
        } else {
            return false;
        }
    }

}