<!DOCTYPE html>
<html>
<head>
	<title>Parser</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
	<a class='w-100 btn btn-lg btn-primary' role='button' href='index.php'>Главная страница</a><br><br>
<?
if (isset($_POST['link'])) { $link = $_POST['link'];
if ($link == '') { unset($link);} }

$fp = file_get_contents($link);

preg_match_all('/\b([a-z0-9._-]+@[a-z0-9.-]+\.[a-z]+)\b/i',$fp,$regs);

preg_match_all('/<h[0-9].*?>(.*?)<\/h[0-9]>/', $fp, $regs2);

preg_match_all('/[\"]{1}((http|https).*?)[\"]{1}/i', $fp, $regs3);

$array = array_chunk($regs3[1], 1);

$array2 = array_chunk($regs2[1], 1);

$array3 = array_chunk($regs[0], 1);
?>
<div class="container">
  <div class="row">
    <div class="col-sm">
<table class="table table-dark table-sm">
	<th>Links</th>
	<?php foreach ($array as $items): ?>
	<tr>
		<?php foreach ($items as $row): ?>
		<td><?php echo $row; ?></td>
		<?php endforeach; ?>
	</tr>
	<?php endforeach; ?>
</table>
</div>

<div class="col-sm">
<table class="table table-dark table-sm">
	<th>Headers</th>
	<?php foreach ($array2 as $items): ?>
	<tr>
		<?php foreach ($items as $row): ?>
		<td><?php echo $row; ?></td>
		<?php endforeach; ?>
	</tr>
	<?php endforeach; ?>
</table>
</div>

<div class="col-sm">
<table class="table table-dark table-sm">
	<th>Emails</th>
	<?php foreach ($array3 as $items): ?>
	<tr>
		<?php foreach ($items as $row): ?>
		<td><?php echo $row; ?></td>
		<?php endforeach; ?>
	</tr>
	<?php endforeach; ?>
</table>
</div></div></div>
<?php
$filename = 'mails.txt';

// Запись.
$data = serialize($regs[0]);      // PHP формат сохраняемого значения.
//$data = json_encode($bookshelf);  // JSON формат сохраняемого значения.
file_put_contents($filename, $data,FILE_APPEND);
?>
</body>
</html>