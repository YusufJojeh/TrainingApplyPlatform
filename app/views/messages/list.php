<?php
// app/views/messages/list.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-4">
    <h2 class="gradient-text mb-4">Messages</h2>
    <table class="table table-hover table-dark table-striped rounded">
      <thead>
        <tr>
          <th>ID</th>
          <th>Sender</th>
          <th>Receiver</th>
          <th>Content</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($messages as $msg): ?>
        <tr>
          <td><?= $msg['id'] ?></td>
          <td><?= $msg['sender_type'] ?> #<?= $msg['sender_id'] ?></td>
          <td><?= $msg['receiver_type'] ?> #<?= $msg['receiver_id'] ?></td>
          <td><?= htmlspecialchars($msg['content']) ?></td>
          <td><?= $msg['created_at'] ?></td>
          <td>
            <a href="?action=send&replyTo=<?= $msg['id'] ?>" class="btn btn-sm btn-outline-warning">Reply</a>
            <a href="?action=delete&id=<?= $msg['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this message?')">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="?action=send" class="btn btn-warning fw-bold">Send New Message</a>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 