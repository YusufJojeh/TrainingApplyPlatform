<?php
// app/views/applications/list.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-4">
    <h2 class="gradient-text mb-4">Applications</h2>
    <table class="table table-hover table-dark table-striped rounded">
      <thead>
        <tr>
          <th>ID</th>
          <th>Student</th>
          <th>Company</th>
          <th>Status</th>
          <th>Comment</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Loop applications here -->
        <?php foreach ($applications as $app): ?>
        <tr>
          <td><?= $app['id'] ?></td>
          <td><?= $app['student_name'] ?? '-' ?></td>
          <td><?= $app['company_name'] ?? '-' ?></td>
          <td><span class="badge bg-warning text-dark fw-bold"><?= ucfirst($app['status']) ?></span></td>
          <td><?= htmlspecialchars($app['comment']) ?></td>
          <td>
            <a href="?action=detail&id=<?= $app['id'] ?>" class="btn btn-sm btn-outline-warning">View</a>
            <a href="?action=update&id=<?= $app['id'] ?>" class="btn btn-sm btn-outline-secondary">Update</a>
            <a href="?action=delete&id=<?= $app['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this application?')">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 