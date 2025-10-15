<?php
require_once('connection_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = isset($_POST['code']) ? $_POST['code'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    if ($code && $message) {
        // For demonstration purposes, we'll just return a success response.
        // You can integrate your actual message sending logic here (e.g., email, SMS).
        
        // Example query to log the message sent to the student
        $sql = "INSERT INTO messages (student_code, message) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$code, $message])) {
            echo json_encode(['success' => 'Message sent successfully']);
        } else {
            echo json_encode(['error' => 'Failed to send message']);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
