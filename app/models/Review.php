<?php
// app/models/Review.php - Review model

class Review {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function create($company_id, $student_id, $rating, $review) {
        $sql = "INSERT INTO company_reviews (company_id, student_id, rating, review) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$company_id, $student_id, $rating, $review]);
    }
    public function getByCompany($company_id) {
        $sql = "SELECT * FROM company_reviews WHERE company_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$company_id]);
        return $stmt->fetchAll();
    }
    public function getByStudent($student_id) {
        $sql = "SELECT * FROM company_reviews WHERE student_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll();
    }
    public function update($id, $rating, $review) {
        $sql = "UPDATE company_reviews SET rating=?, review=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$rating, $review, $id]);
    }
    public function delete($id) {
        $sql = "DELETE FROM company_reviews WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
} 