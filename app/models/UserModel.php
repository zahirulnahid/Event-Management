<?php

class UserModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Register a new user
    public function registerUser($username, $password, $role = "user")
    {
        // Check if the username already exists
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return "Username already exists!";
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert the new user
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, role, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $username, $hashedPassword, $role);
        
        if ($stmt->execute()) {
            return "Registration successful!";
        } else {
            return "Error: " . $stmt->error;
        }
    }

    // Login user
    public function loginUser($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return true; // Login successful
        } else {
            return false; // Login failed
        }
    }
    public function getUserById($user_id)
{
    $stmt = $this->conn->prepare("SELECT id, username, role, created_at FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc(); // Returns user details as an associative array
}
public function getEventsByUser($user_id, $limit = 10, $offset = 0, $sort = 'name', $filter = '')
{
    $query = "SELECT * FROM events WHERE user_id = ?";

    // Add filtering condition
    if ($filter) {
        $query .= " AND name LIKE ?";
    }

    // Sorting logic
    $query .= " ORDER BY " . $sort . " ASC";

    // Pagination logic
    $query .= " LIMIT ? OFFSET ?";

    $stmt = $this->conn->prepare($query);

    // Bind parameters
    if ($filter) {
        $filter = "%$filter%";
        $stmt->bind_param("ssii", $user_id, $filter, $limit, $offset);
    } else {
        $stmt->bind_param("iiii", $user_id, $limit, $offset);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}




}
?>
