<?php
require_once 'Database.php';
require_once 'Review.php';

$db = new Database();
$conn = $db->getConnection();

$review = new Review($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$review->user_id = 1;//$_POST['user_id'];
$review->content_id = $_POST['content_id'];
$review->rating = $_POST['rating'];
$review->comment = $_POST['comment'];


if ($review->create()) {
echo json_encode(array("message" => "Review created successfully."));
} else {
echo json_encode(array("message" => "Unable to create review."));
}
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
parse_str(file_get_contents("php://input"), $_PUT);

$review->id = $_PUT['id'];
$review->user_id = 1;
$review->rating = $_PUT['rating'];
$review->comment = $_PUT['comment'];

if ($review->update()) {
echo json_encode(array("message" => "Review updated successfully."));
} else {
echo json_encode(array("message" => "Unable to update review."));
}
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $inputData);
    $review->id = $inputData['id'];
    $review->user_id = $inputData['user_id'];
    if ($review->delete()) {
        echo json_encode(["message" => "Review deleted successfully."]);
    } else {
        echo json_encode(["message" => "Invalid input. Review ID and user ID are required."]);
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $content_id = isset($_GET['content_id']) ? $_GET['content_id'] : null;
    
    if ($content_id) {
        $result = $review->readByContent($content_id);
        $reviews = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($reviews);
    } else {
        echo json_encode(["message" => "Content ID not provided."]);
    }
}