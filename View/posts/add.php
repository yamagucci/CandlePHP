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
		<h1>新規投稿</h1>
		<form>
			<div class="form-group">
				<label>Title</label>
				<input type="text" class="form-control" name="title">
			</div>
			<div class="form-group">
				<label>Body</label>
				<input type="text" class="form-control" name="body">
			</div>
			<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
			<button class="submit" class="btn btn-default">投稿</button>
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
			        url:"/CandlePHP/posts/add_post",
			        data:$(this).closest("form").serialize(),
			        error: function(XMLHttpRequest, textStatus, errorThrown){
			        	$('.submit').html('Submit');
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
			        	$('.submit').html('Submit');
			        	alert(data['message']);
			        	
			        }
			    });
			    return false;
			});
		});
		</script>
</body>
</html>
