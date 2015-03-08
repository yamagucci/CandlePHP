# 内部 API Document

## TYModel::__construct()

初期化メソッド
### parameter
no parameter
### result (void)


## TYModel::initDb()

データベースの初期設定をするメソッド
接続情報からDBとの接続を確立して、
エンコードをUTF8にする処理を行う
### parameter
no parameter
### result (void)


## TYModel::setConnectionInfo($connInfo)

データベースの接続情報を設定する
### parameter
- $connInfo (array)
	- dsn
	- username
	- password
### result (void)


## TYModel::select($params=null)

パラメーターの条件を満たすレコードをデータベースから取得する
### parameter
- $params (array)
	- データベースの任意のキー
### result (array)



## TYModel::delete($params = null)

パラメーターの条件を満たすレコードを削除する
### parameter
- $params (array)
	- データベースの任意のキー
### result (bool)


## TYModel::insert($data)

データをデータベースに挿入する
### parameter
- $data (array)
	- データベースの任意のキー
### result (bool)

## TYModel::update($data,$params)

準備中


## TYModel::whereStringWithParams($params=null,$option=true)

パラメーターからsql文のwhere文の部分を生成する
### parameter
- $params (array)
	- データベースの任意のキー
### result (string)



## TYModel::throwSQL($sql,$params=null)

パラメーターとsql文からデータベースに実際sqlを投げて実行する
### parameter
- $sql (string)
- $params (array)
	- データベースの任意のキー
### result (void)


## TYModel::bindParams($params=null)

パラメーターからsql文の文字に変数を割り当てていく
### parameter
- $params (array)
	- データベースの任意のキー
### result (void)



#サブクラスのメソッド

## Post::getAll()
## Post::getById($id)
## Post::add($data)
## Post::editById($data,$id)
## Post::deleteById($id)

## User::getAll()
## User::getById($id)
## User::add($data)
## User::deleteById($id)
## User::isUser($params)
