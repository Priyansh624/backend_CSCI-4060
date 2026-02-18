<?php
    $str = "mypassword";
    echo md5($str);
?>


<?php

    $password = "mypassword";
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    echo "<br>";
    echo $hashed_password;
?>