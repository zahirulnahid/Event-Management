<?php

class Dashboard extends Controller{
 public function index(){
    
    $this->view('dashboard');

   
 }
}

$Dashboard = new Dashboard;
$Dashboard->index();
