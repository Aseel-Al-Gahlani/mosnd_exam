<?php
class Review {
private $conn;
private $table_name = "reviews1";

public $id;
public $user_id;
public $content_id;
public $rating;
public $comment;
public $created_at;
public $updated_at;

public function __construct($db) {
$this->conn = $db;
}

// public function create() {
// $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, content_id=:content_id, rating=:rating,
// comment=:comment";

// $stmt = $this->conn->prepare($query);

// $stmt->bindParam(":user_id", $this->user_id);
// $stmt->bindParam(":content_id", $this->content_id);
// $stmt->bindParam(":rating", $this->rating);
// $stmt->bindParam(":comment", $this->comment);

// if ($stmt->execute()) {
// return true;
// }
// return false;
// }

 public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, content_id=:content_id, rating=:rating, comment=:comment";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":content_id", $this->content_id);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":comment", $this->comment);

        return $stmt->execute();
 }

public function update() {
$query = "UPDATE " . $this->table_name . " SET rating=:rating, comment=:comment, updated_at=CURRENT_TIMESTAMP WHERE
id=:id AND user_id=:user_id";

$stmt = $this->conn->prepare($query);

$stmt->bindParam(":id", $this->id);
$stmt->bindParam(":user_id", $this->user_id);
$stmt->bindParam(":rating", $this->rating);
$stmt->bindParam(":comment", $this->comment);

if ($stmt->execute()) {
return true;
}
return false;
}

public function delete() {
$query = "DELETE FROM " . $this->table_name . " WHERE id=:id AND user_id=:user_id";

$stmt = $this->conn->prepare($query);

$stmt->bindParam(":id", $this->id);
$stmt->bindParam(":user_id", $this->user_id);

if ($stmt->execute()) {
return true;
}
return false;
}

public function readByContent($content_id) {
$query = "SELECT r.*, u.username FROM " . $this->table_name . " r JOIN users u ON r.user_id = u.id WHERE r.content_id =
:content_id ORDER BY r.created_at DESC";

$stmt = $this->conn->prepare($query);
$stmt->bindParam(":content_id", $content_id);
$stmt->execute();

return $stmt;
}




}