<?php

  $servername = "localhost";
  $username = "selfridge";
  $password = "xpsr450D$";
  $dbname = "Seemus";
  
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Successful connection";
} catch(PDOException $e) {
    echo $e->getMessage();
}

$stmt = $conn->prepare("SELECT `ID`, `IDauto`,`Name` FROM Seemus.tbTable");
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

if ($result) {
  $printedHeader=false;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    if(!$printedHeader) {
      echo "<table>";   // Start Table
      echo "<tr>";      // Start Header Row
        foreach($row as $col_name => $val)
          {
          echo "<th>$col_name</th>";    // Print Each Field Name
          }
      echo "</tr>";
      $printedHeader=true;
    }
  }
  echo "</table>";
} else {
  echo "0 results";
}

?>
