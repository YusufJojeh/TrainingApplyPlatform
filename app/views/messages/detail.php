<?php include __DIR__ . '/../layout/header.php'; ?>
<?php
// app/views/messages/detail.php
// Assume $message is provided by the controller based on $_GET['id']
if (!isset($message)) {
    echo '<div class="container py-5"><div class="alert alert-danger">Message not found.</div></div>';
    include __DIR__ . '/../layout/footer.php';
    exit;
}
// Optionally, fetch sender/recipient info if needed
?>
<div class="container py-5">
  <div class="row">
    <!-- Sidebar: Sender/Recipient Info -->
    <div class="col-lg-4 mb-4">
      <div class="glass-card p-4 h-100">
        <div class="text-center mb-4">
          <div class="profile-avatar mb-3">
            <?php if ($message['sender_type'] === 'company' && !empty($message['sender_logo'])): ?>
              <img src="<?= htmlspecialchars($message['sender_logo']) ?>" alt="Company Logo" class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
            <?php elseif ($message['sender_type'] === 'student'): ?>
              <i class="bi bi-person display-1 text-warning"></i>
            <?php else: ?>
              <i class="bi bi-building display-1 text-warning"></i>
            <?php endif; ?>
          </div>
          <h3 class="gradient-text-yellow mb-2 text-white">
            <?= htmlspecialchars($message['sender_name'] ?? ucfirst($message['sender_type']) . ' #' . $message['sender_id']) ?>
          </h3>
          <p class="text-white-50 mb-1">
            <?= htmlspecialchars($message['sender_field'] ?? '') ?>
          </p>
          <p class="text-white-50 mb-3">
            <?= htmlspecialchars($message['sender_city'] ?? '') ?>
          </p>
          <div class="d-grid gap-2">
            <a href="inbox.php" class="btn btn-glass btn-outline-warning">
              <i class="bi bi-arrow-left me-2"></i>Back to Inbox
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Main: Message Details -->
    <div class="col-lg-8">
      <div class="glass-card p-4">
        <h2 class="gradient-text-yellow mb-4 text-white">
          <i class="bi bi-envelope-open me-2"></i>Message Details
        </h2>
        <dl class="row text-white">
          <dt class="col-sm-3">From:</dt>
          <dd class="col-sm-9"> <?= htmlspecialchars($message['sender_name'] ?? ucfirst($message['sender_type']) . ' #' . $message['sender_id']) ?> </dd>
          <dt class="col-sm-3">To:</dt>
          <dd class="col-sm-9"> <?= htmlspecialchars($message['recipient_name'] ?? ucfirst($message['recipient_type']) . ' #' . $message['recipient_id']) ?> </dd>
          <dt class="col-sm-3">Subject:</dt>
          <dd class="col-sm-9"> <?= htmlspecialchars($message['subject']) ?> </dd>
          <dt class="col-sm-3">Application:</dt>
          <dd class="col-sm-9">
            <?php if (!empty($message['application_id'])): ?>
              <a href="../applications/detail.php?id=<?= $message['application_id'] ?>" class="text-info">Application #<?= $message['application_id'] ?></a>
            <?php else: ?>
              -
            <?php endif; ?>
          </dd>
          <dt class="col-sm-3">Date:</dt>
          <dd class="col-sm-9"> <?= htmlspecialchars($message['created_at']) ?> </dd>
        </dl>
        <hr class="my-4">
        <div class="mb-4">
          <h5 class="text-warning mb-3"><i class="bi bi-chat-text me-2"></i>Message Content</h5>
          <div class="bg-dark rounded p-3 text-white" style="min-height:120px;">
            <?= nl2br(htmlspecialchars($message['content'])) ?>
          </div>
        </div>
        <!-- Optionally, add reply or action buttons here -->
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 