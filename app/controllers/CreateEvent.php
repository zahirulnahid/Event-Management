<?php

class CreateEvent extends Controller{
 public function index(){
    
    $this->view('create_event');

   
 }
}

$CreateEvent = new CreateEvent;
$CreateEvent->index();
