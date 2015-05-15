<?php
  session_start();
  session_destroy();
  echo <<<_HTML
  <!doctype html> 
  <html>
  <head>
  <link type="text/css" rel="stylesheet" href="stylesheet.css">
  <title>Thank you for registering </title>
  </head>
  <body>
  <h1 id="course">Thank you for registering with South Harmon Institute of Technology!</h1>
  <a href="index.php">Back to login screen</a>
  </body>
  </html>
_HTML;

?>
