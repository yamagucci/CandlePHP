<?php
class UsersController extends AppController
{ 
    protected $uses = array('User'); 
    protected $User;
    protected function beforeAction()
    {
        $this->User=new User();
    }
    protected function afterAction()
    {
        $this->User=null;
    }

    public function index()
    {
        $posts=$this->User->getAll();
        $result = array('data' => $posts);
        $this->set('result',$result);
    }

    
    public function signin()
    {

    }
    public function signin_post()
    {
        header('Content-type: application/json');
        if($this->method!='GET')
        {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'REQUEST_METHODが違います'
            ));
        }
        $data=$this->request->getQuery();

        if(empty($data['username'])||empty($data['password'])) {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'必要な引数が空になっています'
            ));
        }
        $params = array(
            'username' =>$data['username'],
            'password'=>$data['password']
        );

        $res=$this->User->isUser($params);
        if ($res==null) {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'usernameまたはpasswordが違います'
            ));
        }
        session_start();
        $_SESSION["id"]=$res['id'];
        $_SESSION["username"]=$res['username'];
        $_SESSION["password"]=$res['password'];
        session_write_close();

        $this->returnResponse(array(
            'error' =>false,
            'message'=>'ログインしました',
            'data'=>$res
        ));
    }
    public function signup()
    {
        
    }
    public function signup_post()
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

        if(empty($data['username'])||empty($data['password'])||empty($data['address'])||empty($data['phone']))
        {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'必要な引数が空になっています'
            ));
        }

        if (!$this->User->add($data)) {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'failed'
            ));
        }

        $params = array(
            'username' =>$data['username'],
            'password'=>$data['password']
        );
        

        $res=$User->isUser($params);

        if ($res==null) {
            $this->returnResponse(array(
                'error' =>true,
                'message'=>'usernameまたはpasswordが違います'
            ));
        }
        session_start();
        $_SESSION["id"]=$res['id'];
        $_SESSION["username"]=$res['username'];
        $_SESSION["password"]=$res['password'];
        session_write_close();

        $this->returnResponse(array(
            'error' =>false,
            'message'=>'新規登録しました',
            'data'=>$res
        ));

    }
    public function signout()
    {
        header('Content-type: application/json');
        session_start();
        session_destroy();
        session_write_close();
        $this->returnResponse(array(
            'error' =>false,
            'message'=>'ログアウトしました。'
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

        if (!$this->User->deleteById($data['id'])) {
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
    
    // public function edit()
    // {
    //     $id=$this->request->getAction(0);
    //     $res=$this->User->getById($id);
    //     $result = array('data' =>$res );
    //     $this->set('result',$result);
    // }
    // public function edit_post()
    // {
    //     header('Content-type: application/json');
    //     if($this->method!='PUT'){
    //         $this->returnResponse(array(
    //             'error' =>true,
    //             'message'=>'REQUEST_METHODが違います'
    //         ));
    //     }
    //     $data=$this->request->getInput();

    //     if(empty($data['id'])||empty($data['username'])||empty($data['password'])){
    //         $this->returnResponse(array(
    //             'error' =>true,
    //             'message'=>'必要な引数が空になっています'
    //         ));
    //     }
    //     $res=$this->User->editById($data,$data['id']);
    //     $this->returnResponse(array(
    //         'data' => $res
    //     ));
    // }
}