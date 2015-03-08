<?php
class PostsController extends AppController
{ 
    protected $uses = array('Post'); 
    protected $Post;
    protected function beforeAction()
    {
        $this->Post=new Post();
    }
    protected function afterAction()
    {
        $this->Post=null;
    }

    public function index()
    {
        $posts=$this->Post->getAll();
        $result = array('data' => $posts);
        $this->set('result',$result);
    }
    public function index_post()
    {
        header('Content-type: application/json');
        if ($this->method!='GET') {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'REQUEST_METHODが違います'
            ));
        }
        $posts=$this->Post->getAll();
        $this->returnResponse(array(
            'error' =>false,
            'data'=>$posts
        ));
    }
    public function view($param_1)
    {
        $res=$this->Post->getById($id);
        $result = array('data' =>$res );
        $this->set('result',$result);
    }
    public function edit()
    {
        $id=$this->request->getAction(0);
        $res=$this->Post->getById($id);
        $result = array('data' =>$res );
        $this->set('result',$result);
    }
    public function edit_post()
    {
        header('Content-type: application/json');
        if($this->method!='PUT'){
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'REQUEST_METHODが違います'
            ));
        }
        $data=$this->request->getInput();

        if(empty($data['title'])||empty($data['body'])||empty($data['id'])){
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'必要な引数が空になっています'
            ));
        }
        $res=$this->Post->editById($data,$data['id']);
        $this->returnResponse(array(
            'message' => $res
        ));
    }
    public function add()
    {

    }
    public function add_post()
    {
        header('Content-type: application/json');
        if($this->method!='POST')
        {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'REQUEST_METHODが違います'
            ));
        }
        $data=$this->request->getPost();

        if(empty($data['title'])||empty($data['body']))
        {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'必要な引数が空になっています'
            ));
        }

        if (!$this->Post->add($data)) {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'failed'
            ));
        }
        $this->returnResponse(array(
            'error' =>false,
            'message'=>'success'
        ));
    }

    public function delete_post()
    {
        header('Content-type: application/json');
        if($this->method!='DELETE')
        {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'REQUEST_METHODが違います'
            ));
        }
        $data=$this->request->getInput();

        if(empty($data['id']))
        {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'必要な引数が空になっています'
            ));
        }

        if (!$this->Post->deleteById($data['id'])) {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'failed'
            ));
        }
        $this->returnResponse(array(
            'error' =>false,
            'message'=>'success'
        ));
    }
    

}

?>