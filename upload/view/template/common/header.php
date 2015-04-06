<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title; ?></title>

<link rel="shortcut icon" href="<?php echo HTTP_SERVER; ?>favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo HTTP_SERVER; ?>favicon.ico" type="image/x-icon">

<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>

</head>

<body>
<div class="container">
<a href="index.php?route=common/home"><h4>Cito PHP Homepage</h4></a>
