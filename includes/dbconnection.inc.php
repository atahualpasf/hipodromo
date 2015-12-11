<?php
	session_start();
	class Database{
		private $dbConnection = null;
		private $_SITE_ROOT;
		
		function __construct(){
			$this->_SITE_ROOT = realpath(__DIR__ . '/..');
			include_once($this->_SITE_ROOT."/conf/config.inc.php");
			$this->dbConnection = pg_connect($strConnection);
		}
		
		
		/************************************************************
		*																														*
		*			FUNCIONES GENÉRICAS DE POSTGRESQL											*
		*																														*
		************************************************************/	
		function status(){
			$status = pg_connection_status($this->dbConnection);
			if ($status === PGSQL_CONNECTION_OK) {
				return "Connection status ok";
			} else {
				return "Connection status bad";
			}
		}
		
		function disconnect(){
			if(!pg_close($this->dbConnection)) {
				return "Failed to close connection to " . pg_host($this->dbConnection) . ": " . pg_last_error($this->dbConnection) . "<br/>\n";
			} else {
				return "Successfully disconnected from database";
			}
		}
		
		function result_construct($action,$data){
			$result = array("action"=>$action,"response"=>array("data"=>$data));
			$result = json_encode($result);
			return $result;
		}
	}
?>