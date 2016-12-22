<?php
/**
 * Connection to the database
 */

namespace Kernel;

/**
 * Connection to the database
 */
class Connection {
    /**
     * store the PDO object
     * @var PDO
     */
    private $_pdo=null;
    /**
     * store the instance for singleton pattern
     * @var Connection
     */
    private static $_instance;
    
    /**
     * Constructor
     * <code>
     * Connection::setup('mysql:host=localhost;dbname=database', 'username', 'password', array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
     * </code>
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param array $options
     */
    private function __construct($dsn,$username,$password,$options){
        try{
            $this->_pdo=new \PDO($dsn,$username,$password,$options);            
            
        }
        catch (Exception $e){
            die('Error : '.$e->getMessage());
        }
    }
    
    /**
     * Create an instance with setup
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param string $options
     */
    public static function setup($dsn,$username=null,$password=null,$options=null){
        self::$_instance = new self($dsn,$username,$password,$options);
    }
    
    /**
     * get the Connection instance
     * @return KORM\Connection
     * @throws \Exception
     */
    public static function get(){
        if(is_null(self::$_instance)){
            throw new \Exception('You must call Connection::setup before');
        }
        return self::$_instance;
    }
    /**
     * Prepare a SQL query
     * @param string $query
     * @return PDOStatement
     */
    public static function prepare($query){
        return self::get()->_pdo->prepare($query);
    }
    
    /**
     * execute a SQL Query
     * @param string $query
     * @return PDOStatement
     */
    public static function query($query){
        return self::get()->_pdo->query($query);          
    }
    /**
     * execute an exec query
     * @param type $query
     * @return type
     */
    public static function exec($query){
        try {
            return self::get()->_pdo->exec($query);            
        } catch (Exception $exc) {
            exit($exc->getTraceAsString());
        }
    }
    /**
     * return the last inserted id
     * @return int
     */
    public static function lastInsertId(){
        return self::get()->_pdo->lastInsertId();        
    }
    /**
     * get all rows froma query 
     * @param type $query
     * @param type $class
     * @return type
     */
    public static function fetchAll($query,$class='stdClass'){
        return  self::get()->query($query,  \PDO::FETCH_CLASS,'stdClass')->fetchAll(\PDO::FETCH_CLASS,$class);        
    }
    
}