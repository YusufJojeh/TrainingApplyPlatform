<?php
// app/controllers/HomeController.php - Home controller

class HomeController {
    public function index() {
        // Load the home view
        require __DIR__ . '/../views/home/index.php';
    }
} 