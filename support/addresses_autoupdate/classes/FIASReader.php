<?php
class FIASReader {

    private static $name = 'RU';
    private static $table_name = 'address_ru';
    private static $fias_file_name = 'ADDROB';
    private static $allowed_ao_levels = [1,2,3,35,4,5,6,65,7];

    public static function update() {
        // Parse FIAS format
        self::importToTempTable();
        self::parseToAddresses();
    }

    public static function importToTempTable() {
        $fias_table_path = TMP_PATH.'/'.self::$name.'/'.self::$fias_file_name.'*.DBF';
        // Outer loop iterating files
        $conn = DBConnection::getInstance();
        $types = self::getTypes();
        // create temp table
        $query_temp_table = "CREATE TEMPORARY TABLE fias_temp(
      id int(11) NOT NULL AUTO_INCREMENT,
      name varchar(255) NOT NULL,
      code varchar(255) NOT NULL,
      full_code varchar(255) NOT NULL,
      obj_id int(11) NOT NULL DEFAULT -1,
      type_id int(11) NOT NULL, PRIMARY KEY (id)
    ) ENGINE=InnoDB;";
        $conn->performQuery($query_temp_table);
        $global_rows_number = 0;
        foreach (glob($fias_table_path) as $filename) {
            $file = new DBase($filename);
            $file->open();
            $rows_number = $file->rows;
            // insert into temp table
            for ($i = 1; $i <= $rows_number; $i++) {
                // Check if ao level is allowed
                $row = $file->getRow($i);
                if (!in_array($row[3], self::$allowed_ao_levels) && empty(trim($row[21]))) {
                    continue;
                }
                // Add row to table
                // Truncate whitespaces in the end
                $db_row['name'] = rtrim($row[11]);

                $code_array['region'] = (int)substr($row[21],0,2);
                $code_array['area'] = (int)substr($row[21],2,3);
                $code_array['city'] = (int)substr($row[21],5,3);
                $code_array['locality'] = (int)substr($row[21],8,3);
                $code_array['planning structure'] = (int)substr($row[21],11,4);
                $code_array['street'] = (int)substr($row[21],15,4);

                $code_db_array['region'] = substr($row[21],0,2);
                $code_db_array['area'] = substr($row[21],0,5);
                $code_db_array['city'] = substr($row[21],0,8);
                $code_db_array['locality'] = substr($row[21],0,11);
                $code_db_array['planning structure'] = substr($row[21],0,15);
                $code_db_array['street'] = substr($row[21],0,19);

                $reversed_code_array = array_reverse($code_array);
                foreach ($reversed_code_array as $type => $value) {
                    if ($value !== 0) {
                        $db_row['code'] = $code_db_array[$type];
                        $db_row['type_id'] = array_search($type, $types);
                        break;
                    }
                }

                $query_insert = "INSERT INTO fias_temp(name, code, full_code, type_id) VALUES('{$db_row['name']}', '{$db_row['code']}', '{$row[21]}', {$db_row['type_id']});";
                $conn->performQuery($query_insert);
                

                if (($i % 1000) == 0) {
                    echo($i), "/$rows_number added to temp table\r";
                }
            }
            // Summ all rows from files
            $global_rows_number = $global_rows_number + $rows_number;
        }
        echo "\n";
        self::parseToAddresses($global_rows_number);
    }

    public static function parseToAddresses($rows_number) {
        $conn = DBConnection::getInstance();
        $types = self::getTypes();
        for ($i = 1; $i <= $rows_number; $i++) {
            $query_get = "CALL getRowFromFIASTemp($i);";
            $result = $conn->performQueryFetch($query_get);
            $code_array['region'] = (int)substr($result['full_code'],0,2);
            $code_array['area'] = (int)substr($result['full_code'],2,3);
            $code_array['city'] = (int)substr($result['full_code'],5,3);
            $code_array['locality'] = (int)substr($result['full_code'],8,3);
            $code_array['planning structure'] = (int)substr($result['full_code'],11,4);
            $code_array['street'] = (int)substr($result['full_code'],15,4);

            $code_db_array['region'] = substr($result['full_code'],0,2);
            $code_db_array['area'] = substr($result['full_code'],0,5);
            $code_db_array['city'] = substr($result['full_code'],0,8);
            $code_db_array['locality'] = substr($result['full_code'],0,11);
            $code_db_array['planning structure'] = substr($result['full_code'],0,15);
            $code_db_array['street'] = substr($result['full_code'],0,19);

            $result_array = [];
            foreach ($code_array as $type => $value) {
                if ($value !== 0) {
                    $type_id = array_search($type, $types);
                    $query_name = "CALL getNameFromFIASTempByCode('{$code_db_array[$type]}', $type_id);";
                    $result_chain = $conn->performQueryFetch($query_name);
                    $result_array[$type] = $result_chain['name'];
                }
            }
            self::saveAddressObject($result_array, $types);

            if (($i % 100) == 0) {
                echo($i), "/$rows_number added to address object\r";
            }
        }
        echo "\n";
    }

    private static function getTypes() {
        $conn = DBConnection::getInstance();
        $query = "CALL getAddressTypes();";
        $result = $conn->performQueryFetchAll($query);
        $result_array = [];
        foreach ($result as $row) {
            $result_array[$row['id']] = $row['name'];
        }
        return $result_array;
    }

    private static function saveAddressObject($data, $types) {
        $conn = DBConnection::getInstance();
        $last_item_id = -1;
        foreach ($data as $type_name => $object_name) {
            $type_id = array_search($type_name, $types);
            $check_query = "CALL checkAddressRUObject('$object_name',$last_item_id,$type_id);";
            $result_check = $conn->performQueryFetch($check_query);
            if ($result_check) {
                $last_item_id = $result_check['id'];
            } else {
                $query = "CALL writeAddressRUObject('$object_name',$last_item_id,$type_id);";
                $result = $conn->performQueryFetch($query);
                $last_item_id = $result['id'];
            }
        }
        return $last_item_id;
    }

}