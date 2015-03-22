<?php
class ErrorHandler
{
	// エラーを捕捉した時はその詳細を表示します。
    public function handleCandleError(CandleException $e)
    {
    	echo "<pre>";
    	var_dump($e);
    	echo "</pre>";
    	exit();
    }

}