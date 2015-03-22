<?php
// システムのルートディレクトリパス
define('ROOT_PATH',realpath(dirname(__FILE__).'/..'));


// 基本クラスの読み込み
require_once ROOT_PATH.'/Model/AppModel.php';
require_once ROOT_PATH.'/Controller/AppController.php';

// 各種ライブラリの読み込み
require_once ROOT_PATH.'/Library/list.php';

// データベース接続情報設定
$connInfo = array(
    'host'     => 'localhost',
    'dbname'   => 'sampledb',
    'username'   => 'root',
    'password' => 'root'
);
AppModel::setConnectionInfo($connInfo);

// リクエスト振り分け
require_once 'dispatch.php';
$dispatcher = new Dispatcher(ROOT_PATH);
try {
	$dispatcher->dispatch();
}
catch (CandleException $e) {
    ErrorHandler::handleCandleError($e);
}






