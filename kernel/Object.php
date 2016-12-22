<?php

namespace Kernel;

use Kernel\Connection;

/**
 * All the query of the database
 */
class Object {

    /**
     * id of a table
     * @var string 
     */
    protected static $_primaryKeyColumn = 'id';

    /**
     * Constructor
     * @param int $id 
     */
    public function __construct($id = null) {
        $class = get_called_class();
        if (is_null($id) and ( !isset($this->id) or is_null($this->id))) {
            $vars = $class::getColumns($class::_getTable());
            foreach ($vars as $value) {
                $key = $value['Field'];
                $this->$key = $value['Default'];
            }
        } else {
            $query = 'select * from `' . $class::_getTable() . '` where ' . self::$_primaryKeyColumn . '=?';
            $pdo = Connection::prepare($query);
            $pdo->execute([$id]);
            $attrs = $pdo->fetchAll(\PDO::FETCH_ASSOC);
            if (isset($attrs[0])) {
                foreach ($attrs[0] as $key => $value) {
                    $this->$key = $value;
                }
            }
        }
    }
    
    /**
     * retrieves the name of the table
     * @return string
     */
    public static function _getTable() {
        $class = get_called_class();
        if (isset($class::$_table)) {
            return $class::$_table;
        } else {
            return strtolower(str_replace('\\', '_', $class));
        }
    }

