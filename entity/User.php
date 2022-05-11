<?php

class User {

    public $userID;
    public $firstName;
    public $lastName;
    public $email;
    public $username;
    public $password;

    public function __construct($userID = null, $firstName = null, $lastName = null, $email = null, $username = null, $password = null) {
        $this->userID = $userID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    public static function updateUser($userID, $firstName, $lastName, $email, $username, $password, mysqli $connection) {
        $query = "UPDATE User SET firstName = ?, lastName = ?, email = ?, username = ?, password = ? WHERE userID = ?";

        $stmt = $connection->prepare($query);

        $stmt->bind_param("sssssi", $firstName, $lastName, $email, $username, $password, $userID);

        if($stmt->execute()) {
            return 'User profile has been successfully updated!';
        } else {
            return 'Failed to update user profile!';
        }
    }

    public static function loadSpecificUser($username, mysqli $connection) {
        $query = "SELECT * FROM User WHERE username = '$username'";

        $rs = $connection->query($query);

        $user;

        while($row = $rs->fetch_array()) {
            $user =  new User($row['userID'], $row['firstName'], $row['lastName'], $row['email'], $row['username']);
        }

        return $user;
    }

    public static function loadUserData($userID, mysqli $connection) {
        $query = "SELECT * FROM User WHERE userID = '$userID'";

        $rs = $connection->query($query);

        $user;

        while($row = $rs->fetch_array()) {
            $user =  new User($row['userID'], $row['firstName'], $row['lastName'], $row['email'], $row['username'], $row['password']);
        }

        return $user;
    }

    public static function register(User $user, mysqli $connection) {
        $query = "INSERT INTO User (firstName, lastName, email, username, password) VALUES (?, ?, ?, ?, ?)";

        $stmt = $connection->prepare($query);

        $stmt->bind_param("sssss", $user->firstName, $user->lastName, $user->email, $user->username, $user->password);

        return $stmt->execute();
    }

    public static function login(User $user, mysqli $connection) {
        $query = "SELECT userID, username FROM User WHERE username = ? AND password = ?";

        $stmt = $connection->prepare($query);

        $stmt->bind_param("ss", $user->username, $user->password);

        $stmt->execute();

        return $stmt->get_result();
    }

    public static function checkUsername($username, $connection) {
        $query = "SELECT * FROM User WHERE username = ?";

        $stmt = $connection->prepare($query);

        $stmt->bind_param("s", $username);

        $stmt->execute();

        $rs = $stmt->get_result();

        return !empty($rs) && $rs->num_rows > 0;
    }

    public static function getGeneratedKey(mysqli $connection)
    {
        $query = "SELECT LAST_INSERT_ID() AS ID";

        return $connection->query($query);
    }

}


