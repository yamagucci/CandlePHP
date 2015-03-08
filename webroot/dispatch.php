<?php
class Dispatcher
{
    private $sysRoot;

    public function __construct($path)
    {
        $this->sysRoot = rtrim($path, '/');
    }

    public function dispatch()
    {
        // パラメーター取得（末尾の / は削除）
        $stringparams = explode("/CandlePHP/", $_SERVER['REQUEST_URI']);
        if (!isset($stringparams[1]))exit();
        $stringparams = explode("?", $stringparams[1]);
        $param = ereg_replace('/?$', '',$stringparams[0] );
        $params = array();
        if ('' != $param) {
            $params = explode('/', $param);
        }
        // １番目のパラメーターをcontrollerとして取得
        $controller=(0 < count($params))?$params[0]:'home';
        // １番目のパラメーターをもとにコントローラークラスインスタンス取得
        $controllerInstance = $this->getControllerInstance($controller);
        if (null == $controllerInstance) {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
        // 2番目のパラメーターをactionとして取得
        $action=(1 < count($params))?$params[1]:'index';
       // アクションメソッドの存在確認
        if (false == method_exists($controllerInstance, $action)) {
          header("HTTP/1.0 404 Not Found");
          exit;
        }


        // 3番目以降はパラメーターなのでその配列として取得
        $actionParams=array_slice($params, 2);

        // コントローラー初期設定
        $controllerInstance->setSystemRoot($this->sysRoot);
        $controllerInstance->setRequest($actionParams);
        $controllerInstance->setControllerAction($controller, $action);
        // 処理実行
        $controllerInstance->run();
    }
    // コントローラークラスのインスタンスを取得
    private function getControllerInstance($controller_name)
    {
        // 一文字目のみ大文字に変換＋"Controller"
        $className = ucfirst(strtolower($controller_name)) . 'Controller';
        // コントローラーファイル名
        $controllerFileName = sprintf('%s/Controller/%s.php', $this->sysRoot, $className);
        // ファイル存在チェック
        if (false == file_exists($controllerFileName)) {
            return null;
        }
        // クラスファイルを読込
        require_once $controllerFileName;
        // クラスが定義されているかチェック
        if (false == class_exists($className)) {
            return null;
        }
        // クラスインスタンス生成
        $controllerInstarnce = new $className();

        return $controllerInstarnce;
    }
}