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
            if($_SESSION["Admin"]==1 || $_SESSION["Email"]) { 
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
        <center><div class="body" style="width:500px;">
        <?php
            if(!formRequest("reason")=="") {
                echo "<div class=\"reason\">" . formRequest("reason") . "</div>";
            }

        switch($activity) {
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
