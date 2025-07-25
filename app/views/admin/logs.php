<?php
// app/views/admin/logs.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-4 mb-4">
    <h2 class="gradient-text mb-4">Admin Logs</h2>
    <div class="table-responsive d-flex justify-content-center">
      <table class="table table-dark align-middle glass-card animate__animated animate__fadeIn"
        style="background: rgba(0,0,0,0.85); border-radius: 1.5rem; box-shadow: 0 8px 32px rgba(0,0,0,0.25); overflow: hidden; border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(20px); color: #fff;">
        <thead style="background: rgba(0,0,0,0.95);">
          <tr>
            <th class="text-white">ID</th>
            <th class="text-white">Admin</th>
            <th class="text-white">Action</th>
            <th class="text-white">Details</th>
            <th class="text-white">Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($admin_logs as $log): ?>
          <tr style="background: rgba(0,0,0,0.55); border-radius: 1rem; color: #fff; transition: background 0.2s;">
            <td class="text-white align-middle"><?= $log['id'] ?></td>
            <td class="text-white align-middle"><?= $log['admin_id'] ?></td>
            <td class="text-white align-middle"><?= htmlspecialchars($log['action']) ?></td>
            <td class="text-white align-middle"><?= htmlspecialchars($log['details']) ?></td>
            <td class="text-white align-middle"><?= $log['created_at'] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="glass-card p-4">
    <h2 class="gradient-text mb-4">Activity Logs</h2>
    <div class="table-responsive d-flex justify-content-center">
      <table class="table table-dark align-middle glass-card animate__animated animate__fadeIn"
        style="background: rgba(0,0,0,0.85); border-radius: 1.5rem; box-shadow: 0 8px 32px rgba(0,0,0,0.25); overflow: hidden; border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(20px); color: #fff;">
        <thead style="background: rgba(0,0,0,0.95);">
          <tr>
            <th class="text-white">ID</th>
            <th class="text-white">User</th>
            <th class="text-white">User Type</th>
            <th class="text-white">Activity</th>
            <th class="text-white">Details</th>
            <th class="text-white">Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($activity_logs as $log): ?>
          <tr style="background: rgba(0,0,0,0.55); border-radius: 1rem; color: #fff; transition: background 0.2s;">
            <td class="text-white align-middle"><?= $log['id'] ?></td>
            <td class="text-white align-middle"><?= $log['user_id'] ?></td>
            <td class="text-white align-middle"><?= $log['user_type'] ?></td>
            <td class="text-white align-middle"><?= htmlspecialchars($log['activity']) ?></td>
            <td class="text-white align-middle"><?= htmlspecialchars($log['details']) ?></td>
            <td class="text-white align-middle"><?= $log['created_at'] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 