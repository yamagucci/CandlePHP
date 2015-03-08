# 外部 API Document


## GET posts/index

記事を全件取得し、その結果を返す。
### parameter
no parameter
### result (JSON)
- data (array)


## POST posts/add

記事を投稿し、その結果をメッセージつきで返す。
### parameter
- title (string)(required)
- body (string)(required)
- user_id (string)(required)
### result (JSON)
- error (bool)
- message (string)


## DELETE posts/delete

記事を削除し、その結果をメッセージつきで返す。
### parameter
- id (int)(required)
- user_id (int)(required)
### result (JSON)
- error (bool)
- message (string)


## UPDATE posts/edit

記事を更新し、その結果をメッセージつきで返す。
### parameter
- id (int)(required)
- title (string)(required)
- body (string)(required)
### result (JSON)
- error (bool)
- message (string)


## GET users/index

ユーザーを全件取得し、その結果を返す。
### parameter
no parameter
### result (JSON)
- data (array)


## DELETE users/delete

ユーザーを削除し、その結果をメッセージつきで返す。
### parameter
- id (int)(required)
- username (string)(required)
- password (string)(required)
### result (JSON)
- error (bool)
- message (string)


## POST users/signup

ユーザーを新規登録し、その結果とユーザー情報をメッセージつきで返す。
### parameter
- username (string)(required)
- password (string)(required)
- address (string)(required)
- phone (string)(required)
### result (JSON)
- error (bool)
- message (string)
- data (array)


## POST users/signin

ユーザーでログインを行い、その結果とユーザー情報をメッセージつきで返す。
### parameter
- username (string)(required)
- password (string)(required)
### result (JSON)
- error (bool)
- message (string)
- data (array)


## UPDATE users/edit

ユーザー情報を更新し、その結果をメッセージつきで返す。
### parameter
- username (string)(required)
- password (string)(required)
- address (string)(required)
- phone (string)(required)
### result (JSON)
- error (bool)
- message (string)


