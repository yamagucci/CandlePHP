# CandlePHP
CandlePHP: The Scalable Development Framework for PHP - Official Repository

## インストール方法
CandlePHPをセットアップする簡単な方法です。
この例では CakePHP をインストールし、 http://www.example.com/ でアクセスできるようにする方法を説明します。 
サーバーにはApache（2.2.15以降）,PHP（5.5以降）,Mysql（5.6以降）が入っていると仮定し、
ドキュメントルートは /var/www/html であると仮定します。
php-mbstring,php-mysql,php-pdoなどの設定は必要になり次第適宜設定してください。

CandlePHP のアーカイブを /var/www/html に展開してください。
ファイルシステム上の開発用の設定は次のようになります:

/var/www/html/
    CandlePHP/
        Controller/
        Library/
        Model/
        View/
        webroot/
        README

次にhttpd.confの設定をしてください。
DocumentRootをCandlePHPフォルダの中のwebrootというディレクトリに指定してください。
またwebrootディレクトリ内では必ずindex.phpにアクセスさせるように設定します。

sudo vi /etc/httpd/conf/httpd.conf
```
DocumentRoot "/var/www/html/CandlePHP/webroot"

<Directory /var/www/html/CandlePHP/webroot>
    Options FollowSymLinks
    AllowOverride All
	RewriteEngine on
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteRule . index.php [L]
</Directory>
```

するとhttp://www.example.com/hoge1/hoge2のようなurlでアクセスしても
必ずwebrootのindex.phpにアクセスがいくようになります。

http://www.example.comにアクセスして、
Hello CandlePHP !!
が表示されていればインストールは完了です。


## CandlePHPのフォルダ構造
CandlePHP/
    Controller/
    Library/
    Model/
    View/
    webroot/

- webroot
webroot/
    css/
    image/
    js/
    dispatch.php
    index.php

webrootはウェブに公開される部分です。
ウェブに用いるcss,image,jsの各種ファイルはこのディレクトリ内の指定されたフォルダの中に入れます。
index.phpは基本的にはあらゆるurlリクエストの初めに呼ばれるファイルです。
それはなぜなら初めの初期設定でhttpd.confでindex.phpが呼ばれるように設定したからです。
index.phpはリクエストされてきたurlに応じて呼ぶファイルを切り替えてウェブページを表示します。
具体的にはurlからcontroller名とaction名を判断し、指定されたController（クラス）の指定されたAction（メソッド、あるいは関数といってもよいでしょう）が呼ばれます。
dispatch.phpはそのリクエストの振り分けをするクラスが実装されていて、index.php内で実行されます。

- Model
Model/
    AppModel.php
    .
    .

Modelはデータベースと通信を行い、データを取得、保存、更新、削除する役割があります。
ModelはControllerに取得したデータを渡すことや、データベースとのやりとりが成功したかどうかを伝えることができます。
Modelの基本的な機能はAppModel.phpというクラスに書いてあるので、実際に使用する際にはAppModel.phpを継承したファイルをModelディレクトリの下（AppModel.phpと同じディレクトリ）に作成していきます。
Modelは一つにつき一つのデータベースのテーブルを操作することができます。
そのため、利用するデータベースの数だけModelを作成する必要があります。


- Controller
Controller/
    AppController.php
    .
    .

ControllerはModelから取得してきたデータをViewに受け渡す役割があります。
Controllerの基本的な機能はAppController.phpというクラスに書いてあるので、実際に使用する際にはAppController.phpを継承したファイルをControllerディレクトリの下（AppController.phpと同じディレクトリ）に作成していきます。
Controllerは複数のモデルとやりとりをすることができるので一つでもよいですが、基本的にはモデルごとに作成したほうが便利です。

- View
View/
    home/
        index.php
        .
        .
    .
    .

ViewはControllerから渡されたデータをもとにウェブページとして表示するHTMLを生成するページです。
controller名ごとにフォルダを作りその中にaction名.phpというファイルを作成していきます。
http://www.example.com
というurlにアクセスするとデフォルトのControllerとActionがよばれるようになっています。

具体的には次のようによばれます。
HomeControllerというControllerのindexというActionがよばれる。
/View/home/にあるindex.phpというViewがよばれる。

HomeController.phpと/View/home/index.phpを見てみると
Controller側で$this->set()を用いて'Hello CandlePHP !!'という文字列を
View側に＄messageという変数で渡していることがわかります。

Controller側
$this->set('message','Hello CandlePHP !!');
View側
<h1><?php echo $message;?></h1>


## データベース設定
データベースの設定はwebrootのindex.phpにて行います。

// データベース接続情報設定
$connInfo = array(
    'host'     => 'localhost',
    'dbname'   => 'sampledb',
    'username'   => 'root',
    'password' => 'root'
);

データベースの設定は何もModelを利用していないときにはデータベースとやりとりをしないので接続エラーを表示することはありません。ではデータベースを利用してデータを表示してみましょう。

