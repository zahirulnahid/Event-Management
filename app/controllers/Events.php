<?php

class Events extends Controller{
    public function index() {
        // Safely get the 'url' from $_GET
        if (isset($_GET["url"])) {
            // Split the URL by "/"
            $urlParts = explode("/", $_GET["url"]);
            
            // Check if the second segment exists
            if (isset($urlParts[1]) && $urlParts[1] != null) {
                $this->view('register_attendee');  // Use the second segment as the view
            } else {
                $this->view('home');  // Default to the 'admin' view
            }
        } else {
            // If the 'url' is not set in the query, default to 'admin'
            $this->view('home');
        }
    }
}

$Events = new Events;
$Events->index();