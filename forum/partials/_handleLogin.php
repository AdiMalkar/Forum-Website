<?php
$showError = false;
$login = false;
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];

    $sql = "select * from `users` where user_email = '$email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if($numRows==1){
        while($row = mysqli_fetch_assoc($result)) {
            if (password_verify($pass, $row['user_pass'])) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['sno'] = $row['sno'];
                $_SESSION['useremail'] = $email;
                echo "logged in ".$email;
                header("Location: /forum/index.php?loginsuccess=true");
                exit();
            }
            else {
                $showError = "Invalid Credentials";
            }    
        }  
    }
    else {
        $showError = "Invalid Credentials";
    }
    header("Location: /forum/index.php?loginsuccess=false&error=$showError");
}

?>


<!-- echo '<br><div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Success!</strong> You are logged in.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div></br>'; -->

