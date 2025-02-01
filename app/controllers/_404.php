<?php

class _404 extends Controller{
 public function index(){
    
    $this->view('404');

   
 }
}

$_404 = new _404;
$_404->index();
