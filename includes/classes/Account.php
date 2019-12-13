<?php
class Account {

    private $errorArray;
    private $connection;

    public function __construct($connection){
        $this->errorArray = array();
        $this->connection = $connection;
    }

    public function login($username, $password) {
        $passwordQuery = mysqli_query($this->connection, "SELECT password FROM users WHERE username='$username'");
        $hashedPassword = mysqli_fetch_row($passwordQuery);

            $query = mysqli_query($this->connection, "SELECT * FROM users WHERE username='$username'");
            if(mysqli_num_rows($query) == 1 && password_verify($password, $hashedPassword[0])){
                return true;
            } else {
                array_push($this->errorArray, Constants::$loginFailed);
                return false;
            }
        
    }

    public function register($username, $firstName, $lastName, $email, $confirmedEmail, $password, $confirmedPassword) : bool {
        $this->validateUsername($username);
        $this->validateFirstname($firstName);
        $this->validateLastname($lastName);
        $this->validateEmails($email, $confirmedEmail);
        $this->validatePasswords($password, $confirmedPassword);

        if(empty($this->errorArray)){
            return $this->insertUserData($username, $firstName, $lastName, $email, $password);
        } else {
            return false;
        }
    }

    private function insertUserData($username, $firstName, $lastName, $email, $password) : bool {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $profilePicture = "assets/images/profile_pics/head_emerald.png";
        $date = date("Y-m-d");

        $result = mysqli_query($this->connection, "INSERT INTO users VALUES ('', '$username', '$firstName', '$lastName', '$email', '$hashedPassword', '$profilePicture', '$date')");

        return $result;
    }

    public function getError($error) {
        if(!in_array($error, $this->errorArray)){
            $error = "";
        }

        return "<span class='errorMessage'>$error</span>";
    }

    private function validateUsername(string $username) : void {
        if(strlen($username) > 25 || strlen($username) < 5){
            array_push($this->errorArray, Constants::$usernameNotCorrectLength);
            return;
        }

        $checkUsernameQuery = mysqli_query($this->connection, "SELECT username FROM users WHERE username='$username'");

        if(mysqli_num_rows($checkUsernameQuery) != 0){
            array_push($this->errorArray, Constants::$usernameTaken);
            return;
        }
    }

    private function validateFirstname(string $firstName) : void {
        if(strlen($firstName) > 25 || strlen($firstName) < 2){
            array_push($this->errorArray, Constants::$firstNameNotCorrectLength);
            return;
        }
    }

    private function validateLastname(string $lastName) : void {
        if(strlen($lastName) > 25 || strlen($lastName) < 2){
            array_push($this->errorArray, Constants::$lastNameNotCorrectLength);
            return;
        }
    }

    private function validateEmails(string $email1,  string $email2) : void {
        if($email1 !== $email2){
            array_push($this->errorArray, Constants::$emailDoesNotMatch);
            return;
        }

        if(!filter_var($email1, FILTER_VALIDATE_EMAIL)){
            array_push($this->errorArray, Constants::$emailNotValid);
            return;
        }

        $checkEmailQuery = mysqli_query($this->connection, "SELECT email FROM users WHERE email='$email1'");

        if(mysqli_num_rows($checkEmailQuery) != 0){
            array_push($this->errorArray, Constants::$emailUsed);
            return;
        }
    }

    private function validatePasswords(string $password1,  string $password2) : void {
        if($password1 !== $password2){
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
            return;
        }

        if(strlen($password1) > 30|| strlen($password1) < 8){
            array_push($this->errorArray, Constants::$passwordNotCorrectLength);
            return;
        }

        if(preg_match('/[^A-Za-z0-9]/', $password1)){
            array_push($this->errorArray, Constants::$passwordHasInvalidCharacters);
            return;
        }
    }
}