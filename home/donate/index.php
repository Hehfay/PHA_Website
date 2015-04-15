<!doctype html>
<html>
<head>
<link type='text/css' rel='stylesheet' href='/home/style.css'/>
<?php
$name = explode("\\", __DIR__);
echo "<title>PHA | ".ucwords(end($name))."</title>";
?>
</head>
<body>
<a href='/home/'><img src='/home/images/emblem.gif'></a>
<ul>
<a href='/home/'><li>Home</li></a>
<a href='/home/photos/'><li>Photos</li></a>
<a href='/home/actives/'><li>Active Members</li></a>
<a href='/home/alumni/'><li>Alumni</li></a>
<a href='/home/donate/'><li>Donate</li></a>
</ul>
<?php
$name = explode("\\", __DIR__);
echo ucwords(end($name))."<br>";
echo "<pre>";
echo <<< _END
  An interface for active members to pay for dues, shirts, etc., and 
  a way for alumni to fund house projects.
_END;
echo "</pre>";
?>
</body>
</html>
