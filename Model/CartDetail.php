<?php

// class CartDetail
// {
//     private $db;
//     private $name = 'cart_detail';    

//     public function __construct($user, $pass)
//     {
//         $this->db = new PDO($user, $pass);
//     }

//     // 商品リスト取得
//     public function getList($cartId)
//     {
//         $sql = sprintf('SELECT * FROM %s where cart_id = :cart_id', $this->name);
//         $stmt = $this->db->query($sql);
//         $stmt->bindValue(':cart_id', $cartId);
//         $rows = $stmt->fetchAll();
//         return $rows;
//     }
    
//     // 商品追加
//     public function add($data)
//     {
//         $sql = sprintf('INSERT INTO %s ・・・・・・・・', $this->name);
//         $res = $this->db->query($sql);
//         return $res;
//     }
    
//     // 商品削除
//     public function remove($productId)
//     {
//         $sql = sprintf('DELETE FROM %s WHERE ・・・・・・・・', $this->name);
//         $res = $db->query($sql);
//         return $res;
//     }
// }

?>