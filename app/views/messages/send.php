<?php
// app/views/messages/send.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-4">
    <h2 class="gradient-text mb-4">Send a Message</h2>
    <form method="post" action="?action=send">
      <div class="mb-3">
        <label for="receiver_type" class="form-label">Receiver Type</label>
        <select class="form-select" id="receiver_type" name="receiver_type" required>
          <option value="">Choose...</option>
          <option value="student">Student</option>
          <option value="company">Company</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="receiver_id" class="form-label">Receiver ID</label>
        <input type="number" class="form-control" id="receiver_id" name="receiver_id" required>
      </div>
      <div class="mb-3">
        <label for="content" class="form-label">Message</label>
        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
      </div>
      <button type="submit" class="btn btn-warning fw-bold">Send</button>
      <a href="?action=list" class="btn btn-outline-secondary">Cancel</a>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 