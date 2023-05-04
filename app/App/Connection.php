<?php 

namespace Rscharitas\MVCPCARE\App;
use Symfony\Component\Dotenv\Dotenv;

class Connection {
    
    private $dsn;
    private $user;
    private $pass;
    protected $resultSet;
    private $conn;
    public $rowCount;

    function __construct($connectNow = true) {

        $dotenv = new Dotenv();
        $dotenv->load( __DIR__ . '/.env');

        $this->dsn = $_ENV['MSSQL_DATA_SET'];
        $this->user = $_ENV['MSSQL_USERNAME'];
        $this->pass = $_ENV['MSSQL_PASS'];

        if($connectNow)
        {
            $this->connect();
        }
    }

    public function connect()
    {
        $this->conn = odbc_connect($this->dsn, $this->user, $this->pass) or die('Could not connect');
    }

    public function disconnect()
    {
        odbc_close($this->conn);
    }

    public function executeQuery($sqlString, $sqlParams = null, $errMsg =  'Unknown Error')
    {

        if($this->resultSet)
        {
            odbc_free_result($this->resultSet);
        }

        if($sqlParams == null)
        {
            $this->resultSet = odbc_exec($this->conn, $sqlString) or die($errMsg);
            // echo $this->resultSet;
        }
        else
        {
            $this->resultSet = odbc_prepare($this->conn, $sqlString);
            odbc_execute($this->resultSet, $sqlParams) or die($errMsg);
        }
    }

    public function fetchArrayList()
    {
        $row = array();
        $rows = array();

        while(odbc_fetch_into($this->resultSet, $row))
        {
            array_push($rows,$row);
        }

        $this->fetchRowCount($rows);
        return $rows;
    }


    public function fetchArrayListEx()
    {
        $i = 0 ;
        $j = 0;
        $tmpResult = array();
        while(odbc_fetch_row($this->resultSet))
        {
            for($j=1; $j<= odbc_num_fields($this->resultSet); $j++)
            {
                $fieldName = odbc_field_name($this->resultSet,$j);
                $ar[$fieldName] = odbc_result($this->resultSet,$fieldName);
            }
            $tmpResult[$i]  = $ar;
            $i++;
        }

        //sets row count property
        $this->fetchRowCount($tmpResult);
        return $tmpResult;
    }

    private function fetchRowCount($arrCount )
    {
        if(is_array($arrCount))
        {
            $this->rowCount = sizeof($arrCount);
        }

    }

    public function printOut($obj)
    {
        echo "<pre>";
        print_r($obj);
        echo "</pre>";

    }
}
