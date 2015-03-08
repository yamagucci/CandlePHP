<?php

// input変数クラス
class InputParams extends RequestVariables
{
    protected function setValues()
    {
    	parse_str(file_get_contents('php://input'), $data);
        foreach ($data as $key => $value) {
            $this->_values[$key] = $value;
        }		
    }		
}


?>