<?php

require "../entity/User.php";
require "../entity/Comment.php";
require "../entity/Like.php";

class Post {

    public $postID;
    public $text;
    public $user;
    public $comments;

    public function __construct($postID = null, $text = null, $user = null, $comments = null) {
        $this->postID = $postID;
        $this->text = $text;
        $this->user = $user;
        $this->comments = $comments;
    }

    public static function createPost($text, $userID, mysqli $connection) {
        $query = "INSERT INTO Post(text, userID) VALUES ('$text', '$userID')";

        if (!$connection->query($query)) {
            return 'failed';
        } else {
            return 'success';
        }
    }

    public static function loadSpecificFeed($userID, $username, mysqli $connection) {
        $query_1 = "SELECT p.postID, p.text, p.createdDate, u.firstName, u.lastName, u.username FROM Post p INNER JOIN User u ON p.userID = u.userID WHERE u.username = '$username' ORDER BY p.createdDate DESC";

        $query_2 = "SELECT c.commentID, c.postID, c.text, u.firstName, u.lastName, u.username FROM Comment c INNER JOIN User u ON c.userID = u.userID ORDER BY c.createdDate DESC";

        $query_3 = 'SELECT u.userID, l.commentID, l.likeID FROM Likes l INNER JOIN User u ON u.userID = l.userID';

        $rs_1 = $connection->query($query_1);
        $rs_2 = $connection->query($query_2);
        $rs_3 = $connection->query($query_3);

        $rs_array_2 = [];
        $rs_array_3 = [];

        while ($row_2 = $rs_2->fetch_array()) {
            array_push($rs_array_2, $row_2);
        }

        while ($row_3 = $rs_3->fetch_array()) {
            array_push($rs_array_3, $row_3);
        }

        $posts = [];

        if (!empty($rs_1) && $rs_1->num_rows > 0) {
            while ($row_1 = $rs_1->fetch_array()) {
                $user = new User(null, $row_1["firstName"], $row_1["lastName"], null, $row_1["username"]);

                $comments = [];

                foreach($rs_array_2 as $row_2) {
                    if($row_2['postID'] == $row_1['postID']) {
                        $comment_user = new User(null, $row_2["firstName"], $row_2["lastName"], null, $row_2["username"]);
                        
                        $likes = [];

                        $flag = false;

                        foreach($rs_array_3 as $row_3) {
                            
                            if($row_3['commentID'] == $row_2['commentID']) {
                                if($row_3['userID'] == $userID) {
                                    $flag = true;
                                }
                                array_push($likes, new Like($row_3['likeID'], null, new User($row_3['userID'])));
                            }
                            
                        }

                        array_push($comments, new Comment($row_2['commentID'], $row_2['text'], $likes, $comment_user, null, $flag));
                    }
                }

                array_push($posts, new Post($row_1['postID'], $row_1['text'], $user, $comments));
            }
        }

        return $posts;
    }

    public static function loadFeed($userID, mysqli $connection) {
        $query_1 = "SELECT p.postID, p.text, p.createdDate, u.firstName, u.lastName, u.username FROM Post p INNER JOIN User u ON p.userID = u.userID ORDER BY p.createdDate DESC";

        $query_2 = "SELECT c.commentID, c.postID, c.text, u.firstName, u.lastName, u.username FROM Comment c INNER JOIN User u ON c.userID = u.userID ORDER BY c.createdDate DESC";

        $query_3 = 'SELECT u.userID, l.commentID, l.likeID FROM Likes l INNER JOIN User u ON u.userID = l.userID';

        $rs_1 = $connection->query($query_1);
        $rs_2 = $connection->query($query_2);
        $rs_3 = $connection->query($query_3);

        $rs_array_2 = [];
        $rs_array_3 = [];

        while ($row_2 = $rs_2->fetch_array()) {
            array_push($rs_array_2, $row_2);
        }

        while ($row_3 = $rs_3->fetch_array()) {
            array_push($rs_array_3, $row_3);
        }

        $posts = [];

        if (!empty($rs_1) && $rs_1->num_rows > 0) {
            while ($row_1 = $rs_1->fetch_array()) {
                $user = new User(null, $row_1["firstName"], $row_1["lastName"], null, $row_1["username"]);

                $comments = [];

                foreach($rs_array_2 as $row_2) {
                    if($row_2['postID'] == $row_1['postID']) {
                        $comment_user = new User(null, $row_2["firstName"], $row_2["lastName"], null, $row_2["username"]);
                        
                        $likes = [];

                        $flag = false;

                        foreach($rs_array_3 as $row_3) {
                            
                            if($row_3['commentID'] == $row_2['commentID']) {
                                if($row_3['userID'] == $userID) {
                                    $flag = true;
                                }
                                array_push($likes, new Like($row_3['likeID'], null, new User($row_3['userID'])));
                            }
                            
                        }

                        array_push($comments, new Comment($row_2['commentID'], $row_2['text'], $likes, $comment_user, null, $flag));
                    }
                }

                array_push($posts, new Post($row_1['postID'], $row_1['text'], $user, $comments));
            }
        }

        return $posts;
    }

}