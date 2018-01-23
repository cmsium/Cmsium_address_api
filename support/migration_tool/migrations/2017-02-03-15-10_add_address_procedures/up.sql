CREATE PROCEDURE writeAddressObject(tableName VARCHAR(255), IN addressName VARCHAR(45),IN idParent INT, IN idType INT)
  BEGIN
    SET @sql = CONCAT('INSERT INTO ',
                      tableName,
                      '(name, parent_id, type_id) VALUES ("',
                      addressName,
                      '",',
                      idParent,
                      ',',
                      idType,
                      ');');
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    SELECT last_insert_id() as id;
  END;
CREATE PROCEDURE getAddressTypes()
  BEGIN
    SELECT * FROM address_types;
  END;
CREATE PROCEDURE checkAddressObjectPresence(tableName VARCHAR(255),objectName VARCHAR(45), idParent INT, idType INT)
  BEGIN
    SET @sql = CONCAT('SELECT id FROM ',
                      tableName,
                      ' WHERE name = "',
                      objectName,
                      '" AND parent_id = ',
                      idParent,
                      ' AND type_id = ',
                      idType,
                      ';');
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
  END;
CREATE PROCEDURE getAllCountries()
  BEGIN
    SELECT * FROM address_countries;
  END;
CREATE PROCEDURE getCountryByISO(countryISO INT)
  BEGIN
    SELECT * FROM address_countries WHERE iso = countryISO;
  END;
CREATE PROCEDURE checkAddressTablePresence(tableName VARCHAR(255))
  BEGIN
    SELECT table_name FROM information_schema.tables WHERE table_name = tableName;
  END;
CREATE PROCEDURE createTempTableKLADR()
  BEGIN
    DROP TEMPORARY TABLE IF EXISTS kladr_temp;
    CREATE TEMPORARY TABLE kladr_temp(
      id int(11) NOT NULL AUTO_INCREMENT,
      name varchar(255) NOT NULL,
      code varchar(255) NOT NULL,
      full_code varchar(255) NOT NULL,
      obj_id int(11) NOT NULL DEFAULT -1,
      type_id int(11) NOT NULL, PRIMARY KEY (id)
    ) ENGINE=InnoDB;
  END;
CREATE PROCEDURE getRowFromKLADRTemp(idRow INT(11))
  BEGIN
    SELECT * FROM kladr_temp WHERE id = idRow;
  END;
CREATE PROCEDURE getNameFromKLADRTempByCode(codeVal VARCHAR(255), idType INT(11))
  BEGIN
    SELECT name FROM kladr_temp WHERE code = codeVal AND type_id = idType;
  END;
CREATE PROCEDURE writeAddressRUObject(IN addressName VARCHAR(45),IN idParent INT, IN idType INT)
  BEGIN
    INSERT INTO address_ru(name, parent_id, type_id) VALUES (addressName,idParent,idType);
    SELECT last_insert_id() as id;
  END;
CREATE PROCEDURE checkAddressRUObject(IN addressName VARCHAR(45),IN idParent INT, IN idType INT)
  BEGIN
    SELECT id FROM address_ru WHERE name = addressName AND parent_id = idParent AND type_id = idType;
  END;
CREATE PROCEDURE addObjectIDToKLADRTemp(IN idObj INT(11),IN idKLADRRow INT(11))
  BEGIN
    UPDATE kladr_temp SET obj_id = idObj WHERE id = idKLADRRow;
  END;
CREATE PROCEDURE getObjIDFromKLADRTempByCode(codeVal VARCHAR(255), idType INT(11))
  BEGIN
    SELECT obj_id FROM kladr_temp WHERE code = codeVal AND type_id = idType;
  END;
CREATE PROCEDURE createTempTableStreetsKLADR()
  BEGIN
    DROP TEMPORARY TABLE IF EXISTS kladr_street_temp;
    CREATE TEMPORARY TABLE kladr_street_temp(
      id int(11) NOT NULL AUTO_INCREMENT,
      name varchar(255) NOT NULL,
      code varchar(255) NOT NULL,
      full_code varchar(255) NOT NULL,
      type_id int(11) NOT NULL, PRIMARY KEY (id)
    ) ENGINE=InnoDB;
  END;
CREATE PROCEDURE getRowFromStreetsKLADRTemp(idRow INT(11))
  BEGIN
    SELECT * FROM kladr_street_temp WHERE id = idRow;
  END;

CREATE PROCEDURE getRowFromFIASTemp(idRow INT(11))
  BEGIN
    SELECT * FROM fias_temp WHERE id = idRow;
  END;
CREATE PROCEDURE getNameFromFIASTempByCode(codeVal VARCHAR(255), idType INT(11))
  BEGIN
    SELECT name FROM fias_temp WHERE code = codeVal AND type_id = idType;
  END;


