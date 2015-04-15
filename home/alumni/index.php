<!DOCTYPE html>
<html>
<head>
<link type="text/css" rel="stylesheet" href="/home/style.css"/>
<?php
$name = explode("\\", __DIR__);
echo "<title>PHA | ".ucwords(end($name))."</title>";
?>
</head>
<body>
<a href="/home/"><img src="/home/images/emblem.gif"></a>
<ul>
<a href='/home/'><li>Home</li></a>
<a href='/home/photos/'><li>Photos</li></a>
<a href='/home/actives/'><li>Active Members</li></a>
<a href='/home/alumni'><li>Alumni</li></a>
<a href='/home/donate/'><li>Donate</li></a>
</ul>

<?php
require_once "../global.php";
require_once "../login.php";
if($_GET)
{
  $mysqli = new mysqli($host, $username, $password, $database);
  if($mysqli->connect_errno)
  {
    echo "php error: $mysqli->connect_errno";
  }
  else
  {
    $year = $_GET['year'];
    $query = "select First_Name, Last_Name from Alumni where class = $year;";
    if($result = $mysqli->query($query))
    {
      echo "Class of $year <br>";
      while($data = $result->fetch_array())
      {
        echo "$data[0] $data[1] <br>";
      }
      $result->close();
    }
    else
    {
      echo "Query failed. <br>";
    }
  }
  $mysqli->close();
}

echo "Select a year: <br>";
echo "<form action='index.php'>";
echo "<select name='year'>";
$date = date("Y");
for($i = FOUNDING_YEAR + 1; $i <= $date; $i++)
{
  echo "<option value="."$i".">".$i."</option>";
}
echo "</select>";
echo "<input type='submit' value='year'>";
echo "</form>";
?>
</body>
</html>
