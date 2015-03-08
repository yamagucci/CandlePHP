<?php
class User extends AppModel
{
    protected $name = 'users';
    
    public function isUser($params){
        $res = $this->select($params);
        if (!count($res)) {
        	return null;
        }
        return $res[0];
    }
}