CREATE  PROCEDURE searchByTypeWithName(IN table_name VARCHAR(40), IN in_params VARCHAR(40), IN search_str VARCHAR(255), IN limit_str VARCHAR(32), IN offset_str VARCHAR(32))
  BEGIN
    SET @t1 =CONCAT('SELECT ',table_name,'.id, ',table_name,'.name, address_types.name AS type FROM ',table_name,' LEFT JOIN address_types ON ',table_name,'.type_id = address_types.id WHERE ',table_name,'.type_id IN (',in_params,') AND ',table_name,'.name LIKE "%',search_str,'%" LIMIT ',limit_str,' OFFSET ',offset_str);
    PREPARE stmt3 FROM @t1;
    EXECUTE stmt3;
    DEALLOCATE PREPARE stmt3;
  END;

CREATE  PROCEDURE searchByType(IN table_name VARCHAR(40), IN in_params VARCHAR(40), IN limit_str VARCHAR(32), IN offset_str VARCHAR(32))
  BEGIN
    SET @t1 =CONCAT('SELECT ',table_name,'.id, ',table_name,'.name, address_types.name AS type FROM ',table_name,' LEFT JOIN address_types ON ',table_name,'.type_id = address_types.id WHERE ',table_name,'.type_id IN (',in_params,') LIMIT ',limit_str,' OFFSET ',offset_str);
    PREPARE stmt3 FROM @t1;
    EXECUTE stmt3;
    DEALLOCATE PREPARE stmt3;
  END;


CREATE  PROCEDURE searchByParentBoth(IN table_name VARCHAR(40), IN parent_id VARCHAR(40), IN in_params VARCHAR(40), IN search_str VARCHAR(255), IN limit_str VARCHAR(32), IN offset_str VARCHAR(32))
  BEGIN
    SET @t1 =CONCAT('SELECT ',table_name,'.id, ',table_name,'.name, address_types.name AS type FROM ',table_name,'LEFT JOIN address_types ON ',table_name,'.type_id = address_types.id WHERE parent_id = ',parent_id,' AND ',table_name,'.type_id IN (',in_params,') AND ',table_name,'.name LIKE "%',search_str,'%" LIMIT ',limit_str,' OFFSET ',offset_str);
    PREPARE stmt3 FROM @t1;
    EXECUTE stmt3;
    DEALLOCATE PREPARE stmt3;
  END;

CREATE  PROCEDURE searchByParentWithName(IN table_name VARCHAR(40), IN parent_id VARCHAR(40), IN search_str VARCHAR(255), IN limit_str VARCHAR(32), IN offset_str VARCHAR(32))
  BEGIN
    SET @t1 =CONCAT('SELECT ',table_name,'.id, ',table_name,'.name, address_types.name AS type FROM ',table_name,'LEFT JOIN address_types ON ',table_name,'.type_id = address_types.id WHERE parent_id = ',parent_id,' AND ',table_name,'.name LIKE "%',search_str,'%" LIMIT ',limit_str,' OFFSET ',offset_str);
    PREPARE stmt3 FROM @t1;
    EXECUTE stmt3;
    DEALLOCATE PREPARE stmt3;
  END;

CREATE  PROCEDURE searchByParentWithChildType(IN table_name VARCHAR(40), IN parent_id VARCHAR(40), IN in_params VARCHAR(40), IN limit_str VARCHAR(32), IN offset_str VARCHAR(32))
  BEGIN
    SET @t1 =CONCAT('SELECT ',table_name,'.id, ',table_name,'.name, address_types.name AS type FROM ',table_name,'LEFT JOIN address_types ON ',table_name,'.type_id = address_types.id WHERE parent_id = ',parent_id,' AND ',table_name,'.type_id IN (',in_params,') LIMIT ',limit_str,' OFFSET ',offset_str);
    PREPARE stmt3 FROM @t1;
    EXECUTE stmt3;
    DEALLOCATE PREPARE stmt3;
  END;

CREATE  PROCEDURE searchByParent(IN table_name VARCHAR(40), IN parent_id VARCHAR(40), IN limit_str VARCHAR(32), IN offset_str VARCHAR(32))
  BEGIN
    SET @t1 =CONCAT('SELECT ',table_name,'.id, ',table_name,'.name, address_types.name AS type FROM ',table_name,'LEFT JOIN address_types ON ',table_name,'.type_id = address_types.id WHERE parent_id = ',parent_id,' LIMIT ',limit_str,' OFFSET ',offset_str);
    PREPARE stmt3 FROM @t1;
    EXECUTE stmt3;
    DEALLOCATE PREPARE stmt3;
  END;