<?php
//http://blog.csdn.net/qq635785620/article/details/11284591

class HRDB
{
    protected $pdo;
    protected $res;
    protected $config;

    function __construct($conf)
    {
        $this->config = $conf;
        $this->connect();
    }

    private function connect()
    {
        $this->pdo = new PDO($this->config['dsn'], $this->config['user'], $this->config['password']);
        $this->pdo->query("set names utf8;");
        $this->pdo->setAttribute(PDO::ATTR_PERSISTENT, true); //持久连接
    }

    public function query($sql)
    {

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function exec($sql)
    {

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->rowCount();
    }


    public function find($table, $fields="*", $where="", $order="")
    {
        $sql = "select $fields from $table where 1=1";
        if ($where) {
            $sql .= " and ".$where;
        }

        if ($order) {
            $sql .= " order by $order";
        }

        $sql .= " limit 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($data)) {
            return $data[0][$fields];
        }

        return null;
    }

    public function select($table, $fields="*", $where="", $order="")
    {

        $sql = "select $fields from $table where 1=1";

        if ($where) {
            $sql .= " and $where";
        }

        if ($order) {
            $sql .= " order by $order";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectPage($table, $fields="*", $where="", $order="", $limit="")
    {

        $sql = "select $fields from $table where 1=1";

        if ($where) {
            $sql .= " and $where";
        }

        if ($order) {
            $sql .= " order by $order";
        }

        if ($limit) {
            $sql .= " limit $limit";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data)
    {
        $keys = "";
        $values = "";
        foreach($data as $k=>$item) {
            $keys .= "`$k`,";
            $values .= "'$item',";
        }

        $keys = rtrim($keys, ',');
        $values = rtrim($values, ',');

        $sql = "insert into $table($keys) values($values)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $this->pdo->lastinsertid();
    }


    public function update($table, $where, $data)
    {
        $setdata = "";
        foreach($data as $k=>$v) {
            $setdata .= $k."='".$v."',";
        }

        $setdata = rtrim($setdata, ",");

        $sql = "update ".$table." set $setdata where 1=1";

        if ($where) {
            $sql .= " and $where";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->rowCount();
    }


    public function delete($table, $where)
    {
        $sql = "delete from ".$table;

        if ($where) {
            $sql .= " where $where";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->rowCount();
    }


    public function count($table, $where)
    {
        $sql = "select count(*) as total from ".$table;

        if ($where) {
            $sql .= " where $where";
        }

        $sql .= " limit 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($data['total'])) {
            return $data['total'];
        }

        return 0;
    }


    public function trans($sqls=array())
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, ERRMODE_EXCEPTION); //错误模式
            $this->pdo->beginTransaction();

            foreach($sqls as $sql) {
                $this->exec($sql);
            }

            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            return "Error:".$e->getMessage();
        }
    }

    function __destruct()
    {
        $this->pdo = null;
    }
}
