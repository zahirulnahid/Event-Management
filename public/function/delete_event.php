<?php

session_start();
require_once __DIR__ . "/../../app/Core/Database.php";
require_once __DIR__ . "/../../app/models/EventModel.php";

header('Content-Type: application/json'); // Force JSON response

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $event_id = intval($_POST['id']);
    $user_id = $_SESSION['user_id'];

    $event = new EventModel();
    $result = $event->deleteEvent($event_id);

    // Clear previous output and return valid JSON
    ob_clean();
    echo json_encode(['success' => $result]);
    exit();
}

ob_end_flush(); // End output buffering


?>
