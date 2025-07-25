<?php
// app/views/notifications/list.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-4">
    <h2 class="gradient-text mb-4">Notifications</h2>
    <ul class="list-group list-group-flush">
      <?php foreach ($notifications as $note): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-light rounded mb-2 <?php if(!$note['is_read']) echo 'border-warning'; ?>">
        <span><?= htmlspecialchars($note['message']) ?></span>
        <span>
          <small class="text-muted me-3"><?= $note['created_at'] ?></small>
          <?php if(!$note['is_read']): ?>
            <a href="?action=markAsRead&id=<?= $note['id'] ?>" class="btn btn-sm btn-outline-warning">Mark as Read</a>
          <?php endif; ?>
          <a href="?action=delete&id=<?= $note['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this notification?')">Delete</a>
        </span>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 