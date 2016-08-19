<?php

namespace Loggr\Envoy;

/**
 * Class MySQL
 * @package Loggr\Envoy
 */
class MySQL extends \Loggr\AbstractLoggr implements \Loggr\LoggrInterface {


    /**
     * @var \PDO
     */
    private $_connection;


    /**
     * @var string
     */
    private $_table_name = null;


    /**
     * @var array
     */
    private $_column_names = [
        'time'    => 'created_at',
        'message' => 'message',
        'level'   => 'level',
        'context' => 'context',
    ];


    /**
     * @param \PDO $conn
     * @return bool if connection if actually connected
     */
    public function set_connection(\PDO $conn){
        $this->_connection = $conn;

        //Throw exeption when INSERT fail (Logs should made the whole app fail. Lol.)
        $this->_connection->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
        return $this->_is_connected();
    }


    /**
     * Set the table for logging
     *
     * @param string $table_name
     */
    public function set_table_name($table_name){
        $this->_table_name = $table_name;
    }


    /**
     * @return string
     */
    public function get_table_name(){
        return $this->_table_name;
    }


    /**
     * @param string $hostname
     * @param string $username
     * @param string $password
     * @param string $database
     *
     * @return bool
     */
    public function connect($hostname, $database, $username, $password = null){
        return $this->set_connection(
            new \PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password)
        );
    }


    /**
     * Bind the columns names to log data in the right columns
     * Defaults are "created_at" for time, "message" for message, "level" for level and "context" for context.
     * Set to null to skip a column :
     * For exemple, if context is set to nul, insert query will only insert message and level
     *
     * @param array $binded_names with key : ['time' => '***', 'message' => '***', 'level' => '***', 'context' => '***']
     */
    public function bind_column_names($array){
        foreach ($array as  $name => $column){
            if($name){
                $this->_column_names[$name] = $column;
            }else{
                $this->remove_column($name);
            }
        }
    }


    /**
     * Bind a new column.
     * This column will be filled by the equivalent context key.
     *
     * @param  string $name
     * @param  string $column  SQL column name. If not given, then same as name
     */
    public function bind_column($name, $column = null){
        $this->_column_names[$name] = $column ? $column : $name;
    }


    public function remove_column($name){
        if(key_exists($name, $this->_column_names)){
            $this->_column_names[$name] = null;
        }
    }


    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = []) {

        if($this->_table_name && $this->_is_connected()) {

            $values  = $columns = '';

            $params = [
                'level'      => $level,
                'time'       => $this->_get_time(),
                'message'    => $this->_format_message($message, $context),
                'context'    => $this->_format_context($context),
            ];

            foreach($this->_column_names as $name => $column ){
                if($column !== null){
                    $columns .= '`'  . $column   . '`,';
                    $values  .= ':' .  $name . ',';

                    if(!isset($params[$name])){
                        $params[$name] =  isset($context[$name]) ? $context[$name] : null;
                    }

                }else{
                    unset($params[$name]);
                }
            }

            $query    = "INSERT INTO  `{$this->_table_name}` (". substr($columns, 0, -1) .") ";
            $query   .=  " VALUES (". substr($values, 0, -1) .")";

            $stmt = $this->_connection->prepare($query);
            $stmt->execute($params);
        }
    }



    private function _is_connected(){
        if($this->_connection) {
            return $this->_connection->getAttribute(\PDO::ATTR_CONNECTION_STATUS);
        }
        return false;
    }


}

