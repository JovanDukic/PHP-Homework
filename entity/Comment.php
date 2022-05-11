<?php

class Comment {

    public $commentID;
    public $text;
    public $likes;
    public $user;
    public $post;
    public $likedByOwner;

    public function __construct($commentID = null, $text = null, $likes = null, $user = null, $post = null, $likedByOwner = null) {
        $this->commentID = $commentID;
        $this->text = $text;
        $this->likes = $likes;
        $this->user = $user;
        $this->post = $post;
        $this->likedByOwner = $likedByOwner;
    }

    public static function createComment($text, $userID, $postID, mysqli $connection) {
        $query = "INSERT INTO Comment(text, userID, postID) VALUES ('$text', '$userID', '$postID')";

        if (!$connection->query($query)) {
            return 'failed';
        } else {
            return 'success';
        }
    }

}