記事（Post）を表示するページを作成していきます。

### テーブルの作成
まずテーブルを作成しましょう。　データベースを作成していない場合は
CREATE DATABASE sampledb DEFAULT CHARACTER SET utf8;
として作成しましょう。

postsテーブルを作成します。
テーブルの命名には特に制限はないですが、小文字の複数形がよいでしょう。
CREATE TABLE posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    body VARCHAR(255)
);

テスト用に記事をいくつか入れておきます
INSERT INTO posts (title,body)VALUES ('タイトル１', '記事の本文です。');
INSERT INTO posts (title,body)VALUES ('タイトル２', 'これが本文です。');
INSERT INTO posts (title,body)VALUES ('タイトル３', 'これは記事の本文です。');

とりあえずコマンドで
use sampledb;
select *from posts;
としてテスト用記事の一覧が保湯時されているか確認してみましょう。
これでテーブルの作成は完了です。

### Modelの作成

データベースを利用するときにはModelを作成しなければなりません。
次のように作成します。

<!-- /Model/Post.php -->
<?php
class Post extends AppModel
{
    protected $name = 'posts';
}
?>

AppModelを継承し、利用するデータベース名(ここではposts)を$nameに設定します。
Modelの名前は特に制約はありませんが、基本的には最初だけ大文字の単数形の単語がよいでしょう。

### Controllerの作成

ControllerからModelにアクセスしてデータを持って来てみましょう。
モデルを利用する際にはまず次の設定を行います。
1.$usesに使いたいモデルを配列の形にして代入する。
2.モデルの名前（モデルのクラス名）の変数を作る。
3.beforeAction()でモデルを生成する。
4.afterAction()でモデルを破棄する。


試しにPostモデルで設定をしてみましょう。
次のように設定します。
<!-- /Controller/PostsController.php -->
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
?>

beforeAction()とafterAction()については後ほど説明します。

### Actionの実装

今回はデータベースのpostsテーブルにある記事を全件取得するというメソッドを実装していくことにしましょう。メソッド名をindexとしましょう。
Controller名がPostsControllerでAction名がindexなのでブラウザで
http://www.example.com/posts/index
というurlにアクセスすると呼ぶことができます。
Action名が設定されていない場合はデフォルトでindexメソッドが呼ばれますので、
http://www.example.com/posts
でも同じページが表示されるようになるかと思います。

ではまずindexメソッドを実装済みのPostsController.phpを見てみましょう。

<!-- /Controller/PostsController.php -->
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
        $this->set('result',$posts);
    }
?>

ControllerではAction名のメソッドを必ずよびだそうとします。
そのため、何も操作を行わない場合でも
public function index(){}
だけは実装してください。

Action名のメソッドを呼び出す前にbeforeAction()
Action名のメソッドを呼び出すした後にafterAction()
が呼ばれます。
そのため、Action名のメソッドでモデルを利用する前のbeforeAction()でモデルを生成し、
Action名のメソッドでモデルを利用した後のafterAction()でモデルを破棄する必要があるので、
上述のような設定をしたということです。

indexメソッドの中身を見ていきましょう。
利用したいモデルは$this->（モデル名）でアクセスできます。
すべてのモデルには基本的ないくつかのクエリがメソッドとしてあらかじめ用意されています。
それはAppModel.phpに記述されています。

public function add($data)
一件データを追加（保存）する
public function getAll()
データを全件取得する
public function getById($id)
指定したidのデータを一件取得する
public function deleteById($id)
指定したidのデータを一件削除する
public function editById($data,$id)
指定したidのデータを$dataに更新する

今回は全件表示させるのでgetAll()を使います。
$this->Post->getAll()とすると連想配列の形のレコードが配列となって取得できます。
$postsにはそれが代入されています。
これをViewに渡すにはsetというメソッドを呼ぶことでできます。
これはすべてのControllerで使用することのできるメソッドで、
AppController.phpに実装されています。

protected function set($key,$value)
$valueを$keyという変数名でViewに渡す。

よって、この場合はViewページ全件の記事の配列を$resultという変数で渡していることになります。
$this->set('result',$posts);

### Viewの実装

最後にControllerから渡された$resultという変数の情報を表示してみましょう。
foreachで繰り返し表示するような処理のコードを書いてみると次のようになります。

<!-- /View/posts/index.php -->
<html>
<head>
    <title>CandlePHP</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Body</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row): ?>
            <tr>
                <td><?php print($row['id']); ?></td>
                <td><?php print($row['title']); ?></td>
                <td><?php print($row['body']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>

この時点で、ブラウザから http://www.example.com/posts/index を開いてみてください。 タイトルと投稿内容のテーブル一覧がまとめられているビューが表示されるはずです。

これで基本的なチュートリアルは終わりますが、このまま読み進めていきたい場合は
/Library/documents
に書いてありますので参照していただけるとよいと思います。

