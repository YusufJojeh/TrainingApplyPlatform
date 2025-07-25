<?php
// app/views/applications/update.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-4">
    <h2 class="gradient-text mb-4">Update Application</h2>
    <form method="post" action="?action=update&id=<?= $application['id'] ?>">
      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status" required>
          <option value="pending" <?= $application['status']==='pending'?'selected':'' ?>>Pending</option>
          <option value="accepted" <?= $application['status']==='accepted'?'selected':'' ?>>Accepted</option>
          <option value="rejected" <?= $application['status']==='rejected'?'selected':'' ?>>Rejected</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="comment" class="form-label">Comment</label>
        <textarea class="form-control" id="comment" name="comment" rows="3"><?= htmlspecialchars($application['comment']) ?></textarea>
      </div>
      <button type="submit" class="btn btn-warning fw-bold">Update</button>
      <a href="?action=detail&id=<?= $application['id'] ?>" class="btn btn-outline-secondary">Cancel</a>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 