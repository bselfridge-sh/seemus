<?php

class User {
    
    static function LogonScreen() {
        ?>
        <form action="index.php" method=post >
            <input type="hidden" name="activity" value="USER" />
            <input type="text" name="email" placeholder="Email" value="<?php echo formRequest("email_last"); ?>" />
            <input type="text" name="password" placeholder="Password" />
            <input type="submit" value="Logon" />
        </form>
        <?php
    }
}

?>
