<?php

include "include/top.inc.php";
include "class/Utils.class.php";

$activity = formRequest("activity");

?>
<html>
    <head>
        <title>Seemus</title>
    </head>
    <body>
        <div class="navigation" style="text-align:right">
        <?php
            if($_SESSION["Email"]) {
                echo $_SESSION["Email"] & " | ";
            } else {
                ?><a href="index.php?activity=USER">LOGON</a> | <?php
            }
            ?>
            <a href="index.php?activity=USER-LOGOFF">LOGOFF</a>

        </div>
        <div class="body">
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

                    if($result) {
                        foreach($result as $row) {
                            $dbPassword     = $row["fdPassword"];
                            $formPassword = formRequest("password");

                            if( password_verify($formPassword,$dbPassword) ) {
                                $_SESSION["FullName"]   = $row["fdFullName"];
                                $_SESSION["Email"]      = $row["fdEmail"];
                                $_SESSION["Admin"]      = $row["fdAdmin"];
                            } else {
                                redirectJS("USER","Bad+Email+or+Bad+Password","email_last=".formRequest("email"));
                            }
                        }
                    } else {
                        redirectJS("USER","Bad+Email+and+Bad+Password","email_last=".formRequest("email"));
                    }
                }
            break;

            case "USER-LOGOFF":
                // User Logout
                $tmp_email = $_SESSION["Email"];
                session_destroy();
                redirectJS("","Successfully Logged Off","");
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
            break;
        }
        ?>
        </div>
<?php
include "include/bottom.inc.php";
?>
