<?php
    include("connection.php");
    if(isset($_POST['submit'])){
    $username = $_POST['user'];
    $password = $_POST['password'];    

    $sql = "select * from online_exam where adminID = '$username' and password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if($count==1){
        header("Location:admin/dashboard.php");
    }else{
        echo '<script>
            window.location.href = "index.php";
            alert("Login failed. Invalid credentials")
            </script>';
    }
    }
?>