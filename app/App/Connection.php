<?php 

namespace Rscharitas\MVCPCARE\App;
use Symfony\Component\Dotenv\Dotenv;

class Connection {
    private $conn;
    private $dsn;
    private $user;
    private $pass;
    private $query;
    // protected $resultSet;
    // public $rowCount;

    function __construct($connectNow = true) {

        $dotenv = new Dotenv();
        $dotenv->load( __DIR__ . '/.env');

        $this->dsn = $_ENV['MSSQL_DATA_SET'];
        $this->user = $_ENV['MSSQL_USERNAME'];
        $this->pass = $_ENV['MSSQL_PASS'];
        $this->query = '';

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

    public function select($columns = "*") {
        $this->query = "SELECT $columns";
        return $this;
    }

    public function selectSpecific($columns) {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }
        
        return $this->select($columns);
    }

    public function top($count) {
        $this->query = "SELECT TOP $count " . substr($this->query, 7);
        return $this;
    }

    public function from($table) {
        $this->query .= " FROM $table";
        return $this;
    }

    public function where($condition) {
        if (is_array($condition)) {
            $conditionStr = implode(" AND ", $condition);
        } else {
            $conditionStr = $condition;
        }

        $this->query .= " WHERE $conditionStr";
        return $this;
    }

    public function orWhere($conditions) {
        return $this->where($conditions, 'OR');
    }

    public function innerJoin($table, $condition) {
        $this->query .= " INNER JOIN $table ON $condition";
        return $this;
    }

    public function leftJoin($table, $condition) {
        $this->query .= " LEFT JOIN $table ON $condition";
        return $this;
    }

    public function rightJoin($table, $condition) {
        $this->query .= " RIGHT JOIN $table ON $condition";
        return $this;
    }

    public function selectSubquery($subquery, $alias) {
        $this->query .= " (SELECT $subquery) AS $alias";
        return $this;
    }

    public function selectTopSubquery($subquery, $alias, $count) {
        $this->query .= " (SELECT TOP $count $subquery) AS $alias";
        return $this;
    }

    public function selectComplexSubquery($subquery, $alias) {
        $this->query .= " ($subquery) AS $alias";
        return $this;
    }

    public function orderBy($column, $direction = 'ASC') {
        $this->query .= " ORDER BY $column $direction";
        return $this;
    }

    public function groupBy($columns) {
        $this->query .= " GROUP BY $columns";
        return $this;
    }

    public function limit($limit) {
        $this->query .= " LIMIT $limit";
        return $this;
    }

    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(function ($value) {
            return "'" . $value . "'";
        }, array_values($data)));

        $this->query = "INSERT INTO $table ($columns) VALUES ($values)";
        return $this;
    }

    public function update($table, $data) {
        $set = implode(', ', array_map(function ($key, $value) {
            return "$key = '" . $value . "'";
        }, array_keys($data), array_values($data)));

        $this->query = "UPDATE $table SET $set";
        return $this;
    }

    public function delete($table) {
        $this->query = "DELETE FROM $table";
        return $this;
    }

    public function truncate($table) {
        $this->query = "TRUNCATE TABLE $table";
        return $this;
    }

    public function union($query) {
        $this->query .= " UNION $query";
        return $this;
    }

    public function selectIn($column, $values) {
        $values = implode(', ', array_map(function ($value) {
            return "'" . $value . "'";
        }, $values));

        $this->query .= " WHERE $column IN ($values)";
        return $this;
    }

    public function execute($fetchResults = true) {
        $result = odbc_exec($this->conn, $this->query);

        if (!$result) {
            echo "Query execution failed: " . odbc_errormsg();
            return false;
        }

        if ($fetchResults) {
            $rows = array();

            while ($row = odbc_fetch_array($result)) {
                $rows[] = $row;
            }

            return $rows;
        }

        return $result;
    }

    public function freeResult($result) {
        odbc_free_result($result);
    }

    // public function top($count) {
    //     $this->query = "SELECT TOP $count * FROM (" . $this->query . ") AS subquery";
    //     return $this;
    // }

    // public function selectOnSelect($subquery, $alias) {
    //     $this->query .= " ($subquery) AS $alias";
    //     return $this;
    // }
    
    // public function top($count) {
    //     $this->query .= " TOP $count";
    //     return $this;
    // }

    // public function execute() {
    //     $stmt = odbc_exec($this->conn, $this->query);
    //     if (!$stmt) {
    //         die("Error executing SQL statement: " . odbc_errormsg());
    //         return false;
    //     }

    //     $rows = array();
    //     while ($row = odbc_fetch_array($stmt)) {
    //         $rows[] = $row;
    //     }
    //     return $rows;
    // }
    
    // public function execute($sql) {
    //     if (!$this->conn) {
    //         $this->connect();
    //     }
    //     $stmt = odbc_exec($this->conn, $sql);
    //     if (!$stmt) {
    //         die("Error executing SQL statement: " . odbc_errormsg());
    //     }
    //     return $stmt;
    // }
    
    // public function executeQuery($sqlString, $sqlParams = null, $errMsg =  'Unknown Error')
    // {

    //     if($this->resultSet)
    //     {
    //         odbc_free_result($this->resultSet);
    //     }

    //     if($sqlParams == null)
    //     {
    //         $this->resultSet = odbc_exec($this->conn, $sqlString) or die($errMsg);
    //         // echo $this->resultSet;
    //     }
    //     else
    //     {
    //         $this->resultSet = odbc_prepare($this->conn, $sqlString);
    //         odbc_execute($this->resultSet, $sqlParams) or die($errMsg);
    //     }
    // }

    // public function fetchArrayList()
    // {
    //     $row = array();
    //     $rows = array();

    //     while(odbc_fetch_into($this->resultSet, $row))
    //     {
    //         array_push($rows,$row);
    //     }

    //     $this->fetchRowCount($rows);
    //     return $rows;
    // }


    // public function fetchArrayListEx()
    // {
    //     $i = 0 ;
    //     // $j = 0;
    //     $tmpResult = array();
    //     while(odbc_fetch_row($this->resultSet))
    //     {
    //         for($j=1; $j<= odbc_num_fields($this->resultSet); $j++)
    //         {
    //             $fieldName = odbc_field_name($this->resultSet,$j);
    //             $ar[$fieldName] = odbc_result($this->resultSet,$fieldName);
    //         }
    //         $tmpResult[$i]  = $ar;
    //         $i++;
    //     }

    //     //sets row count property
    //     $this->fetchRowCount($tmpResult);
    //     return $tmpResult;
    // }

    // private function fetchRowCount($arrCount)
    // {
    //     if(is_array($arrCount))
    //     {
    //         $this->rowCount = sizeof($arrCount);
    //     }
    // }

    // public function printOut($obj)
    // {   
    //     echo "<pre>";
    //     print_r($obj);
    //     echo "</pre>";
    // }
}
