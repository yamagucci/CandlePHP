<?php 

class AppModel{
    private static $connInfo;
    private $db;
    private $stmt;
    protected $res;
    protected $name;
    /*
    init function
    初期化時のみ呼ぶメソッド
    */

    public function __construct(){
        $this->initDb();
    }
    public function initDb(){
        $this->db = new PDO(
            sprintf(
                "mysql:dbname=%s;host=%s",
                self::$connInfo['dbname'],
                self::$connInfo['host']
            ),
            self::$connInfo['username'],
            self::$connInfo['password']
        );
        $this->db->query('SET NAMES utf8');
    }
    public static function setConnectionInfo($connInfo){
        self::$connInfo = $connInfo;
    }
    /*
    private function
    SubClassから呼ぶことができるメソッド
    */
    private function whereStringWithParams($params=null,$option=true){
        if ($params != null) {
            $fields = array();
            foreach ($params as $key => $val) {
                if ($option==true) {
                    $fields[] = $key . ' = :' . $key;
                }else{
                    $fields[] = $key . ' = ' . $val;
                } 
            }
            $whereString = " WHERE " . implode(' and ', $fields);
            return $whereString;
        }else{
            return '';
        }
    }
    private function throwSQL($sql,$params=null)
    {
        $this->stmt = $this->db->prepare($sql);
        $this->bindParams($params);
        $this->res = $this->stmt->execute();
    }
    private function bindParams($params=null)
    {
        if ($params != null) {
            foreach ($params as $key => $val) {
                $this->stmt->bindValue(':' . $key, $val);
            }
        }
    }


    /*
    protected function
    SubClassから呼ぶことができるメソッド
    */

    // Select文を処理する
    protected function select($params=null){
        $sql = sprintf(
            "SELECT * FROM %s%s",
            $this->name,
            $this->whereStringWithParams($params)
        );
        $this->throwSQL($sql,$params);
        $rows = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $rows;
    }
    // Delete文を処理する
    protected function delete($params = null){
        $sql = sprintf(
            "DELETE FROM %s%s",
            $this->name,
            $this->whereStringWithParams($params)
        );
        $this->throwSQL($sql,$params);
        return $this->res;
    }
    // Insert文を処理する
    protected function insert($data){
        $fields = array();
        $values = array();
        foreach ($data as $key => $val) {
            $fields[] = $key;
            $values[] = ':' . $key;
        }
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)", 
            $this->name,
            implode(',', $fields),
            implode(',', $values)
        );
        $this->throwSQL($sql,$data);
        return $this->res;        
    }
    protected function update($data,$params){
        $fields = array();
        foreach ($data as $key => $val) {
            $fields[] = $key . ' = :' . $key;
        }
        $sql = sprintf(
            "UPDATE %s SET %s%s", 
            $this->name,
            implode(',', $fields),
            $this->whereStringWithParams($params)
        );
        var_dump($sql);
        $this->throwSQL($sql,$data);
        return $this->res;        
    }

    /*
    public function
    SubClass,Controllerから呼ぶことができるメソッド
    */

    // データを保存する
    // 戻り値　bool　success or failed
    public function add($data){
        $res = $this->insert($data);
        return $res;
    }

    public function getAll(){
        $rows = $this->select();
        return $rows;
    }
    // データを一件取得する
    public function getById($id){
        $params =  array('id' => $id);
        $rows = $this->select($params);
        return $rows[0];
    }
    // データを削除する
    // 戻り値　bool　success or failed
    public function deleteById($id){
        $params =  array('id' => $id);
        $res = $this->delete($params);
        return $res;
    }
    // データを更新する
    // 戻り値　bool　success or failed
    public function editById($data,$id){
        $params =  array('id' => $id);
        $res = $this->update($data,$params);
        return $res;
    }
}



