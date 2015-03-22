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
        $urlparams=$this->getUrlParams();

        // １番目のパラメーターをcontrollerとして取得
        $controller=($urlparams[0]!='')?$urlparams[0]:'home';
        // １番目のパラメーターをもとにコントローラークラスインスタンス取得
        $controllerInstance = $this->getControllerInstance($controller);
        if (null == $controllerInstance) {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
        // 2番目のパラメーターをactionとして取得
        $action=(1 < count($urlparams))?$urlparams[1]:'index';
       // アクションメソッドの存在確認
        if (false == method_exists($controllerInstance, $action)) {
          header("HTTP/1.0 404 Not Found");
          exit;
        }

        // 3番目以降はパラメーターなのでその配列として取得
        $actionParams=array_slice($urlparams, 2);

        // コントローラー初期設定
        $controllerInstance->setSystemRoot($this->sysRoot);
        $controllerInstance->setRequest($actionParams);
        $controllerInstance->setControllerAction($controller, $action);
        // 処理実行
        $controllerInstance->run();
    }
    public function getUrlParams()
    {
        // パラメーター取得（末尾の / は削除）
        $urlandquerystring = explode("?", $_SERVER['REQUEST_URI']);
        // クエリ文字列を取り除く
        $urlstring = $urlandquerystring[0];
        // urlの前後についている/を取り除く
        $urlstring = ereg_replace('/?$', '',$urlstring);
        $urlstring = ereg_replace('^/?', '',$urlstring);
        // urlの文字列の中に含まれている/で文字列を分割してcontroller,action,parameterを取得する
        $urlparams = explode("/", $urlstring);
        return $urlparams;
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