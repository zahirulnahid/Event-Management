<?php

class Home extends Controller {
    public function index() {
        // Start the session
        session_start();

        // Check if the user is logged in by verifying the session
        if (!isset($_SESSION['user_id'])) {
            // Redirect to the login page if the user is not logged in
            header("Location: login");
            exit();
        }

        // If the user is logged in, load the home view
        $this->view('home');
    }
}

// Instantiate the Home controller and call the index method
$home = new Home;
$home->index();