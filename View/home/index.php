<html>
<head>
    <title>CRUD</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    
</head>

<body>
	<a class="btn btn-default" href="/CandlePHP/">トップ</a>
	<span><?php echo $username;?></span>
    
    <div class="container">
    <li><a href="/CandlePHP/posts/index">投稿一覧</a></li>
    <li><a href="/CandlePHP/posts/add">New Post</a></li>
<?php if ($isLoggedIn): ?>
    
    <li><a class="signout">Sign Out</a></li>
<?php else: ?>
    <li><a href="/CandlePHP/users/signup">Sign Up</a></li>
    <li><a href="/CandlePHP/users/signin">Sign In</a></li>
<?php endif; ?>        
    </div>


<script>
        $(function(){
            var count=0;
            $('.signout').click(function(e) {
                $.ajax({
                    dataType:"json",
                    cache:false,
                    haeder:{ "Accept-Encoding":"utf-8"},
                    type:"get",
                    timeout:5000,
                    url:"/CandlePHP/users/signout",
                    error: function(XMLHttpRequest, textStatus, errorThrown){
                        $(this).html('Submit');
                        msg="--- Error Status ---"+"\n";
                        msg=msg+"status:"+XMLHttpRequest.status+"\n";
                        if (XMLHttpRequest.statusText) {
                            msg=msg+"statusText:"+XMLHttpRequest.statusText+"\n";
                        };
                        
                        msg=msg+"textStatus:"+textStatus+"\n";
                        msg=msg+"errorThrown:"+errorThrown+"\n";
                        alert(msg);
                    },
                    success:function (data, textStatus) {
                        $(this).html('Submit');
                        alert(data['message']);
                    }
                });
                return false;
            });
        });
        </script>
</body>
</html>