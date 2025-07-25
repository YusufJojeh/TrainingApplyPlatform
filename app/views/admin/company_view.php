<?php
// app/views/admin/company_view.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-5 mx-auto" style="max-width: 500px;">
    <h2 class="gradient-text mb-4">Company Details</h2>
    <ul class="list-group list-group-flush mb-4">
      <li class="list-group-item bg-transparent text-white-50"><strong>ID:</strong> <?= $company['id'] ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Name:</strong> <?= htmlspecialchars($company['name']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Email:</strong> <?= htmlspecialchars($company['email']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Username:</strong> <?= htmlspecialchars($company['username']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Password:</strong> <?= htmlspecialchars($company['password']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Field:</strong> <?= htmlspecialchars($company['field']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>City:</strong> <?= htmlspecialchars($company['city']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Description:</strong> <?= htmlspecialchars($company['description']) ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Website:</strong> <?php if (!empty($company['website'])): ?><a href="<?= htmlspecialchars($company['website']) ?>" target="_blank">Visit</a><?php else: ?>N/A<?php endif; ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Logo:</strong> <?php if (!empty($company['logo'])): ?><a href="<?= htmlspecialchars($company['logo']) ?>" target="_blank">Logo</a><?php else: ?>N/A<?php endif; ?></li>
      <li class="list-group-item bg-transparent text-white-50"><strong>Created At:</strong> <?= date('Y-m-d H:i', strtotime($company['created_at'])) ?></li>
    </ul>
    <a href="?controller=admin&action=companies" class="btn btn-glass btn-primary-glass">Back to Companies</a>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 