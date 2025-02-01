<?php
session_start();

require_once "../app/Core/Database.php";
require_once "../app/models/AttendeeModel.php";
require_once "../app/models/EventModel.php";

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

$attendeeModel = new AttendeeModel();

$eventModel = new EventModel();
// Fetch event ID from the query parameter
$event_id = $_GET['event_id'];

if (!$event_id) {
    echo "Event ID is required.";
    exit();
}

// Fetch attendees for the event
$attendees = $attendeeModel->getAttendeesByEventId($event_id);
$event = $eventModel->getEventById($event_id);
if (empty($attendees)) {
    echo "No attendees found for this event.";
    exit();
}

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="'.$event['name'].'-attendees.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Add CSV headers
fputcsv($output, ['Name', 'Email', 'Registered At']);

// Add attendee data
foreach ($attendees as $attendee) {
    fputcsv($output, [
        $attendee['name'],
        $attendee['email'],
        $attendee['registered_at']
    ]);
}

// Close output stream
fclose($output);
exit();