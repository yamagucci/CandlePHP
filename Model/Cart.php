<?php

// class CartHeader
// {
//     private $db;
//     private $name = 'cart_header';    

//     public function __construct($user, $pass)
//     {
//         $this->db = new PDO($user, $pass);
//     }

//     // カート基本情報取得
//     public function getUserCart($userId)
//     {
//         $sql = sprintf('SELECT * FROM %s where user_id = :user_id' , $this->name);
//         $stmt = $this->db->query($sql);
//         $stmt->bindValue(':user_id', $userId);
//         $rows = $stmt->fetchAll();
//         return $rows[0];
//     }

//     // 新規カート作成
//     public function create($userId)
//     {
//         $sql = sprintf('INSERT INTO %s ・・・・・・・・', $this->name);
//         $res = $this->db->query($sql);
//         return $res;
//     }

// }

?>