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
        header('Content-type: application/json;charset=utf-8');
        header('Access-Control-Allow-Origin: *');
//        var_dump(self::convert(memory_get_usage(true)));
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

    public function saveAddress() {
        // TODO: Validation?
        header('Content-type: application/json;charset=utf-8');
        $data = $_POST;
        $address_obj = new Address($data);
        if ($last_item_id = $address_obj->save()) {
            return json_encode(['status' => 'ok', 'last_id' => $last_item_id],JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(['status' => 'error', 'message' => DATA_FORMAT_ERROR['text']],JSON_UNESCAPED_UNICODE);
        }
    }

    public function readAddress() {
        header('Content-type: application/json;charset=utf-8');
        $validator = Validator::getInstance();
        $data = $validator->ValidateAllByMask($_GET,'readAddress');
        if (!$data) {
            return json_encode(['status' => 'error', 'message' => DATA_FORMAT_ERROR['text']],JSON_UNESCAPED_UNICODE);
        }
        $address_obj = new Address();
        $concat = $data['concat'] === 'true' ? true : false;
        $address_item = $address_obj->read((int)$data['country_iso'], (int)$data['object_id'], $concat);
        return json_encode($address_item,JSON_UNESCAPED_UNICODE);
    }

}