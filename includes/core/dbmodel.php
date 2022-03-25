<?php
	 /**
     * Insert records
     * @access public
     * @param $data array associative array
     * @return mixed If succeed return inserted record id, else return false
     */
	function save($con,$tableName,$data){
		$field_list = '';  //field list string
        $value_list = '';  //value list string
        foreach ($data as $k => $v) {
        		$field_list .= "`".$k."`" . ',';
        		$value_list .= "'".$v."'" . ',';
        }

        // Trim the comma on the right
        $field_list = rtrim($field_list,',');
        $value_list = rtrim($value_list,',');
        // Construct sql statement
        $sql = "INSERT INTO `{$tableName}` ({$field_list}) VALUES ($value_list)";
        if ($con->query($sql)) {
            // Insert succeed, return the last record’s id
        	// return getInsertId($con);
            return true;
            //return true;
        } else {
            // Insert fail, return false
        	return false;
        }
	}

	/**
	* Update records
	* @access public
	* @param $data array associative array needs to be updated
	* @param $where string `tablefield`=value
	* @return mixed If succeed return the count of affected rows, else return false
	*/
	function update($con,$tableName,$data,$where){
        $uplist = ''; //update fields
        foreach ($data as $k => $v) {
        	$uplist .= "`$k`='$v'".",";
        }
        // Trim comma on the right of update list
        $uplist = rtrim($uplist,',');
        // Construct SQL statement
        $sql = "UPDATE `{$tableName}` SET {$uplist} WHERE {$where}";
        if ($con->query($sql)) {
            // If succeed, return the count of affected rows
        	if ($rows = mysqli_affected_rows($con)) {
                // Has count of affected rows  
        		return $rows;
        	} else {
                // No count of affected rows, hence no update operation
        		return false;
        	}    
        } else {
            // If fail, return false
        	return false;
        }
    }

    /**
     * Delete records
     * @access public
     * @param $pk could be an int
     * @return mixed If succeed, return the count of deleted records, if fail, return false
     */
    function delete($con,$tableName,$pk,$value){
        $where = "`{$pk}`='".$value."'";
        // Construct SQL statement
        $sql = "DELETE FROM `{$tableName}` WHERE $where";
        if ($con->query($sql)) {
            // If succeed, return the count of affected rows
        	if ($rows = mysqli_affected_rows($con)) {
                // Has count of affected rows
        		return $rows;
        	} else {
                // No count of affected rows, hence no delete operation
        		return false;
        	}        
        } else {
            // If fail, return false
        	return false;
        }
    }

	/**
	* Get info based on PK
	* @param $pk int Primary Key
	* @return array an array of single record
	*/
    function selectByPk($con,$tableName,$pk,$value){
        $sql = "select * from `{$tableName}` where `{$pk}`='".$value."'";
        return getRow($con,$sql);
    }

	/**
	* Get the count of all records
	*/
    function total($con,$tableName){
        $sql = "select count(*) from {$tableName}";
        return getOne($con,$sql);
    }

	/**
	* Get info of pagination
	* @param $offset int offset value
	* @param $limit int number of records of each fetch
	* @param $where string where condition,default is empty
	*/
    function pageRows($con,$tableName,$offset, $limit,$where = ''){
        if (empty($where)){
            $sql = "select * from {$tableName} limit $offset, $limit";
        } else {
            $sql = "select * from {$tableName}  where $where limit $offset, $limit";
        }
        return getAll($con,$sql);
    }

    /**
     * Get the first column of the first record
     * @access public
     * @param $sql string SQL query statement
     * @return return the value of this column
     */
    function getOne($con,$sql){
        $result = $con->query($sql);
        $row = mysqli_fetch_row($result);
        if ($row) {
            return $row[0];
        } else {
            return false;
        }
    }

	/**
	* Get one record
	* @access public
	* @param $sql SQL query statement
	* @return array associative array
	*/
    function getRow($con,$sql){
    	if ($result = $con->query($sql)) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return false;
        }
    }

	/**
	* Get all records
	* @access public
	* @param $sql SQL query statement
	* @return $list an 2D array containing all result records
	*/
    function getAll($con,$sql){
        $result = $con->query($sql);
        $list = array();
        while ($row = mysqli_fetch_assoc($result)){
            $list[] = $row;
        }
        return $list;
    }

    /**
     * Get the value of a column
     * @access public
     * @param $sql string SQL query statement
     * @return $list array an array of the value of this column
     */
    function getCol($con,$sql){
        $result = $con->query($sql);
        $list = array();
        while ($row = mysqli_fetch_row($result)) {
            $list[] = $row[0];
        }
        return $list;
    }

	/**
	* Get last insert id
	*/
    function getInsertId($con){
        return mysqli_insert_id($con);
    }

    /**
    *  @return random uniqe string 
    **/
    function getRandomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

?>