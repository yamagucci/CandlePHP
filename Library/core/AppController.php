<?php

abstract class AppController
{
    protected $systemRoot;
    protected $controller;
    protected $action;
    protected $request;
    protected $response;
    protected $view_path;
    protected $view_data;
    protected $uses = array();
    protected $method;
    protected $Auth;
    // $actionParams

    // コンストラクタ
    public function __construct()
    {
        $this->response = array();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->Auth = $this->initAuth();
    }
    public function initAuth()
    {
        session_start();
        $isLoggedIn=isset($_SESSION["username"]);
        $this->set('isLoggedIn',$isLoggedIn);
        $user_id=($isLoggedIn)?$_SESSION["id"]:0;
        $this->set('user_id',$user_id);
        $username=($isLoggedIn)?$_SESSION["username"]:'NO NAME';
        $this->set('username',$username);
        session_write_close();
    } 
    // システムのルートディレクトリパスを設定
    public function setSystemRoot($path)
    {
        $this->systemRoot = $path;
    } 
    public function setRequest($actionParams)
    {
        $this->request = new Request($actionParams);
    }    
    // コントローラーとアクションの設定
    public function setControllerAction($controller, $action)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->view_path = sprintf('%s/View/%s/%s.php',$this->systemRoot,$controller,$action);
    }
    // 処理実行
    public function run()
    {
        try {
            // モデルの読み込み
            $this->setModels();
            // 共通前処理
            $this->beforeAction();
            // アクションメソッド
            $methodName = $this->action;
            $this->$methodName(); 
            // 共通後処理
            $this->afterAction();
            // 表示
            $this->render();
        
        } catch (Exception $e) {
            // ログ出力等の処理を記述
        }
    }
    // モデルクラスの読み込み
    protected function setModels()
    {
        foreach ($this->uses as $className) {
            $classFile = sprintf('%s/Model/%s.php', $this->systemRoot, $className);
            if (false == file_exists($classFile)){
                continue;
            }
            require_once $classFile;
            // if (false == class_exists($className)){
            //     continue;   
            // }
            // $this->set($className,new $className());
        }
    }
    // 共通前処理（オーバーライド前提）
    protected function beforeAction()
    {
        
    }
    // 共通後処理（オーバーライド前提）
    protected function afterAction()
    {
        
    }
    // ビューに渡すデータをビューに渡して表示
    private function render()
    {
        foreach ($this->view_data as $key => $value) {
            $$key=$value;
        }
        require_once $this->view_path;
    }
    // ビューに渡すデータを設定
    protected function set($key,$value)
    {
        $this->view_data[$key]=$value;
    }
    // ビューのパスの設定
    protected function setRenderView($action)
    {
        $this->view_path = sprintf(
            '%s/View/%s/%s.php',
            $this->systemRoot,
            $this->controller,
            $action
        );
    }
    // Jsonのレスポンスを返す
    protected function returnResponse($params=null)
    {
        if (null!=$params) {
            $this->setResponse($params);
        }
        $this->afterAction();
        echo json_encode($this->response);
        exit();
    }
    // レスポンスに渡すデータを設定
    protected function setResponse($params=null)
    {
        if (!is_array($params)) {
            return;
        }
        foreach ($params as $key => $value) {
            $this->response[$key]=$value;
        }
    }
}
?>