    /**
     * Retrives the columns of the table
     * @param string $table
     * @return Object
     */
    public static function getColumns($table = null) {
        if (is_null($table)) {
            $table = self::_getTable();
        }
        $query = 'show columns from `' . $table . '`';
        try {
            return Connection::query($query)->fetchAll(\PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print($query);
            exit($e->getMessage());
        }
    }
    
    /**
     * Return the result of a where sql query
     * @param type $where
     * @param array $params
     * @return array
     */
    public static function where($where, $params = []) {
        $query = 'select * from `' . self::_getTable() . '` where ' . $where;
        return self::query($query, $params);
    }
    
    /**
     * Return the first value of a where sql query
     * @param string $where
     * @param string $params
     * @return array
     */
    public static function whereFirst($where, $params) {
        $array = self::where($where, $params);
        return isset($array[0]) ? $array[0] : null;
    }
    
    /**
     * Return the values of a query
     * @param string $params
     * @return array
     */
    public static function find($params) {
        $where = [];
        $p = [];
        foreach ($params as $key => $value) {
            $where[] = '`' . $key . '`=?';
            $p[] = $value;
        }
        return self::where(implode(' and ', $where), $p);
    }
    
    /**
     * Return only the first value of a query
     * @param string $params
     * @return array
     */
    public static function findOne($params) {
        $array = self::find($params);
        return isset($array[0]) ? $array[0] : null;
    }
    
    /**
     * Retrives all the values of a table on database
     * @return array
     */
    public static function getAll() {
        $query = 'select * from `' . self::_getTable() . '`;';
        return self::query($query, []);
    }
    
    /**
     * 
     * @param type $params
     * @return type
     */
    public static function count($params = []) {
        $query = 'select count(*) from `' . self::_getTable() . '` ';
        $where = [];
        $p = [];
        if (count($params) > 0) {
            foreach ($params as $key => $value) {
                $where[] = '`' . $key . '`=?';
                $p[] = $value;
            }
            $query.='where ' . implode(' and ', $where);
        }
        $statement = Connection::prepare($query);
        try {
            $statement->execute($p);
        } catch (Exception $e) {
            print($query);
            exit($e->getMessage());
        }
        $result = $statement->fetchAll(\PDO::FETCH_COLUMN);
        return $result[0];
    }

    /**
     * Execute an sql query
     * @param string $query
     * @param string $params
     * @return array
     */
    public static function query($query, $params) {
        $statement = Connection::prepare($query);
        try {
            $statement->execute($params);
        } catch (Exception $e) {
            print($query);
            exit($e->getMessage());
        }

        $result = $statement->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        return $result;
    }

    /**
     * 
     * @return array
     */
    protected function _getNamespace() {
        $thisClass = get_class($this);
        return implode('\\', array_slice(explode('\\', $thisClass), 0, -1));
    }
    
    /**
     * Execute an sql query
     * @param string $query
     * @param string $params
     * @return array
     */
    public static function exec($query, $params) {
        try {
            $statement = Connection::prepare($query);
            $statement->execute($params);
        } catch (Exception $e) {
            var_dump($query);
            exit($e->getMessage());
        }

        return $statement->rowCount();
    }
    
    /**
     * If foreign doesn't exists, it drops the table
     * @param boolean $foreignKeyCheck
     * @return type
     */
    public static function drop($foreignKeyCheck = true) {
        if (!$foreignKeyCheck) {
            Connection::exec('SET FOREIGN_KEY_CHECKS = 0;');
        }
        $return = Connection::exec('drop table `' . self::_getTable() . '`;');
        if (!$foreignKeyCheck) {
            Connection::exec('SET FOREIGN_KEY_CHECKS = 1;');
        }
        return $return;
    }

    /**
     * If foreign key doesn't exists, it clean the table
     * @param boolean $foreignKeyCheck
     * @return type
     */
    public static function truncate($foreignKeyCheck = true) {
        if (!$foreignKeyCheck) {
            Connection::exec('SET FOREIGN_KEY_CHECKS = 0;');
        }
        $return = Connection::exec('truncate `' . self::_getTable() . '`;');
        if (!$foreignKeyCheck) {
            Connection::exec('SET FOREIGN_KEY_CHECKS = 1;');
        }
        return $return;
    }

    /**
     * Delete value(s) on database
     * @return type
     */
    public function delete() {
        $return = $this->exec('delete from ' . self::_getTable() . ' where `' . self::$_primaryKeyColumn . '` = ?', [$this->id]);
        unset($this);
        return $return;
    }

    /**
     * destructor
     */
    public function __destruct() {
        unset($this);
    }

    /**
     * Verify if primary key exists
     * @param int $id
     * @return boolean
     */
    public static function keyExists($id) {
        return sizeof(self::find([self::$_primaryKeyColumn, $id])) > 0;
    }
    
    /**
     * Verify if values exist in a table
     * @return boolean
     */
    public static function tableExists() {
        $query = 'show tables like "' . self::_getTable() . '"';
        return sizeof(Connection::fetchAll($query)) > 0;
    }
    
    /**
     * Store the values on database
     * @return \Kernel\Object
     */
    public function store() {
        $id = self::$_primaryKeyColumn;

        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            if (substr($key, 0, 1) == '_' or $key == self::$_primaryKeyColumn) {
                unset($vars[$key]);
            }
            if (is_object($value)) {
                $vars[$key . '_id'] = $value->id;
                unset($vars[$key]);
            }
            if (is_array($value)) {
                unset($vars[$key]);
            }
        }
        if (!isset($this->$id) or is_null($this->$id)) {
            $query = 'insert into `' . self::_getTable() . '`(`' . implode('`, `', array_keys($vars)) . '`) values (?' . str_repeat(', ?', sizeof($vars) - 1) . ')';
            $statement = Connection::prepare($query);
            $statement->execute(array_values($vars));
            $this->$id = Connection::lastInsertId();
        } else {
            $query = 'update `' . self::_getTable() . '` set `' . implode('` = ?, `', array_keys($vars)) . '` = ? '
                    . 'where `' . self::$_primaryKeyColumn . '` = ?';

            $statement = Connection::prepare($query);
            $vars[self::$_primaryKeyColumn] = $this->$id;
            $statement->execute(array_values($vars));
        }
//        $vars = get_object_vars($this);
//        foreach ($vars as $key => $value) {
//            if (is_array($value)) {
//                $classBetween = $this->_getClassBetween(ucfirst($key), true);
//                $items = $classBetween::find([$this->_getTable() . '_id' => $this->id]);
//                foreach ($items as $item) {
//                    $item->delete();
//                }
//                foreach ($value as $v) {
//                    $item = $classBetween::newItem();
//                    $field1 = $this->_getTable();
//                    $item->$field1 = $this;
//
//                    $field2 = $key;
//                    $item->$field2 = $v;
//                    $item->store();
//                }
//                unset($vars[$key]);
//            }
//        }
        return $this;
    }

    /**
     * Populate the database
     * @param array $params
     * @return \Kernel\Object
     */
    public function populate(array $params) {
        $columns = self::getColumns();
        foreach ($columns as $column) {
            if (isset($params[$column['Field']])) {
                $columnName = $column['Field'];
                $this->$columnName = $params[$column['Field']];
            }
        }
        return $this;
    }
    
    /**
     * Convert on string
     * @return string
     */
    public function __toString() {
        return json_encode($this);
    }

}
