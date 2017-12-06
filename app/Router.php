<?php
class Router {

    private static $instance;
    private $routes;

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
        if (array_key_exists($parsed_uri['path'], $this->routes)) {
            $action = $this->routes[$parsed_uri['path']];
            $method = $action[0];
//            if (isset($action['auth'])) {
//                if (!$this->checkAuth()) {
//                    echo AUTH_ERROR['text'];
//                    exit;
//                }
//            }
        } else {
            readfile(ROOTDIR.'/app/views/404.html');
            exit;
        }
        $controller = Controller::getInstance();
        echo $controller->$method();
    }

//    private function checkAuth($roles) {
//        if (Cookie::checkToken()) {
//            $token_raw = $_COOKIE['token'];
//            $auth = UserAuth::getInstance();
//            if (!$user_id = $auth->check($token_raw)) {
//                return false;
//            }
//            if ($roles != [0]) {
//                if (!$auth->checkSelfRoles($roles, $user_id)) {
//                    return false;
//                }
//            }
//            Controller::$user_id = $user_id;
//            return true;
//        } else {
//            return false;
//        }
//    }

    private function checkAuth() {
        if (!isset($_COOKIE['token'])) {
            return false;
        } else {
            $auth = Config::get('auth_domain');
            $request = new Request("http://$auth/token/check");
            $authcheck = $request->sendRequestJSON('POST',
                'Content-type: application/x-www-form-urlencoded',
                http_build_query(['token'=>$_COOKIE['token']]));
            switch ($authcheck['is_valid']){
                case true: Controller::$user_id = Cookie::getUserId(); return true; break;
                case false: return false; break;
            }
        }
    }

}