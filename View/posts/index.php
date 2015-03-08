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
		<h1>投稿一覧</h1>
		<div class="bs-example" data-example-id="striped-table">
			<table class="table table-striped">
				<thead>
					<tr><th>ID</th><th>user_id</th><th>Title</th><th>Body</th><th>Edit</th><th>Delete</th></tr>
				</thead>
				<tbody>
				<?php foreach ($result['data'] as $row): ?>
					<tr>
						<td><?php print($row['id']); ?></td>
						<td><?php print($row['user_id']); ?></td>
						<td><?php print($row['title']); ?></td>
						<td><?php print($row['body']); ?></td>
						<td>
						<?php
						if (!$isLoggedIn&&$row['user_id']==0) {
							print('<a class="btn btn-primary" href="edit/'.$row['id'].'">編集</a>');
						}elseif($isLoggedIn&&$_SESSION["id"]==$row['user_id']){
							print('<a class="btn btn-primary" href="edit/'.$row['id'].'">編集</a>');
						}else{
							// print('編集');
						}
						?></td>
						<td><?php
						if (!$isLoggedIn&&!$row['user_id']) {
							print('<a class="btn btn-primary delete" data-id="'.$row['id'].'">削除</a>');
						}elseif($isLoggedIn&&$_SESSION["id"]==$row['user_id']){
							print('<a class="btn btn-primary delete" data-id="'.$row['id'].'">削除</a>');
						}else{
							// print('削除');
						}
						?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div><!-- /example -->   
	</div>
		<script>
		$(function(){
			var count=0;
			$('.delete').click(function(e) {
				// alert($(this).data('id'));
				var id=$(this).data('id');
			    $.ajax({
			        dataType:"json",
			        cache:false,
			        haeder:{ "Accept-Encoding":"utf-8"},
			        type:"delete",
			        timeout:5000,
			        url:"/CandlePHP/posts/delete_post",
			        data:{"user_id":<?php echo $user_id ?>,"id":id},
			        error: function(XMLHttpRequest, textStatus, errorThrown){
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
			        	alert(data['message']);
			        	
			        }
			    });
			    return false;
			});
		});
		</script>
</body>
</html>