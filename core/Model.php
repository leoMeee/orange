<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/10/3
 * Time: 下午9:29
 */

namespace core;


abstract class Model
{
    /**
     * @var \PDO
     */
    protected $con;
    protected $table = '';

    public function __construct()
    {
        $dbms = 'mysql';     //数据库类型
        $host = 'localhost'; //数据库主机名
        $dbName = 'orange';    //使用的数据库
        $user = 'root';      //数据库连接用户名
        $pass = '123456';          //对应的密码
        $dsn = "$dbms:host=$host;dbname=$dbName";

        if (!$this->con) {
            try {
                $this->con = new \PDO(
                    $dsn,
                    $user,
                    $pass,
                    array(\PDO::ATTR_PERSISTENT => true, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';")
                );
            } catch (\PDOException $e) {
                throw new \Exception('数据库连接失败: '.$e->getMessage());
            }
        }
    }

    public function query($statement)
    {
        $statement = $this->con->query($statement, \PDO::FETCH_ASSOC);
        $arr = [];

        if ($statement !== false) {
            foreach ($statement as $item) {
                $arr[] = $item;
            }
        }

        return $arr;
    }

    public function add(array $params = [])
    {
        $column = array_keys($params);
        $columnSql = implode(',', array_keys($params));
        $str = rtrim(str_pad('', count($params) * 3, '?, '), ', ');
        $sql = 'insert into '.$this->getTable().' ('.$columnSql.')values('.$str.')';

        $stmt = $this->con->prepare($sql);
        foreach ($column as $key => $value) {
            $stmt->bindParam($key + 1, $params[$value]);
        }

        $stmt->execute();

        return $this->con->lastInsertId();
    }

    public function update($condition, array $params = array())
    {

    }

    public function find($id)
    {
        $sql = 'select * from '.$this->getTable();
        $where = 'id = '.$id;
        $sql .= ' where '.$where.' limit 1';
        $result = $this->query($sql);

        return $result[0] ?? [];
    }

    public function all($column = ['*'], $limit = 20)
    {
        $column = implode(',', $column);
        $sql = sprintf('select %s from %s limit %d', $column, $this->getTable(), $limit);

        return $this->query($sql);
    }

    protected function getTable()
    {
        return $this->table;
    }
}