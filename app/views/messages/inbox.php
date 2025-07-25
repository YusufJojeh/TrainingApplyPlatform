<?php
// app/views/messages/inbox.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-4">
    <h2 class="gradient-text mb-4">Inbox</h2>
    <table class="table table-hover table-dark table-striped rounded">
      <thead>
        <tr>
          <th>ID</th>
          <th>Sender</th>
          <th>Application</th>
          <th>Content</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($messages as $msg): ?>
        <tr>
          <td><?= $msg['id'] ?></td>
          <td><?= ucfirst($msg['sender_type']) ?> #<?= $msg['sender_id'] ?></td>
          <td><?= $msg['application_id'] ?? '-' ?></td>
          <td><?= htmlspecialchars($msg['content']) ?></td>
          <td><?= $msg['created_at'] ?></td>
          <td>
            <?php if (isset($_SESSION['company_id']) && $msg['sender_type'] === 'student' && !empty($msg['application_id'])): ?>
              <form method="post" action="?controller=message&action=respond" style="display:inline;">
                <input type="hidden" name="student_id" value="<?= $msg['sender_id'] ?>">
                <input type="hidden" name="application_id" value="<?= $msg['application_id'] ?>">
                <button name="status" value="accepted" class="btn btn-sm btn-outline-success">Approve</button>
                <button name="status" value="rejected" class="btn btn-sm btn-outline-danger">Reject</button>
              </form>
            <?php endif; ?>
            <a href="?controller=company&action=viewMessage&id=<?= $msg['id'] ?>" class="btn btn-sm btn-outline-warning">
                <i class="bi bi-eye me-1"></i>View
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 