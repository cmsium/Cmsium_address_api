<?php
class Query {

    private $country_iso;
    private $parent_object_name;
    private $parent_type;
    private $search_str = '';
    private $type = '';
    private $limit = 100;
    private $offset = 0;
    private $full_chain = '0';
    private $with_id = '0';
    private $child_type = '';

    public function __construct($params) {
        $this->country_iso = $params['country'];
        if (isset($params['type'])) $this->type = $params['type'];
        if (isset($params['parent_object_name'])) $this->parent_object_name = $params['parent_object_name'];
        if (isset($params['parent_type'])) $this->parent_type = $params['parent_type'];
        if (isset($params['search'])) $this->search_str = $params['search'];
        if (isset($params['limit'])) $this->limit = $params['limit'];
        if (isset($params['offset'])) $this->offset = $params['offset'];
        if (isset($params['full_chain'])) $this->full_chain = $params['full_chain'];
        if (isset($params['with_id'])) $this->with_id = $params['with_id'];
        if (isset($params['child_type'])) $this->child_type = $params['child_type'];
    }

    /**
     * Searches an address chain in DB by it's type
     *
     * @return array|bool Address chains
     */
    public function searchByType() {
        $table_name = $this->getCountryTableName($this->country_iso)['table_name'];
        if (!$table_name) return false;
        $limit = $this->limit;
        $offset = $this->offset;
        $type = explode(',', $this->type);
        $types = $this->getTypes();
        $type_ids = [];
        foreach ($type as $key=>$value) {
            $type_id = array_search($value, $types);
            if (!$type_id) {
                return [];
            }
            $type_ids[] = $type_id;
        }
        $conn = DBConnection::getInstance();
//        $query_str = "SELECT $table_name.id, $table_name.name, address_types.name AS type FROM $table_name
//                      LEFT JOIN address_types ON $table_name.type_id = address_types.id
//                      WHERE $table_name.type_id IN (".implode(',',$type_ids).")";
        if ($this->search_str) {
            $search_str = $this->search_str;
//            $query_str .= " AND $table_name.name LIKE '%$search_str%'";
            $query_str = "CALL searchByTypeWithName('$table_name', '".implode(',',$type_ids)."','$search_str','$limit','$offset');";
            var_dump($query_str);
        } else {
            $query_str = "CALL searchByType('$table_name', '".implode(',',$type_ids)."','$limit','$offset');";
        }
//        $query_str .= " LIMIT $limit OFFSET $offset;";
        $result = $conn->performQueryFetchAll($query_str);
        if ($this->full_chain === '1' && !empty($result)) {
            foreach ($result as &$item) {
                $address_obj = new Address();
                $address_item = $address_obj->read($this->country_iso, $item['id']);
                if ($this->with_id === '1') {
                    $item = array_merge(['id' => $item['id']], $address_item);
                } else {
                    $item = $address_item;
                }
            }
            unset($item);
        }
        return $result ? $result : [];
    }

    /**
     * Search all address objects with current parent
     *
     * @return array|bool Address chains
     */
    public function searchByParent() {
        $table_name = $this->getCountryTableName($this->country_iso)['table_name'];
        if (!$table_name) return false;
        $limit = $this->limit;
        $offset = $this->offset;
        $object = $this->getObject($table_name, $this->parent_object_name, $this->parent_type);
        if (!$object) {
            return false;
        }
        $conn = DBConnection::getInstance();
//        $query_str = "SELECT $table_name.id, $table_name.name, address_types.name AS type FROM $table_name
//                      LEFT JOIN address_types ON $table_name.type_id = address_types.id
//                      WHERE parent_id = {$object['id']}";
        if ($this->child_type && $this->search_str) {
            $type = explode(',', $this->child_type);
            $types = $this->getTypes();
            $type_ids = [];
            foreach ($type as $key=>$value) {
                $type_id = array_search($value, $types);
                if (!$type_id) {
                    return [];
                }
                $type_ids[] = $type_id;
            }
            $search_str = $this->search_str;
            $query_str = "CALL searchByParentBoth('$table_name','{$object['id']}','".implode(',',$type_ids)."','$search_str','$limit','$offset');";
        } else if ($this->child_type) {
            $type = explode(',', $this->child_type);
            $types = $this->getTypes();
            $type_ids = [];
            foreach ($type as $key=>$value) {
                $type_id = array_search($value, $types);
                if (!$type_id) {
                    return [];
                }
                $type_ids[] = $type_id;
            }
            $query_str = "CALL searchByParentWithChildType('$table_name','{$object['id']}','".implode(',',$type_ids)."','$limit','$offset');";
        } else if ($this->search_str) {
            $search_str = $this->search_str;
            $query_str = "CALL searchByParentWithName('$table_name','{$object['id']}','$search_str','$limit','$offset');";
        } else {
            $query_str = "CALL searchByParent('$table_name','{$object['id']}','$limit','$offset');";
        }
//        $query_str .= " LIMIT $limit OFFSET $offset;";
        $result = $conn->performQueryFetchAll($query_str);
        if ($this->full_chain === '1' && !empty($result)) {
            foreach ($result as &$item) {
                $address_obj = new Address();
                $address_item = $address_obj->read($this->country_iso, $item['id']);
                if ($this->with_id === '1') {
                    $item = array_merge(['id' => $item['id']], $address_item);
                } else {
                    $item = $address_item;
                }
            }
            unset($item);
        }
        return $result ? $result : [];
    }

    /**
     * Gets an address object with given name and type
     *
     * @param $table_name string Name of the address table
     * @param $name string Name of the address object
     * @param $type string Address type name
     * @return bool Result
     */
    private function getObject($table_name, $name, $type) {
        $type = explode(',', $type);
        $types = $this->getTypes();
        $type_ids = [];
        foreach ($type as $key=>$value) {
            $type_id = array_search($value, $types);
            if (!$type_id) {
                return false;
            }
            $type_ids[] = $type_id;
        }
        $conn = DBConnection::getInstance();
        $query = "SELECT * FROM $table_name WHERE name = '$name' AND type_id IN (".implode(',',$type_ids).");";
        $result = $conn->performQueryFetch($query);
        return $result;
    }

    /**
     * Gets all the address object types from the DB
     *
     * @return array Array of address types: ['type_id' => 'type_name', ... ]
     */
    private function getTypes() {
        $conn = DBConnection::getInstance();
        $query = "CALL getAddressTypes();";
        $result = $conn->performQueryFetchAll($query);
        $result_array = [];
        foreach ($result as $row) {
            $result_array[$row['id']] = $row['name'];
        }
        return $result_array;
    }

    /**
     * Gets table name of country by iso code. Creates country table if needed.
     *
     * @param $country_iso string|int Country ISO code
     * @return array Table name and name of the country
     */
    private function getCountryTableName($country_iso) {
        $conn = DBConnection::getInstance();
        $query = "CALL getCountryByISO($country_iso);";
        $result = $conn->performQueryFetch($query);
        if (!$result)
            ErrorHandler::throwException(COUNTRY_NOT_FOUND, 'page');
        $table_name_check = 'address_'.strtolower($result['alpha2']);
        $query = "CALL checkAddressTablePresence('$table_name_check')";
        $result_table = $conn->performQueryFetch($query);
        if ($result_table) {
            return ['table_name' => $result_table['table_name'], 'name' => $result['t_name']];
        } else {
            return false;
        }
    }

}