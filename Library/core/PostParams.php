<?php

// POST変数クラス
class PostParams extends RequestVariables
{
    protected function setValues()
    {
        foreach ($_POST as $key => $value) {
            $this->_values[$key] = $value;
        }		
    }		
}


?>