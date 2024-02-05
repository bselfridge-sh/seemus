<?php

  $servername = "100.115.92.196";
  $username = "selfridge";
  $password = "xpsr450D$";
  $dbname = "Seemus";
  
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Successful connection";
} catch(PDOException $e) {
    echo $e->getMessage();
}

?>
