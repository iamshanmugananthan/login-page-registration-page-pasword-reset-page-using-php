<?php
session_start();

if (isset($_POST['email']) && isset($_POST['passwd1'])) {
    $email = $_POST['email'];
    $passwd1 = $_POST['passwd1'];

    if (!empty($email) && !empty($passwd1)) {
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "lr_admin";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }

        $SELECT = "SELECT * FROM register WHERE email = ?";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($passwd1, $user['passwd1'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: https://www.prakasoft.com/");
                exit;
                
            }else {
                header("Location: https://www.prakasoft.com/");
            } 
            
        } else {
            $error = "The entered email is not registered.";
        }

        $stmt->close();
        $conn->close();
    } else {
        $error = "Both email and password are required.";
    }
}

if (isset($_SESSION['user_id'])) {
    header("Location: home.html");
    exit;
}

if (isset($error)) {
    echo $error;
}
?>
