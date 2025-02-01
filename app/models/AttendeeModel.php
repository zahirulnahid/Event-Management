<?php
class AttendeeModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Register an attendee
    public function registerAttendee($event_id, $name, $email) {
        $query = "INSERT INTO attendees (event_id, name, email) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iss", $event_id, $name, $email);
        return $stmt->execute();
    }

    // Get the number of attendees for an event
    public function getAttendeeCount($event_id) {
        $query = "SELECT COUNT(*) as count FROM attendees WHERE event_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    // Get all attendees for an event
    public function getAttendeesByEventId($event_id) {
        $query = "SELECT name, email, registered_at FROM attendees WHERE event_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>