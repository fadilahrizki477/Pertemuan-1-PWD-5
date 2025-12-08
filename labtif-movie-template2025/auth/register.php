<?php
require_once "config.php";

class Register{
    public $mysqli;

    function __construct()
    {
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }
        function registerUser($username, $email, $password){
            $user = $_POST['username'];
            $email = $_POST['email'];
            $pass = $_POST['password'];

            if(empty($user) || empty($email) || empty($pass)){
                echo "<script>alert('All fields are required.');</script>";
            }else{
                $get_user = "SELECT * FROM users WHERE email='$email'";
                $result = $this->mysqli->query($get_user);
                $check_user = $result->num_rows;

                if($check_user == 1){
                    echo "<script>alert('Email already exists. Please use a different email.');</script>";
            }else{
                $password_hash = password_hash($pass, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$pass')";
                $query = $this->mysqli->prepare($sql) or die ($this->mysqli->error);
                $query->execute();

                if($query){
                    header("Location: loginFrom.php");
                }else{
                    echo "<script>alert('Registration failed. Please try again.');</script>";
                }
            }
        }
    }    
}