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
require_once "global.php";
echo "<p>Welcome to the President's House Association website.</p>";
$this_many = date("Y") - FOUNDING_YEAR;
echo "Celebrating $this_many years of excellence.";
?>
</body>
</html>
