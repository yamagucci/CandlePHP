<?php
// session_start();
//         // $isLoggedIn=isset($_SESSION["username"]);
// $_SESSION["username"]=$result['username'];
// $_SESSION["password"]=$result['password'];
?>
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
		<h1>Sign Up</h1>
		<form>
			<div class="form-group">
				<label>Username</label>
				<input type="text" class="form-control" name="username">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control" name="password">
			</div>
			<div class="form-group">
				<label>Address</label>
				<input type="text" class="form-control" name="address">
			</div>
			<div class="form-group">
				<label>Phone</label>
				<input type="text" class="form-control" name="phone">
			</div>
			<button class="submit" class="btn btn-default">Submit</button>
		</form>       
	</div>
	<script>
	$(function(){
		var count=0;
		$('.submit').click(function(e) {
			$(this).html('通信中');
		    $.ajax({
		        dataType:"json",
		        cache:false,
		        haeder:{ "Accept-Encoding":"utf-8"},
		        type:"post",
		        timeout:5000,
		        url:"/CandlePHP/users/signup_post",
		        data:$(this).closest("form").serialize(),
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

        			// if (statusText=='timeout') {
        			// 	if (count==0) {
        			// 		count=1;
        			// 		$('.submit').click();
        			// 	}else{
        			// 		alert(msg);
        			// 	}
        			// 	// console.log('timeout');
        			// }
           		},
		        success:function (data, textStatus) {
		        	$(this).html('Submit');
		        	alert(data['message']);
		        	// if (data['error']) {
		        	// 	alert(data['message']);
		        	// }else{
		        	// 	alert(data['result']);
		        	// }
		        	
		        }
		    });
		    return false;
		});
	});
	</script>
</body>
</html>