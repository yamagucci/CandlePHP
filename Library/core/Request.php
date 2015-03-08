<?php
class Request
{
    private $_post;
    private $_get;
    private $_input;
    private $_action;
    
    public function __construct($actionParams = null)
    {
        $this->_post = new PostParams();
        $this->_get  = new GetParams();
        $this->_input  = new InputParams();
        $this->_action = $actionParams;
        // var_dump($this->_action);
    }

    // POST変数取得
    public function getPost($key = null)
    {
        if (null == $key) {
            return $this->_post->get();
        }
        if (false == $this->_post->has($key)) {
            return null;
        }
        return $this->_post->get($key);
    }

    // GET変数取得
    public function getQuery($key = null)
    {
        if (null == $key) {
            return $this->_get->get();
        }
        if (false == $this->_get->has($key)) {
            return null;
        }
        return $this->_get->get($key);
    }
    
    // input取得
    public function getInput($key = null)
    {
        if (null == $key) {
            return $this->_input->get();
        }
        if (false == $this->_input->has($key)) {
            return null;
        }
        return $this->_input->get($key);
    }
    public function getAction($key = null)
    {
        if (null === $key) {
            return $this->_action;
        }
        if ($key >= count($this->_action)) {
            return null;
        }
        $params=$this->_action;
        return $params[$key];
    }
}

?>