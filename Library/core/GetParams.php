<?php

// GET変数クラス
class GetParams extends RequestVariables
{
    protected function setValues()
    {
        foreach ($_GET as $key => $value) {
            $this->_values[$key] = $value;
        }		
    }		
}

?>