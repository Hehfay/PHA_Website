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
require_once "../login.php";
$name = explode("\\", __DIR__);
echo ucwords(end($name)).":"."<br>";
$mysqli = new mysqli($host, $username, $password, $database);
if($mysqli->connect_errno)
{
  echo "php error: $mysqli->connect_errno";
}
else
{
  $query = "select First_Name, Last_Name from Alumni where Old_Business=0;";
  if($result = $mysqli->query($query))
  {
    while($data = $result->fetch_array())
    {
      echo "$data[0] $data[1] <br>";
    }
    $result->close();
  }
  else
  {
    echo "Query failed <br>";
  }
  $mysqli->close();
}

?>
</body>
</html>
