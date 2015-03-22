<?php

abstract class AppController
{
    protected $systemRoot;
    protected $controller;
    protected $action;
    protected $request = array();
    protected $response = array();
    protected $view_path;
    protected $view_data = array();
    protected $uses = array();
    protected $components = array();
    protected $instances = array();
    protected $method;
    protected $layout='default';

    // コンストラクタ
    public function __construct()
    {
        $this->response = array();
        $this->method = $_SERVER['REQUEST_METHOD'];
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
        // コンポーネンツの読み込み
        $this->loadComponents();
        // モデルの読み込み
        $this->loadModels();
        // 共通前処理
        $this->beforeAction();
        // アクションメソッド
        $this->callAction();
        // 共通後処理
        $this->afterAction();
        // 読み込んだモデルとコンポーネンツの破棄
        $this->destroyInstances();
        // 表示
        $this->render();
    }
    public function loadComponents()
    {
        foreach ($this->components as $componentName) {
            $className = sprintf('%sComponent',$componentName);
            $fileName = sprintf('%s/Library/Component/%s.php', $this->systemRoot,$className);
            $this->setInstance($fileName,$componentName,$className);
        }
    }
    // モデルクラスの読み込み
    protected function loadModels()
    {
        foreach ($this->uses as $className) {
            $fileName = sprintf('%s/Model/%s.php', $this->systemRoot, $className);
            $this->setInstance($fileName,$className,$className);
        }
    }
    // コンポーネントとモデルの読み込み
    protected function setInstance($fileName,$key,$className)
    {
        if (false == file_exists($fileName)){
            continue;
        }
        require_once $fileName;
        if (false == class_exists($className)){
            continue;   
        }
        $this->__set($key,new $className());
    }


    // 共通前処理（オーバーライド前提）
    protected function beforeAction()
    {
        
    }
    public function callAction()
    {
        $method=$this->action;
        $params=$this->request->getAction();
        switch (count($params)) {
            case 0:
                return $this->{$method}();
            case 1:
                return $this->{$method}($params[0]);
            case 2:
                return $this->{$method}($params[0], $params[1]);
            case 3:
                return $this->{$method}($params[0], $params[1], $params[2]);
            case 4:
                return $this->{$method}($params[0], $params[1], $params[2], $params[3]);
            case 5:
                return $this->{$method}($params[0], $params[1], $params[2], $params[3], $params[4]);
            default:
                return call_user_func_array(array(&$this, $method), $params);
        }
    }
    // 共通後処理（オーバーライド前提）
    protected function afterAction()
    {
        
    }
    public function destroyInstances()
    {
        foreach ($this->instances as $key => $value ) {
            unset($this->instances[$key]);
        }
    }
    // ビューに渡すデータをビューに渡して表示
    private function render()
    {
        $viewRenderer=new ViewRenderer($this->view_data,$this->view_path,$this->getRenderLayoutPath());
        $viewRenderer->setSystemRoot($this->systemRoot);
        $viewRenderer->render();
    }
    // ビューに渡すデータを設定
    protected function set($key,$value)
    {
        $this->view_data[$key]=$value;
    }
    // ビューのパスの設定
    protected function setRenderViewPath($action)
    {
        $this->view_path = sprintf(
            '%s/View/%s/%s.php',
            $this->systemRoot,
            $this->controller,
            $action
        );
    }
    // ビューのパスの設定
    protected function getRenderLayoutPath()
    {
        return sprintf(
            '%s/View/Layouts/%s.php',
            $this->systemRoot,
            $this->layout
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
    public function __set($name, $value)
    {
        if (in_array($name,$this->uses)) {
            $this->instances[$name] = $value;
        }
        if (in_array($name,$this->components)) {
            $this->instances[$name] = $value;
        }
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->instances)) {
            return $this->instances[$name];
        }
        return null;
    }
}
?>