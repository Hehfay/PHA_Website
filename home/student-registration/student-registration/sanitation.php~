<?php
  function sanitize_string($string)
  {
    $string = stripslashes($string);
    $string = htmlentities($string);
    $string = strip_tags($string);
    return $string;
  }

  function sanitize_mysql($mysqli, $query)
  {
    $query = $mysqli->real_escape_string($query);
    $query = sanitize_string($query);
    return $query;
  }
?>
