<?php
require_once "config.php";

class Login{
    public $mysqli;

    function __construct(){
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $this->check_login();
    }

    function check_login(){
        if(isset($_POST['login'])){
            $user = $_POST['email'];
            $pass = $_POST['password'];
            
            if(empty($user) || empty($pass)){
                echo "<script>alert('All fields are required.');</script>";
            }else{
                $sql = "SELECT * FROM users WHERE email='$user'";
                $result = $this->mysqli->query($sql);
                $check_user = $result->num_rows;

                if($check_user == 1){
                    $row = $result->fetch_row();

                    if(password_verify($pass, $row[1])){
                        $_SESSION['email'] = $user;
                        header("Location: ../index.php");
                    }else{
                        echo "<script>alert('Incorrect password. Please try again.');</script>";
                    }
                }else{
                    echo "<script>alert('Email not found. Please register first.');</script>";
                }   
            }

        }
    }
}