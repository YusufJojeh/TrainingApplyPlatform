<?php
// app/views/messages/send_application.php
include __DIR__ . '/../layout/header.php';
$company_id = $_GET['company_id'] ?? $_POST['company_id'] ?? '';
$application_id = $_GET['application_id'] ?? $_POST['application_id'] ?? '';
?>
<div class="container py-5">
  <div class="glass-card p-4">
    <h2 class="gradient-text mb-4">Send Application Message</h2>
    <form method="post" action="?controller=message&action=sendApplication">
      <input type="hidden" name="company_id" value="<?= htmlspecialchars($company_id) ?>">
      <input type="hidden" name="application_id" value="<?= htmlspecialchars($application_id) ?>">
      <div class="mb-3">
        <label for="content" class="form-label">Message to Company</label>
        <textarea class="form-control" id="content" name="content" rows="4" required placeholder="Write your application message..."></textarea>
      </div>
      <button type="submit" class="btn btn-warning fw-bold">Send Application</button>
      <a href="?controller=student&action=dashboard" class="btn btn-outline-secondary">Cancel</a>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 