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
     * --------- OR ---------------
     * @param string $time
     * @param string $message
     * @param string $level
     * @param string $context
     */
    public function bind_column_names(/*$time, $level, $message, $context*/){

        $this->_column_names = [
            'time'    => null,
            'message' => null,
            'level'   => null,
            'context' => null,
        ];

        if(is_array(func_get_arg(0))){

            $this->_column_names = func_get_arg(0);

        }else if(func_num_args() > 1){

            $this->_column_names = [
               'time'    => func_get_arg(0),
               'level'   => func_get_arg(1),
               'message' => func_get_arg(2),
               'context' => func_get_arg(3),
            ];
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

            foreach($this->_column_names as $column => $name){
                if($name && in_array($column, ['time', 'message', 'level', 'context'])){
                    $columns .= '`'  . $name   . '`,';
                    $values  .= ':' . $column . ',';
                }else{
                    unset($params[$column]);
                }
            }

            $query   = "INSERT INTO  `{$this->_table_name}` (". substr($columns, 0, -1) .") VALUES (". substr($values, 0, -1) .")";

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

