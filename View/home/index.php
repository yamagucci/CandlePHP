<<<<<<< HEAD
<!--
$this->startと$this->end()ではさまれた部分はテンプレートと呼ばれるHTMLのテンプレートにブロックという形式で渡されます。
以下の場合はtitleというブロックとして捕捉され、テンプレートに渡されます。
-->
<?php $this->start('title'); ?>
<title>CandlePHP</title>
<?php $this->end(); ?>

<!-- 何もはさまれない部分はcontentというブロックとして捕捉されます。 -->
<h1><?php echo $message;?></h1>
=======
<html>
<head>
    <title>CandlePHP</title>
</head>

<body>

	<h1><?php echo $message;?></h1>
    
</body>
</html>
>>>>>>> 1ca33847e3f78b5d64fabb97da988107b761a389
