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
echo "<p>Welcome to the President's House Association website.<br>";
$this_many = date("Y") - FOUNDING_YEAR;
echo "Celebrating $this_many years of excellence.<br> Checkout where some of our Alumini are living:</p>";

$img_src = "\"https://maps.googleapis.com/maps/api/staticmap?center=United+States&size=800x800&maptype=roadmap
&markers=color:blue%size:small%|";

$mysqli = new mysqli($host, $username, $password, $database);
if($mysqli->connect_errno)
{
  echo "Connect Error: $mysqli->connect_errno";
  exit(1);
}
else
{
  $query = "select Address_Line_1, City, State from Alumni where Address_Line_1 != 'TODO'";
  if($result = $mysqli->query($query))
  {
    for($i = 0; $i < 40; $i++) // TODO Allow user to view alum locations by class.
    {
      $row = $result->fetch_row();
      $img_src .= $row[0]." ".$row[1]." ".$row[2]."|";
    }
    rtrim($img_src, "|");
    $img_src .= "\">";

    echo "<img src=$img_src";
    echo "</img>";
  }
  else
  {
    echo "Query failed.\n";
  }
}
?>
</body>
</html>
