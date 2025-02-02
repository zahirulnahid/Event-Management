<?php
class AttendeeModel {
    private $db;
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Register an attendee
    public function registerAttendee($event_id, $name, $email, $age, $gender, $phone) {
        $query = "INSERT INTO attendees (event_id, name, email, age, gender, phone) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ississ", $event_id, $name, $email, $age, $gender, $phone);
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

    // Get all attendees for an event with additional fields
    public function getAttendeesByEventId($event_id) {
        $query = "SELECT id, event_id, name, email, registered_at, age, gender, phone FROM attendees WHERE event_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
