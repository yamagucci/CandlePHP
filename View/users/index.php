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
		<h1>ユーザー一覧</h1>
		<div class="bs-example" data-example-id="striped-table">
			<table class="table table-striped">
				<thead>
					<tr><th>ID</th><th>名前</th><th>Password</th><th>Address</th><th>Phone</th></tr>
				</thead>
				<tbody>
						
				<?php foreach ($result['data'] as $row): ?>
					<tr>
						<td><?php print($row['id']); ?></td>
						<td><?php print($row['username']); ?></td>
						<td><?php print($row['password']); ?></td>
						<td><?php print($row['address']); ?></td>
						<td><?php print($row['phone']); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div><!-- /example -->   
	</div>

</body>
</html>