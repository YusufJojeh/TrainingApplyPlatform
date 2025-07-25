<?php
// app/views/admin/application_form.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="register-card glass-card">
    <h2 class="gradient-text mb-4">Update Application</h2>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <option value="pending" <?= isset($app) && $app['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
          <option value="accepted" <?= isset($app) && $app['status'] === 'accepted' ? 'selected' : '' ?>>Accepted</option>
          <option value="rejected" <?= isset($app) && $app['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
      </div>
      <div class="mb-4">
        <label class="form-label">Comment</label>
        <textarea name="comment" class="form-control" rows="3" required><?= isset($app) ? htmlspecialchars($app['comment']) : '' ?></textarea>
      </div>
      <div class="d-flex justify-content-between">
        <a href="?controller=admin&action=applications" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-glass btn-primary-glass px-4">Save</button>
      </div>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 