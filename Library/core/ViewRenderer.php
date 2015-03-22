<?php

class ViewRenderer
{
    protected $systemRoot;
    protected $view;
    protected $data = array();
    protected $_blocks = array();
    protected $_active = array();
    protected $layout;

    // コンストラクタ
    public function __construct($data,$view,$layout)
    {
        $this->data=$data;
        $this->view=$view;
        $this->layout=$layout;
    }
    public function setSystemRoot($path)
    {
        $this->systemRoot = $path;
    }
    public function render()
    {
        foreach ($this->data as $key => $value) {
            $$key=$value;
        }
        $this->start('content');
        require_once $this->view;
        $this->end();
        require_once $this->layout;
    }

/**
 * Start capturing output for a 'block'
 *
 * You can end capturing blocks using View::end(). Blocks can be output
 * using View::fetch();
 *
 * @param string $name The name of the block to capture for.
 * @throws CakeException When starting a block twice
 * @return void
 */
    public function start($name) {
        if (in_array($name, $this->active)) {
            throw new CandleException(__("A view block with the name '%s' is already/still open.", $name));
        }
        $this->_active[] = $name;
        ob_start();
    }

/**
 * End a capturing block. The compliment to ViewBlock::start()
 *
 * @return void
 * @see ViewBlock::start()
 */
    public function end() {
        if (!empty($this->_active)) {
            $active = end($this->_active);
            $content = ob_get_clean();
            if (!isset($this->_blocks[$active])) {
                $this->_blocks[$active] = '';
            }
            $this->_blocks[$active] .= $content;
            array_pop($this->_active);
        }
    }
    public function fetch($name, $default = '') {
        if (!isset($this->_blocks[$name])) {
            return $default;
        }
        return $this->_blocks[$name];
    }

}
?>