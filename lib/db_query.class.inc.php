<?php
/**
 * db_query is the class that provide MySQL support.
 *
 * @author Cyril Glapa
 * @version 0.1
 */
class db_query {
    static private $_last_connection = NULL;
    private $_connection = NULL;
    private $_type = NULL;
    private $_table = NULL;
    private $_fields = array();
    private $_values = array();
    private $_as = array();
    private $_join = array();
    private $_where = NULL;
    private $_limit = NULL;
    private $_sql = NULL;
    private $_query = NULL;
    private $_affected_rows = NULL;
    private $_insert_id = NULL;
    private $_result = NULL;

    public function  __construct($connection=NULL) {
        if(is_null($connection)) {
            $this->_connection = (is_null(self::$_last_connection)) ? self::connect() : self::$_last_connection;
        }
        else
            $this->_connection = $connection;
    }

    private function _genSql() {
        if(is_null($this->_sql)) {
            switch($this->_type) {
                case 'select':
                    $this->_sql = 'SELECT';
                    foreach($this->_as as $field=>$shortcut) {
                        foreach($this->_fields as $id=>$selected_field) {
                            if($field == $selected_field) {
                                $this->_fields[$id] .= ' AS \''.$shortcut.'\'';
                                break;
                            }
                        }
                    }
                    $this->_sql .= (count($this->_fields) == 0) ? '  *' : ' '.implode(',', $this->_fields);
                    $this->_sql .= ' FROM '.$this->_table;
                    foreach($this->_join as $table=>$condition)
                            $this->_sql .= ' JOIN '.$table.' ON '.$condition;
                    if(!is_null($this->_where))
                            $this->_sql .= ' WHERE '.$this->_where;
                    if(!is_null($this->_limit))
                            $this->_sql .= ' LIMIT '.$this->_limit;
                    $this->_sql .= ';';
                    break;
                case 'insert':
                    $this->_sql  = 'INSERT INTO '.$this->_table;
                    $this->_sql .= ' (`'.implode('`,`',$this->_fields).'`)';
                    $this->_sql .= ' VALUES ';
                    $this->_sql .= '("'.implode('","',$this->_values).'")';
                    $this->_sql .= ';';
                    break;
            }
        }
        return $this;
    }

    private function _doQuery() {
        if(is_null($this->_query)) {
            if(is_null($this->_sql))
                    $this->_genSql();
            $this->_query = mysql_query($this->getSql(), $this->_connection);
            $this->_affected_rows = mysql_affected_rows($this->_connection);
            if($this->_type == 'insert')
                    $this->_insert_id = mysql_insert_id ($this->_connection);
        }
        return $this;
    }

    static public function connect($host=MYSQL_DEFAULT_HOST, $user=MYSQL_DEFAULT_USER, $password=MYSQL_DEFAULT_PASSWORD, $db=MYSQL_DEFAULT_DB) {
        $connection = mysql_connect($host,$user,$password);
        mysql_select_db($db, $connection);
        self::$_last_connection = $connection;
        return $connection;
    }

    static public function close($connection=NULL) {
        if(is_null($connection)) {
            mysql_close(self::$_last_connection);
            self::$_last_connection = NULL;
        }
        else {
            if($connection == self::$_last_connection)
                self::$_last_connection = NULL;
            mysql_close($connection);
        }
        return;
    }

    public function select($table) {
        if(is_null($this->_type)) {
            $this->_type = 'select';
            $this->_table = $table;
        }
        return $this;
    }

    public function addField($field,$as=NULL) {
        if(is_array($field)) {
            foreach($field as $value)
                $this->_fields[] = $value;
            if(!is_null($as))
                foreach($as as $field=>$shortcut)
                    $this->_as[$field] = $shortcut;
        }
        else {
            $this->_fields[] = $field;
            if(!is_null($as))
                $this->_as[$field] = $as;
        }
        return $this;
    }

    public function join($table,$condition) {
        if(!is_array($table))
            $table = array($table);
        if(!is_array($condition))
            $condition = array($condition);
        $count_table = count($table);
        if($count_table==count($condition))
            for($i=0;$i<$count_table;$i++)
                $this->_join[$table[$i]] = $condition[$i];
        return $this;
    }

    public function where($where,$values) {
        if(is_null($this->_where)) {
            $where = explode('?', $where);
            if(!is_array($values))
                $values = array($values);
            $values_count = count($values);
            if(count($where)-1 != $values_count)
                return $this;
            for($i=0;$i<$values_count;$i++) {
                $this->_where .= $where[$i].'"'.mysql_real_escape_string($values[$i], $this->_connection).'"';
            }
            $this->_where .= $where[$values_count];
        }
        return $this;
    }

    public function limit($limit) {
        if(is_null($this->_limit)) {
            $this->_limit = $limit;
        }
        return $this;
    }


    public function insert($table) {
        if(is_null($this->_type)) {
            $this->_type = 'insert';
            $this->_table = $table;
        }
        return $this;
    }

    public function values($fields,$value=NULL) {
        if($this->_type == 'insert') {
            if(!is_array($fields))
                $fields = array($fields=>$value);
            elseif(!is_null($value))
                $fields = array_combine($fields,$value);
            foreach($fields as $field=>$value) {
                $this->_fields[] = $field;
                $this->_values[] = mysql_real_escape_string($value, $this->_connection);
            }
        }
        return $this;
    }

    public function getSql() {
        if(is_null($this->_sql))
                $this->_genSql();
        return $this->_sql;
    }

    public function getAffectedRows() {
        if(is_null($this->_affected_rows))
                $this->_doQuery();
        return $this->_affected_rows;
    }

    public function getInsertId() {
        if($this->_type == 'insert') {
            if(is_null($this->_insert_id))
                    $this->_doQuery();
            return $this->_insert_id;
        }
        else
            return;
    }

    public function getResult() {
        if($this->_type == 'select') {
            if(is_null($this->_result)) {
                if(is_null($this->_query))
                        $this->_doQuery();
                switch($this->getAffectedRows()) {
                    case '0':
                        $this->_result = false;
                        break;
                    case '1':
                        $this->_result = mysql_fetch_assoc($this->_query);
                        break;
                    default:
                        $this->_result = array();
                        while($result = mysql_fetch_assoc($this->_query)) {
                            $this->_result[] = $result;
                        }
                        break;
                }
            }
            return $this->_result;
        }
        else
            return;
    }
}
?>
