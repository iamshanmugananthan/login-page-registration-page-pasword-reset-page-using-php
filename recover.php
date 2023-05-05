<?php

if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];

    if (!empty($new_password) && !empty($confirm_password) && !empty($email)) {
        if ($new_password === $confirm_password) {
            $host = "localhost";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "lr_admin";

            $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
            if (mysqli_connect_error()) {
                die('Connect Error ('. mysqli_connect_errno() .') '. mysqli_connect_error());
            } else {
                $UPDATE = "UPDATE register SET passwd1 = '$new_password' WHERE email = '$email'";
                $result = $conn->query($UPDATE);
                if ($conn->affected_rows == 1) {
                    header("Location: index.html");
                    exit;
                } else {
                    echo "Error: Unable to update password.";
                }
                $conn->close();
            }
        } else {
            echo "Error: New password and confirm password do not match.";
        }
    } else {
        echo "Error: All fields are required.";
    }
}
?>
