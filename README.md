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
http://www.example.comというurlにアクセスするとデフォルトのControllerとActionがよばれるようになっています。

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
CREATE TABLE posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    body VARCHAR(255)
);

テスト用に記事をいくつか入れておきます
INSERT INTO posts (title,body)VALUES ('タイトル１', '記事の本文です。');
INSERT INTO posts (title,body)VALUES ('タイトル２', 'これが本文です。');
INSERT INTO posts (title,body)VALUES ('タイトル３', 'これは記事の本文です。');


### Modelの作成

データベースを利用するときにはModelを作成しなければなりません。
次のように作成します。

/Model/Post.php
<?php
class Post extends AppModel
{
    protected $name = 'posts';
}
?>

AppModelを継承し、利用するデータベース名(ここではposts)
