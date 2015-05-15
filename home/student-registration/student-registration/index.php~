<?php
require_once "global_vars.php";
require_once "sanitation.php";
require_once "student.php";
require_once "define.php";
session_start();
echo <<<_HTML
<!doctype html>
<html>
<head> 
<link type="text/css" rel="stylesheet" href="stylesheet.css">
<title>Student Registration</title>
</head>
<body>
<h1 id="course">South Harmon Institute of Technology</h1>
_HTML;
$errmsg = '';
$try_login = true;
if(!isset($_SESSION['logged_in']))
{
  $login_success = false;
  if(isset($_POST['username']) && isset($_POST['passcode']))
  {
    $mysqli = new mysqli($host, $username, $password, $database);
    if(req_newusr_fields($_POST))
    { 
      /* Create user */
      $new_user = new Student($host, $username, $password, $database);
      if($new_user->is_unique_username($_POST['username']))
      {
        foreach($_POST as $key => $value)
        {
          $new_user->set_field($key, $value);
        }
        if($new_user->db_insert())
        {
          $first_name = $new_user->fetch_field('first_name');
          $last_name = $new_user->fetch_field('last_name');
          mail(ADMINISTER, "$first_name $last_name has created an account", "$first_name $last_name".BODY_ADMIN);
          mail($new_user->fetch_field('email'), "Welcome $first_name $last_name", BODY_USER.$new_user->fetch_field('username')." and your password is ".$new_user->fetch_field('passcode').'.');
        }
        else
        {
          $errmsg = CREATE_ERR;
        }
      }
      else
      {
        $try_login = false;
        $errmsg = CREATE_ERR;
      }
    }
    if($try_login)
    {
      $user = sanitize_mysql($mysqli, $_POST['username']);
      $pass = sanitize_mysql($mysqli, $_POST['passcode']);
      $query = "select first_name, id, num_courses_enrolled, email from student where username='$user' and passcode='$pass';";
      if($result = $mysqli->query($query))
      {
        if($result->num_rows == 1)
        {
          $data = $result->fetch_array();
          $_SESSION['first_name'] = $data[0];
          $_SESSION['logged_in'] = true;
          $_SESSION['id'] = $data[1];
          $_SESSION['num_courses_enrolled'] = $data[2];
          $_SESSION['email'] = $data[3];
          $login_success = true;
        }
        else
        {
          $login_success = false;
          $errmsg = COMBO_ERR;
        }
      }
      $mysqli->close();
    }
  }
  if(!$login_success)
  {
    echo <<<_HTML
    <h2>Login</h2>
_HTML;
    if($errmsg != '')
    {
      echo '<strong id="errmsg">'."$errmsg</strong>";
    }
    echo <<<_HTML
    <form method="post" action="index.php">
    Username:<br>
    <input type="text" name="username">
    <br>
    Password:<br>
    <input type="password" name="passcode"><br>
    <input type="submit">
    </form>
    <br>
    New student? Create an account below.
    <br><br>
    *Required Fields<br><br>
    <form method="post" action="index.php" autocomplete="off">
    *Username:<br>
    <input type="text" name="username" maxlength=16 required>
    <br>
    *Password:<br>
    <input type="password" name="passcode" maxlength=16 required>
    <br>
    *First Name:<br>
    <input type="text" name="first_name" maxlength=50 required>
    <br>
    Middle name:<br>
    <input type="text" name="middle_name" maxlength=50>
    <br>
    *Last Name:<br>
    <input type="text" name="last_name" maxlength=50 required>
    <br>
    *Email:<br>
    <input type="email" name="email" maxlength=50 required>
    <br>
    *Address Line 1:<br>
    <input type="text" name="address_line_1" required>
    <br>
    Address Line 2:<br>
    <input type="text" name="address_line_2">
    <br>
    *City:<br>
    <input type="text" name="city" required>
    <br>
    *State:<br>
_HTML;
    $mysqli = new mysqli($host, $username, $password, $database);
    if(!$mysqli->connect_errno)
    {
      echo '<select name="state" required>';
      $query = "select abbreviation from state;";
      $result = $mysqli->query($query);
      echo '<option selected value=""></option>';
      while($data = $result->fetch_row())
      {
        echo "<option value=".$data[0].">".$data[0]."</option>";
      }
      echo "</select>";
      $result->free();
      $mysqli->close();
    }
    else
    {
      echo '<input type="text" name="state" maxlength=2 required>';
    }
    echo <<<_HTML
     <br>
    *Zip:<br>
    <input type="tel" name="zip" maxlength=5>
    <br>
    Home Phone:<br>
    <input type="tel" name="home_phone" maxlength=10>
    <br>
    Cell Phone:<br>
    <input type="tel" name="cell_phone" maxlength=10>
    <br>
    <input type="submit">
    </form>
_HTML;
  }
}
if(isset($_SESSION['logged_in']))
{
  echo "<h3>Welcome ".$_SESSION['first_name']."</h3><a href='logout.php'>(logout)</a>";
  $mysqli = new mysqli($host, $username, $password, $database);
  $errmsg = '';
  if(!$mysqli->connect_errno)
  {
    if(isset($_POST['add_id']))
    {
      $query = "select current_enroll, max_enroll from course where id='".$_POST['add_id']."';";
      $result = $mysqli->query($query);
      if($result->num_rows == 1)
      {
        $errmsg = '';
        $data = $result->fetch_row();
        $available = $data[0];
        $capacity = $data[1];
        $query = "select course_id from participants where student_id='".$_SESSION['id']."' and course_id='".$_POST['add_id']."';";
        $result = $mysqli->query($query);
        if($result->num_rows == 0)
        {
          if($_SESSION['num_courses_enrolled'] < MAX_NUM_COURSES)
          {
            if($available < $capacity)
            {
              $query = "select days, course_time, name, title from course where id='".$_POST['add_id']."';";
              $result = $mysqli->query($query);
              $data = $result->fetch_row();
              $course_time = $data[0].$data[1];
              $course_name = $data[2];
              $course_title = $data[3];
              $query = "select days, course_time from course where id in (select course_id from participants where student_id='".$_SESSION['id']."');";
              $result = $mysqli->query($query);
              $can_enroll = true;
              for($i = 0; $i < $result->num_rows; $i++)
              {
                $data = $result->fetch_row();
                $my_time = $data[0].$data[1];
                if($my_time === $course_time)
                {
                  $can_enroll = false;
                  break;
                }
              }
              if($can_enroll)
              {
                $query1 = "insert into participants values('".$_SESSION['id']."', '".$_POST['add_id']."');";
                $query2 = "update student set num_courses_enrolled = num_courses_enrolled + 1 where id='".$_SESSION['id']."';";
                $query3 = "update course set current_enroll = current_enroll + 1 where id='".$_POST['add_id']."';";
                $mysqli->query($query1);
                $mysqli->query($query2);
                $mysqli->query($query3);
                $_SESSION['num_courses_enrolled']++;
                $errmsg = 'Successfully added course';
                mail($_SESSION['email'], "Enrollment notification: $course_name", "You have enrolled in $course_name $course_title at $course_time\n - South Harmon Institute of Technology");
                mail(ADMINISTER, "Enrollment Notification", "Student #".$_SESSION['id']." has enrolled in $course_name $course_title");

              }
              else
              {
                $errmsg = 'Cannot enroll, you already have a course in that time slot';
              }
            }
            else
            {
              $errmsg = 'Cannot enroll, course is full';
            }
          }
          else
          {
            $errmsg = 'Cannot enroll, you have max number of credit hours';
          }
        }
        else
        {
          $errmsg = 'You are already enrolled in that course';
        }
      }
      else
      {
        $errmsg = 'Invalid course ID';
      }
    }

    if(isset($_POST['drop_id']))
    {
      /* Make sure they are enrolled in course id */
      $query = "select course_id from participants where student_id='".$_SESSION['id']."' and course_id='".$_POST['drop_id']."';";
      $result = $mysqli->query($query);
      if($result->num_rows == 1)
      {
        $query1 = "delete from participants where student_id='".$_SESSION['id']."' and course_id='".$_POST['drop_id']."';";
        $query2 = "update student set num_courses_enrolled = num_courses_enrolled - 1 where id='".$_SESSION['id']."';";
        $query3 = "update course set current_enroll = current_enroll - 1 where id='".$_POST['drop_id']."';";
        $mysqli->query($query1);
        $mysqli->query($query2);
        $mysqli->query($query3);
        $_SESSION['num_courses_enrolled'] -= 1;
        $errmsg = 'Sucessfully dropped course';
        
      }
      else
      {
        $errmsg = 'You are not enrolled in that course';
      }
    }

    if($errmsg != '')
    {
      echo '<br><br><strong id="errmsg">'."$errmsg</strong>";
    }

    if($_SESSION['num_courses_enrolled'] == 1)
    {
      $courses = "course";
    }
    else
    {
      $courses = "courses";
    }

    echo "<h2>You are enrolled in ".$_SESSION['num_courses_enrolled']." ".$courses.":"."</h2>";
    if($_SESSION['num_courses_enrolled'] > 0)
    {
      echo "<form method='post'>";
      show_my_courses($mysqli);
      echo "</form>";
    }
    echo "<h2>Course Catalog:</h2>";
    echo "<form method='post'>";
    show_courses($mysqli);
    echo "</form>";
  }
  $mysqli->close();
}
echo "</body>";
echo "</html>";

