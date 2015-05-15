<?php
require_once "global_vars.php";
require_once "sanitation.php";
class Student
{
  protected $mysqli;

  protected $data = array(
      'username' => ''
    , 'passcode' => ''
    , 'first_name' => ''
    , 'middle_name' => ''
    , 'last_name' => ''
    , 'email' => ''
    , 'address_line_1' => ''
    , 'address_line_2' => ''
    , 'city' => ''
    , 'state' => ''
    , 'zip' => ''
    , 'home_phone' => ''
    , 'cell_phone' => ''
    , 'num_courses_enrolled' => '0'
    );

  function __construct($host, $username, $password, $database)
  {
    $this->mysqli = new mysqli($host, $username, $password, $database);
    if($this->mysqli->connect_errno)
    {
      echo "Connection error: ".$this->mysqli->connect_errno;
    }
  }

  function __destruct()
  {
    $this->mysqli->close();
  }

  public function set_field($key, $value)
  {
    $value = sanitize_mysql($this->mysqli, $value);
    $this->data[$key] = $value;
  }

  public function fetch_field($field)
  {
    if(isset($this->data[$field]))
    {
      return $this->data[$field];
    }
    else
    {
      return false;
    }
  }

  public function display()
  {
    foreach($this->data as $key => $value )
    {
      echo "$key -> $value";
      echo "<br>";
    }
  }

  public function db_insert()
  {
    $query = 'insert into student(';
    $values = ' values(';
    foreach($this->data as $key => $value )
    {
      if($value != '')
      {
        $query .= "$key, ";
        $values .= "'$value', ";
      }
    }
    $query = rtrim($query, ', ');
    $values = rtrim($values, ', ');
    $query .= ')';
    $values .= ');';
    $final = $query.$values;
    if($this->mysqli->query($final))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  public function is_unique_username($value)
  {
    $value = sanitize_mysql($this->mysqli, $value);
    $query = "select id from student where username='$value';";
    if($result = $this->mysqli->query($query))
    {
      if($result->num_rows === 0)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }
}
?>
