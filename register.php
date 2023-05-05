<?php

$uname = $_POST['uname'];
$email = $_POST['email'];
$passwd1 = $_POST['passwd1'];
$passwd2 = $_POST['passwd2'];

if (!empty($uname) && !empty($email) && !empty($passwd1) && !empty($passwd2)) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "lr_admin";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if (mysqli_connect_error()) {
        die('Connect Error ('. mysqli_connect_errno() .') '. mysqli_connect_error());
    } else {
        $SELECT = "SELECT email FROM register WHERE email = ? LIMIT 1";
        $INSERT = "INSERT INTO register (uname, email, passwd1, passwd2) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssss", $uname, $email, $passwd1, $passwd2);
            $stmt->execute();
            if ($stmt->affected_rows == 1) {
                header("Location: https://www.prakasoft.com/");
                exit;
            } else {
                echo "Error: Unable to insert record.";
            }
        } else {
            echo "Someone already registered using this email";
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required";
    die(); 
}

?>
