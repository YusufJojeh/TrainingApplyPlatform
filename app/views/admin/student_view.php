<?php
// app/views/admin/student_view.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-5 mx-auto" style="max-width: 500px;">
    <h2 class="gradient-text mb-4">Student Details</h2>
    <ul class="list-group list-group-flush mb-4">
      <li class="list-group-item bg-transparent text-white-50"><strong>ID:</strong> <?= $student['id'] ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Name:</strong> <?= htmlspecialchars($student['name']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Username:</strong> <?= htmlspecialchars($student['username']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Password:</strong> <?= htmlspecialchars($student['password']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Major:</strong> <?= htmlspecialchars($student['major']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>City:</strong> <?= htmlspecialchars($student['city']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>CV:</strong> <?php if (!empty($student['cv'])): ?><a href="<?= htmlspecialchars($student['cv']) ?>" target="_blank">View CV</a><?php else: ?>N/A<?php endif; ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>LinkedIn:</strong> <?php if (!empty($student['linkedin'])): ?><a href="<?= htmlspecialchars($student['linkedin']) ?>" target="_blank">Profile</a><?php else: ?>N/A<?php endif; ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Created At:</strong> <?= date('Y-m-d H:i', strtotime($student['created_at'])) ?></li>
    </ul>
    <a href="?controller=admin&action=students" class="btn btn-glass btn-primary-glass">Back to Students</a>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 