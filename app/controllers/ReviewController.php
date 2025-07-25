<?php
// app/controllers/ReviewController.php - Review controller

class ReviewController {
    public function list() {
        require __DIR__ . '/../views/reviews/list.php';
    }
    public function submit() {
        require __DIR__ . '/../views/reviews/submit.php';
    }
    public function update() {
        // Handle update logic
    }
    public function delete() {
        // Handle delete logic
    }
} 