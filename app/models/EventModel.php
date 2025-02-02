<?php
class EventModel {
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Fetch all events
    public function getAllEvents() {
        $query = "SELECT id, name, description, date, location, max_capacity, created_by, created_at FROM events WHERE 1";
        $result = $this->conn->query($query);

        $events = [];
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
        return $events;
    }

    // Fetch a single event by ID
    public function getEventById($eventId) {
        $query = "SELECT id, name, description, date, location, max_capacity, created_by, created_at FROM events WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createEvent($name, $description, $date, $location, $max_capacity, $user_id) {
        if ($this->conn === null) {
            die('Database connection not established.');
        }

        $query = "INSERT INTO events (name, description, date, location, max_capacity, created_by) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssii", $name, $description, $date, $location, $max_capacity, $user_id);
        return $stmt->execute();
    }

    // Update an event
    public function updateEvent($id, $name, $description, $date, $location, $max_capacity) {
        $query = "UPDATE events SET name = ?, description = ?, date = ?, location = ?, max_capacity = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssii", $name, $description, $date, $location, $max_capacity, $id);
        return $stmt->execute();
    }

    public function deleteEvent($id) {
        // Delete all attendees related to the event first
        $query1 = "DELETE FROM attendees WHERE event_id = ?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
    
        // Now delete the event
        $query2 = "DELETE FROM events WHERE id = ?";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bind_param("i", $id);
        
        return $stmt2->execute();
    }


// Fetch events by created_by (user ID)
public function getEventsByUser($userId) {
    $query = "SELECT 
    events.id, 
    events.name, 
    events.description, 
    events.date, 
    events.location, 
    events.max_capacity, 
    events.created_by, 
    events.created_at,
    COUNT(attendees.id) AS total_registered
FROM events
LEFT JOIN attendees ON events.id = attendees.event_id
WHERE events.created_by = ?
GROUP BY events.id;
";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    return $events;
}

public function getEventCount($user_id, $filter = '')
{
    $query = "SELECT COUNT(*) AS total FROM events WHERE created_by = ?";

    // Add filtering condition
    if ($filter) {
        $query .= " AND name LIKE ?";
    }

    $stmt = $this->conn->prepare($query);
    if ($filter) {
        $filter = "%$filter%";
        $stmt->bind_param("ss", $user_id, $filter);
    } else {
        $stmt->bind_param("s", $user_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'];
}







}
?>
