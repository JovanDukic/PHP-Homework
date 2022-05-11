<?php

class Like {

    public $likeID;
    public $comment;
    public $user;

    public function __construct($likeID = null, $comment = null, $user = null) {
        $this->likeID = $likeID;
        $this->comment = $comment;
        $this->user = $user;
    }

    public static function createLike($commentID, $userID, mysqli $connection) {
        $query_1 = "SELECT * FROM Likes WHERE commentID = '$commentID' AND userID = '$userID'";

        $rs = $connection->query($query_1);

        if (!empty($rs_1) && $rs_1->num_rows > 0) {
            return 'You have already liked it!';
        }

        $query_2 = "INSERT INTO Likes(commentID, userID) VALUES ('$commentID', '$userID')";

        if (!$connection->query($query_2)) {
            return 'Failed to create a like!';
        } else {
            return 'Like has been successfully created!';
        }
    }

    public static function deleteLike($commentID, $userID, mysqli $connection) {
        $query = "DELETE FROM Likes WHERE commentID = '$commentID' AND userID = '$userID'";

        if (!$connection->query($query)) {
            return 'Failed to delete a like!';
        } else {
            return 'Like has been successfully deleted!';
        }
    }

}