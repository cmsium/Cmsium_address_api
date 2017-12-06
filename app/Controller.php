<?php
class Controller {

    private static $instance;
    public static $user_id;

    public static function getInstance(){
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Basic address query methods

    /**
     * Initiates a query interface based on GET params given
     *
     * @return string JSON encoded result
     */
    public function searchAddress() {
//        Engine::OutHeader('respondJSON',['filename' => "address_query.json"]);
        header('Content-type: application/json;charset=utf-8');
        $validator = Validator::getInstance();
        $data = $validator->ValidateAllByMask($_GET,'addressQuery');
        if (!$data) {
            return json_encode([]);
        }
        if (isset($_GET['country']) && isset($_GET['type'])) {
            $query = new Query($_GET);
            return json_encode($query->searchByType(), JSON_UNESCAPED_UNICODE);
        } elseif (isset($_GET['country']) && isset($_GET['parent_object_name']) && isset($_GET['parent_type'])) {
            $query = new Query($_GET);
            return json_encode($query->searchByParent(), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode([]);
        }
    }

}