<?php
// app/views/admin/application_view.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-5 mx-auto" style="max-width: 500px;">
    <h2 class="gradient-text mb-4">Application Details</h2>
    <ul class="list-group list-group-flush mb-4">
      <li class="list-group-item bg-transparent text-white-50"><strong>ID:</strong> <?= $app['id'] ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Student:</strong> <?= htmlspecialchars($app['student_id'] ?? $app['student_name'] ?? '') ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Company:</strong> <?= htmlspecialchars($app['company_id'] ?? $app['company_name'] ?? '') ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Status:</strong> <span class="badge bg-<?= $app['status'] === 'accepted' ? 'success' : ($app['status'] === 'rejected' ? 'danger' : 'warning') ?> text-dark fw-bold"><?= ucfirst($app['status']) ?></span></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Comment:</strong> <?= htmlspecialchars($app['comment']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Created At:</strong> <?= htmlspecialchars($app['created_at']) ?></li>
    </ul>
    <a href="?controller=admin&action=applications" class="btn btn-glass btn-primary-glass">Back to Applications</a>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 