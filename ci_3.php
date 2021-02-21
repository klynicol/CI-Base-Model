<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Database_model extends CI_Model{

    public function __construct($database = null){
        parent::__construct();
        if($database !== null){
            $this->db = $this->load->database($database, true);
        }
    }


    /**
     * ---------- GENERIC CI DATA METHODS -----------
     * --------------- Mark Wickline ----------------
     * ------------------- V 1.3 --------------------
     */

    /**
     * Check if a row exists. Returns true of false.
     * 
     * @param string $table
     * @param array|object $where
     * @return bool
     */
    public function rowExists($table, $where){
        if($this->getRowWhere($table, $where))
            return true;
        return false;
    }


    /**
     * Updates a table and returns true or false.
     * 
     * @param string $table
     * @param array|object $where
     * @param array|object $data
     * @return bool
     */
    public function updWhere($table, $where, $data)
    {
        foreach($where as $key => $value){
            $this->db->where($key, $value);
        }
        $this->db->update($table, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * inserts data into any table and returns the insert id
     * 
     * @param string $table
     * @param array|object $data
     */
    public function ins($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /**
     * A general method for fetching data with a simple query.
     * 
     * @param string $table
     * @param array|object $where Key value pairs of WHERE clause items or keycol value
     * @param string $select Comma separated list of selects.
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getWhere($table, $where, $select = NULL, $limit = NULL, $offset = NULL, $single = false, $array = true){

        if($select)
            $this->db->select($select);

        $result = $this->db->get_where($table, $where, $limit, $offset);

        if($result && $result->num_rows()){
            if($single){
                if($array){
                    return $result->row_array();
                } else {
                    return $result->row();
                }
            } else{
                if($array){
                    return $result->result_array();
                } else {
                    return $result->result();
                }
            }
        }
        return false;
    }

    /**
     * A general method for fetching data with a simple query.
     * 
     * @param string $table
     * @param array|object $where Key value pairs of WHERE clause items or keycol value
     * @param string $select Comma separated list of selects.
     * @param int $limit
     * @param int $offset
     * @param bool $single
     * @return object
     */
    public function getWhereObject($table, $where, $select = NULL, $limit = NULL, $offset = NULL, $single = false){
        return $this->getWhere($table, $where, $select, $limit, $offset, $single, false);
    }

    /**
     * A general method for fetching A SINGLE ROW with a simple query.
     * 
     * @param string $table
     * @param array|object $where Key value pairs of WHERE clause items or keycol value
     * @param string $select Comma separated list of selects.
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getRowWhere($table, $where = NULL, $select = NULL, $limit = NULL, $offset = NULL){
        return $this->getWhere($table, $where, $select, $limit, $offset, true);
    }

    /**
     * A general method for fetching A SINGLE ROW with a simple query.
     * 
     * @param string $table
     * @param array|object $where Key value pairs of WHERE clause items or keycol value
     * @param string $select Comma separated list of selects.
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getRowWhereObject($table, $where = NULL, $select = NULL, $limit = NULL, $offset = NULL){
        return $this->getWhere($table, $where, $select, $limit, $offset, true, false);
    }

    /**
     * A general method for fetching A single value from a single row
     * 
     * @param string $table
     * @param array|object $where Key value pairs of WHERE clause items or keycol value
     * @param string $select Comma separated list of selects.
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getSingleValue($table, $where = NULL, $select = NULL, $limit = NULL, $offset = NULL){
        $row = $this->getWhere($table, $where, $select, $limit, $offset, true);
        if(!$row){
            return false;
        }
        return $row[$select];
    }


    /**
     * A catch-all delete method.
     * 
     * @param string $table
     * @param array|object $where
     * @return bool
     */
    public function delWhere($table, $where){
        $this->db->delete($table, $where);
        return $this->db->affected_rows();
    }

    /**
     * Run any general query
     */
    public function query($qry, $return = true){
        $qrs = $this->db->query($qry);
        if(!$return){
            return;
        }
        if($qrs && $qrs->num_rows()){
            return $qrs->result_array();
        }
        return false;
    }

    /**
     * Run any general query
     */
    public function queryOne($qry){
        $qrs = $this->db->query($qry);
        if($qrs && $qrs->num_rows()){
            return $qrs->row_array();
        }
        return false;
    }
    
}