function req_newusr_fields($list)
{
  if(  isset($list['first_name']) 
    && isset($list['last_name']) 
    && isset($list['email']) 
    && isset($list['address_line_1']) 
    && isset($list['city']) 
    && isset($list['state']) 
    && isset($list['zip']))
  {
    return true;
  }
  else
  {
    return false;
  }
}

function show_my_courses($mysqli)
{
  $fields = array('Course', 'Title', 'Section', 'Day', 'Time', 'ID');
  $query = "select name, title, section, days, course_time, id from course where id in (select course_id from participants where student_id='".$_SESSION['id']."');";
  if($result = $mysqli->query($query))
  {
    while($data = $result->fetch_array())
    {
      echo "<div id='course'>";
      echo "$fields[0]: $data[0]$data[2]<br>";
      echo "$fields[1]: $data[1]<br>";
      echo "$fields[3]: $data[3] $data[4]<br>";

      echo "<form method='post' action='index.php'>";
      echo "<input type='hidden' name='drop_id' value='".$data[5]."'>";
      echo "<input type='submit' value='Drop course'>";
      echo "</form>";
      echo "</div>";
    }
  }
}

function show_courses($mysqli)
{
  $fields = array('Course', 'Title', 'Decription', 'Section', 'Credit Hours', 'Day', 'Time', 'Seats', 'Seats Available', 'ID');

  $query = "select name, title, description, section, credits, days, course_time, max_enroll, current_enroll, id from course;";
  if($result = $mysqli->query($query))
  {
    while($data = $result->fetch_array())
    {
      echo "<div id='course'>";
      $data[8] = $data[7] - $data[8];
      echo "$fields[0]: $data[0]$data[3] $data[1]<br>";
      echo "$fields[2]: $data[2]<br>";
      echo "$fields[4]: $data[4]<br>";
      echo "$fields[6]: $data[5] $data[6]<br>";
      echo "$fields[7]: $data[7]<br>";
      echo "$fields[8]: $data[8]<br>";
      if($data[8] > 0)
      {
        echo "<form method='post' action='index.php'>";
        echo "<input type='hidden' name='add_id' value='".$data[9]."'>";
        echo "<input type='submit' value='Add course'>";
        echo "</form>";
      }
      echo "</div>";
    }
  }
}
?>
