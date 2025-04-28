<?php
include '../config/conn.php';
if (isset($_SESSION['customer_logged_in']) && isset($_SESSION['user_id'])) {

$user_id = $_SESSION['user_id'];
if($_SERVER['REQUEST_METHOD'] === "POST"){
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit;

    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $displayname = $_POST['display_name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $cpass = $_POST['current_password'];
    $confpassword = $_POST['confirm_password'];



    $sql1 = "SELECT * FROM users WHERE id = '$user_id'";
    $query1 = mysqli_query($conn,$sql1);
    $row = mysqli_fetch_assoc($query1);

    // echo "<pre>";
    // print_r($row);
    // echo "</pre>";
    // exit;
    if($pass === $confpassword){
        $password = password_hash($pass, PASSWORD_DEFAULT);
        if(password_verify($cpass,$row['password'])){
            $sql = "UPDATE users SET first_name = '$fname',last_name = '$lname',display_name='$displayname',
            email='$email',password='$password' WHERE id='$user_id' ";
            $query = mysqli_query($conn,$sql);
            // echo $sql;
            // exit;
            if($query){
                echo "Data Update Successfully";
                // echo "<script>
                //     alert('Data Update Successfully');
                //     window.location.href = index.php?p=my-account;
                // </script>";
            }else{
                echo "Error";
                // echo "<script>
                //     alert('Error');
                //     window.location.href = index.php?p=my-account;
                // </script>";
            }
        }else{
            echo "Current Password Not Match Wit Existing Password";
        //     echo "<script>
        //     alert('Current Password Not Match Wit Existing Password');
        //     window.location.href = index.php?p=my-account;
        // </script>";
        }
    }else{
        echo "Password And Confirm Password Not Match";
        // echo "<script>
        //     alert('Password And Confirm Password Not Match');
        //     window.location.href = index.php?p=my-account;
        // </script>";
    }
}

}
?>