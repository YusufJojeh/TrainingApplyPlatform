<?php
// app/views/reviews/list.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-4">
    <h2 class="gradient-text mb-4">Company Reviews</h2>
    <table class="table table-hover table-dark table-striped rounded">
      <thead>
        <tr>
          <th>ID</th>
          <th>Company</th>
          <th>Student</th>
          <th>Rating</th>
          <th>Review</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reviews as $review): ?>
        <tr>
          <td><?= $review['id'] ?></td>
          <td><?= $review['company_name'] ?? '-' ?></td>
          <td><?= $review['student_name'] ?? '-' ?></td>
          <td><span class="badge bg-warning text-dark fw-bold"><?= $review['rating'] ?></span></td>
          <td><?= htmlspecialchars($review['review']) ?></td>
          <td>
            <a href="?action=edit&id=<?= $review['id'] ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
            <a href="?action=delete&id=<?= $review['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this review?')">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="?action=submit" class="btn btn-warning fw-bold">Submit New Review</a>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 