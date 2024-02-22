<?php
include "include/top.inc.php";
include "class/Utils.class.php";
include "class/User.Class.php";

$User = new User();

$activity = formRequest("activity");

?>
<html>
    <head>
        <title>Seemus</title>
        <link rel="stylesheet" href="include/seemus.css">
    </head>
    <body>
        <div class="navigation" style="text-align:center">
        <?php
            //HOME Navigation if NOT home page
            if($activity!="") { 
                ?>
                <a href="index.php">HOME</a> | 
                <?php
            }
            
            //Admin Navigation Options
            if($_SESSION["Admin"]==1) { 
                ?>
                <a href="index.php?activity=USERS">USERS</a> | 
                <a href="index.php?activity=ACCESS">ACCESS</a> | 
                <?php
            }

            //Admin AND Valid User Navigation Options
            if($_SESSION["Email"]) { 
                ?>
                <a href="index.php?activity=CONTENT">CONTENT</a> | 
                <a href="index.php?activity=FILES">FILES</a> | 
                <?php
            }
            
            //User Logon or Logoff Options
            if($_SESSION["Email"]!="") {
                ?><a href="index.php?activity=USER-LOGOFF" title="Logoff User: <?php echo $_SESSION["Email"]; ?>">LOGOFF</a><?php
            } else {
                ?><a href="index.php?activity=USER">LOGON</a><?php
            }
            ?>
        </div>
        <center><div class="body">
        <?php
            if(!formRequest("reason")=="") {
                echo "<div class=\"reason\">" . formRequest("reason") . "</div>";
            }
        switch($activity) {
 
          case "FILE-CREATE-PROCESS":
              // echo $_FILES['File']["name"];
            if($activity=="FILE-CREATE-PROCESS") {
              if (count($_FILES) > 0) {
                if (is_uploaded_file($_FILES['File']['tmp_name'])) {
                    $fdFile = file_get_contents($_FILES['File']['tmp_name']);
                    $fdFileType = $_FILES['File']['type'];
                    $fdFileName = $_FILES['File']['name'];
                    $fdFileSize = $_FILES['File']['size'];
                    $fdDateTime = date('Y-M-D G:i:s');
                    
                    $sql = "INSERT INTO tbFiles ( fdFileType , fdFile, fdFileName, fdFileSize, fdDateTime, fdArchive) 
                                        VALUES  (:fdFileType ,:fdFile,:fdFileName,:fdFileSize, now(),0)";
                    $statement = $conn->prepare($sql);
                    $statement->bindParam('fdFile',    $fdFile,      PDO::PARAM_STR);
                    $statement->bindParam('fdFileType',$fdFileType,  PDO::PARAM_STR);
                    $statement->bindParam('fdFileName',$fdFileName,  PDO::PARAM_STR);
                    $statement->bindParam('fdFileSize',$fdFileSize,  PDO::PARAM_INT);
                    
                    $current_id = $statement->execute();
                }
            }
          }

          case "FILE-DELETE-PROCESS":
            if($activity=="FILE-DELETE-PROCESS") {
                    $sql = "DELETE FROM tbFiles WHERE id = ". formRequest("id");
                    $statement = $conn->prepare($sql);
                    $current_id = $statement->execute();
            }


          case "FILES": // File Listing

              ?><br>
              <form action="index.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="activity" value="FILE-CREATE-PROCESS">
              <input type="hidden" name="order" value="<?php echo formRequest("order"); ?>">
              <input type="file" name="File" placeholder="File" value="">
              <input type="submit" name="Submit" value="UPLOAD!"><br>
              </form>
              <?php

              $sql = "SELECT id,fdFilename,fdFileType,fdFileSize,fdDateTime,fdArchive FROM `tbFiles`";

              $order=formRequest("order");
              if($order!=""){
                $sql = $sql . "ORDER BY $order";
              }
              
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
              // Check if $result has anything in it or not (Returns a FALSE if no data in there).
              if($result) {
                echo "<table border=1>";   // Start Table
                $firstRowPrinted = false;
                $i=1;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  if($firstRowPrinted == false) {
                    echo "<tr>";               // Start HEADER Row
                    echo "<th>##</th>";
                    //echo "<th>UPDATE</th>";
                    echo "<th>DELETE</th>";
                    echo "<th>VIEW</th>";
                    foreach($row as $col_name => $val) {
                      if($order == "`$col_name`") {
                        echo "<th><a href=\"index.php?activity=FILES&order=`$col_name` DESC\">$col_name</a></th>";    
                      } else {
                        echo "<th><a href=\"index.php?activity=FILES&order=`$col_name`\">$col_name</a></th>"; 
                      }
                    }
                    echo "</tr>";               // END Header Row
                    $firstRowPrinted = true;
                  }
                  echo "<tr>";               // Start Row
                  echo "<td>" . $i . "</td>";
                  $i=$i+1;
                  //echo "<td><a href=\"index.php?activity=FILE-UPDATE-FORM&id=" . $row["id"] . "&order=$order\">UPDATE</a></td>";
                  echo "<td><a href=\"index.php?activity=FILE-DELETE-PROCESS&id=".$row["id"]."&order=$order\">DELETE</a></td>";
                  echo "<td><a href=\"view.php?activity=FILE&id=".$row["id"]."\" target=\"_blank\">VIEW</a></td>";
                  foreach($row as $col_name => $val) {
                    echo "<td>$val</td>";    // Print Each Field VALUE
                  }
                  echo "</tr>";               // Start Row
                }
                echo "</table>";
              }

              break;



              case "CONTENT": // File Listing
  
                $sql = "SELECT id,fdTitle,CONCAT_WS('',left(fdContent,100),'...') as fdContent,fdArchive,fdDateTime FROM `tbContent`";
  
                $order=formRequest("order");
                if($order!=""){
                  $sql = $sql . "ORDER BY $order";
                }
                
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
          
                // Check if $result has anything in it or not (Returns a FALSE if no data in there).
                if($result) {
                  echo "<form action=\"index.php\" method=\"post\">";
                  echo "<input type=\"hidden\" name=\"activity\" value=\"CONTENT-CREATE-PROCESS\">";
                  echo "<input type=\"hidden\" name=\"order\" value=\"" .formRequest("order") . "\">";
                  echo "<table border=1>";   // Start Table
                  $firstRowPrinted = false;
                  $i=1;
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if($firstRowPrinted == false) {
                      echo "<tr>";               // Start HEADER Row
                      echo "<th>##</th>";
                      echo "<th>UPDATE</th>";
                      echo "<th>DELETE</th>";
                      echo "<th>VIEW</th>";
                      foreach($row as $col_name => $val) {
                        if($order == "`$col_name`") {
                          echo "<th><a href=\"index.php?activity=CONTENT&order=`$col_name` DESC\">$col_name</a></th>";    
                        } else {
                          echo "<th><a href=\"index.php?activity=CONTENT&order=`$col_name`\">$col_name</a></th>"; 
                        }
                      }
                      echo "</tr>";               // END Header Row
                      ?>
                      <tr>
                      <td>+</td>
                      <td colspan=4 align=center><input type="submit" name="Submit" value="ADD CONTENT!"></td>
                      <td><input type="text" name="fdTitle" value="" placeholder ="fdTitle" ><td>
                      <td><input type="text" name="fdContent" value="" placeholder ="fdContent" ></td>
                      <td><select name="fdArchive"><option selected value=0>No</option><option value=1>Yes</option></select></td>
                      <td><i>AUTO</i><td>
                      </tr>
                      <?php
                      $firstRowPrinted = true;
                    }
                    echo "<tr>";               // Start Row
                    echo "<td>" . $i . "</td>";
                    $i=$i+1;
                    echo "<td><a href=\"index.php?activity=CONTENT-UPDATE-FORM&id=" . $row["id"] . "&order=$order\">UPDATE</a></td>";
                    echo "<td><a href=\"index.php?activity=CONTENT-DELETE-PROCESS&id=".$row["id"]."&order=$order\">DELETE</a></td>";
                    echo "<td><a href=\"view.php?activity=CONTENT&id=".$row["id"]."\" target=\"_blank\">VIEW</a></td>";
                    foreach($row as $col_name => $val) {
                      echo "<td>$val</td>";    // Print Each Field VALUE
                    }
                    echo "</tr>";               // Start Row
                  }
                  echo "</table>";
                  echo "</form>";
                }
  
                break;
  



            case "USER": // User Logon
              if(formRequest("email") == "") {
                  ?>
                  <form action="index.php" method=post >
                      <input type="hidden" name="activity" value="USER" />
                      <input type="text" name="email" placeholder="Email" value="<?php echo formRequest("email_last"); ?>" />
                      <input type="text" name="password" placeholder="Password" />
                      <input type="submit" value="Logon" />
                  </form>
                  <?php
              } else {
                  $stmt = $conn->prepare("SELECT * FROM tbUsers WHERE fdEmail='".formRequest("email")."'");
                  $stmt->execute();
                  $result = $stmt->fetchAll(); // Returns true/false if records exist

                  //Any Valid Results back???
                  if($result) {
                      //Valid Email Address so lets check the user's password
                      foreach($result as $row) {
                          $dbPassword     = $row["fdPassword"];
                          $formPassword = formRequest("password");

                          //Check hashed password against the set Password in the Database
                          if( password_verify($formPassword,$dbPassword) ) {
                              // Valid Password and Username - Set Session Variables
                              $_SESSION["FullName"]   = $row["fdFullName"];
                              $_SESSION["Email"]      = $row["fdEmail"];
                              $_SESSION["Admin"]      = $row["fdAdmin"];

                              //Redirect to Homepage with a welcome message!
                              redirectJS("","Welcome+back+".$_SESSION["FullName"]);
                          } else {
                              //Redirect to USER LOGON with a bad logon message!
                              redirectJS("USER","Bad+Email+or+Bad+Password","email_last=".formRequest("email"));
                          }
                      }
                  } else {
                      //NOT a valid email address, Redirect to USER LOGON with a bad logon message!
                      redirectJS("USER","Bad+Email+and+Bad+Password","email_last=".formRequest("email"));
                  }
              }
          break;

          case "USER-LOGOFF":
              // User Logout
              $tmp_email = $_SESSION["Email"];
              //Clear Session
              session_destroy();

              //Redirect to Home Screen with message!
              redirectJS(""," successfully logged off!");
          break;

          case "VIEW":
              // View List of Content
              
          break;

          case "EDIT":
              // User Edit
              
          break;

          case "DELETE":
              // User Delete
              
          break;

          case "CREATE":
              // Create Content
              
          break;

          default:
              //default viewing of content
              echo "DEFAULT SEEMUS SCREEN!";
          break;
        }
        ?>
        </div></center>
<?php
include "include/bottom.inc.php";
?>
