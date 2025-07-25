<?php
// app/views/messages/response.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-4">
    <h2 class="gradient-text mb-4">Respond to Application</h2>
    <form method="post" action="?controller=message&action=respond">
      <input type="hidden" name="student_id" value="<?= htmlspecialchars($_POST['student_id'] ?? '') ?>">
      <input type="hidden" name="application_id" value="<?= htmlspecialchars($_POST['application_id'] ?? '') ?>">
      <div class="mb-3">
        <label for="status" class="form-label">Response</label>
        <select class="form-select" id="status" name="status" required>
          <option value="">Choose...</option>
          <option value="accepted">Approve</option>
          <option value="rejected">Reject</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="comment" class="form-label">Comment (optional)</label>
        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-warning fw-bold">Send Response</button>
      <a href="?controller=message&action=inbox" class="btn btn-outline-secondary">Cancel</a>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 