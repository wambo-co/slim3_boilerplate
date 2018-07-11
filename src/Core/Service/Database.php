<?php
namespace Wambo\Core\Service;

use Exception;
use PDO;

class Database
{
    const REQUIRED_VALUE = 1;
    const UNIQUE_VALUE = 2;

    private $database = null;
    private $databaseName = null;

    public function __construct($dsn, $host, $database, $user, $password)
    {
        $this->database = new PDO($dsn . ':dbname=' . $database . ';host=' . $host, $user, $password);
        $this->databaseName = $database;

        $this->query('SET NAMES UTF8');
    }


    public function query($query, $values = array())
    {
        if (!is_array($values)) {
            $values = array($values);
        }

        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            throw new Exception('<b>SQL-ERROR:</b> #' . $this->database->errorCode() . ' '
                . print_r($this->database->errorInfo(), true) . '<br/><b>STATEMENT:</b> ' . $query);
        }

        $success = $stmt->execute($values);

        if ($success === false) {
            throw new Exception('<b>SQL-ERROR:</b> #' . $stmt->errorCode() . ' '
                . print_r($stmt->errorInfo(), true) . '<br/><b>STATEMENT:</b> ' . $query);
        }

        return $stmt;
    }


    public function insert($table, $data)
    {
        $this->query('INSERT INTO ' . $table . ' (`' . implode('`, `', array_keys($data)) . '`) VALUES ('
            . substr(str_repeat(',?', count($data)), 1) . ')', array_values($data));
        return $this->database->lastInsertId();
    }

    public function insertAll($table, $dataAll)
    {
        foreach ($dataAll as $data) {
            $this->query('INSERT INTO ' . $table . ' (`' . implode('`, `', array_keys($data)) . '`) VALUES ('
                . substr(str_repeat(',?', count($data)), 1) . ')', array_values($data));
        }

        return $this->database->lastInsertId();
    }


    public function update($table, $where, $values, $data)
    {
        $table = is_array($table) ? implode(", ", $table) : $table;
        $values = is_array($values) ? $values : array($values);
        $result = $this->query('UPDATE ' . $table . ' SET `' . implode('`=?, `', array_keys($data)) . '`=? WHERE '
            . $where, array_merge(array_values($data), $values));
        return $result->rowCount();
    }


    public function delete($table, $where, $values = array()) : int
    {
        $result = $this->query('DELETE FROM ' . $table . ' WHERE ' . $where, $values);
        return $result->rowCount();
    }


    public function replace($table, $data)
    {
        $this->query('REPLACE INTO ' . $table . ' (`' . implode('`, `', array_keys($data)) . '`) VALUES ('
            . substr(str_repeat(',?', count($data)), 1) . ')', array_values($data));
        return $this->database->lastInsertId();
    }


    public function getAll($query, $values = array())
    {
        $result = $this->query($query, $values);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getRow($query, $values = array(), $default = null)
    {
        $result = $this->query($query, $values);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row !== false ? $row : $default;
    }


    public function getValue($query, $values = array(), $default = null)
    {
        $result = $this->query($query, $values);
        $row = $result->fetch(PDO::FETCH_NUM);
        return isset($row[0]) ? $row[0] : $default;
    }


    public function getCol($query, $values = array(), $col = 0)
    {
        $result = $this->query($query, $values);
        return $result->fetchAll(PDO::FETCH_COLUMN, $col);
    }


    public function getEnumValues($table, $column)
    {
        $result = $this->getRow('SHOW COLUMNS FROM ' . $table . ' WHERE field=?', array($column), true);

        if (is_array($result) && isset($result['Type'])) {
            preg_match_all("/'(.*?)'/", $result['Type'], $hits);
            return $hits[1];
        }

        return false;
    }


    public function getDefaults($table)
    {
        $columns = array();
        $constraints = array();

        foreach ($this->getAll('SHOW COLUMNS FROM ' . $table) as $column) {
            $columns[$column['Field']] = $column['Default'];

            if ($column['Null'] === 'NO' && $column['Type'] === 'datetime' && $column['Default'] == null) {
                $columns[$column['Field']] = date('Y-m-d H:i:s');
            }

            if ($column['Null'] === 'NO' && $column['Extra'] !== 'auto_increment') {
                $constraints[$column['Field']] = self::REQUIRED_VALUE;
            }

            if ($column['Key'] === 'UNI') {
                if (!isset($constraints[$column['Field']])) {
                    $constraints[$column['Field']] = 0;
                }

                $constraints[$column['Field']] += self::UNIQUE_VALUE;
            }
        }

        return array($columns, $constraints);
    }

    public function setLogfile($file = null)
    {
        $this->_logfile = $file;
    }
}
