<div class="glass-card">
  <h2 class="text-center mb-4" style="color:#fff;">Manage Users</h2>
  <table class="glass-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td>
          <?php if ($user['role'] === 'Vendor'): ?>
            <span class="badge-vendor">Vendor</span>
          <?php elseif ($user['role'] === 'Client'): ?>
            <span class="badge-client">Client</span>
          <?php elseif ($user['role'] === 'Admin'): ?>
            <span class="badge-admin">Admin</span>
          <?php else: ?>
            <span><?= htmlspecialchars($user['role']) ?></span>
          <?php endif; ?>
        </td>
        <td>
          <button class="action-btn"><i class="bi bi-pencil"></i></button>
          <?php if ($user['role'] !== 'Admin'): ?>
            <button class="action-btn"><i class="bi bi-trash"></i></button>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<style>
.glass-card {
  background: rgba(255,255,255,0.15);
  border-radius: 2rem;
  box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,0.18);
  padding: 2rem;
  margin: 2rem auto;
  max-width: 900px;
}
.glass-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  background: transparent;
}
.glass-table th, .glass-table td {
  background: rgba(255,255,255,0.10);
  color: #fff;
  padding: 1rem 1.5rem;
  border: none;
  font-size: 1.1rem;
}
.glass-table th {
  font-size: 1.2rem;
  font-weight: bold;
  letter-spacing: 1px;
  background: rgba(255,255,255,0.18);
}
.glass-table tr {
  border-radius: 1.5rem;
}
.glass-table tr:not(:last-child) {
  border-bottom: 1px solid rgba(255,255,255,0.10);
}
.badge-vendor {
  background: #ffe259;
  color: #7a5c00;
  border-radius: 1rem;
  padding: 0.3em 1em;
  font-weight: 600;
  font-size: 1em;
  box-shadow: 0 2px 8px rgba(255,226,89,0.15);
}
.badge-client {
  background: #b2f7ef;
  color: #006d5b;
  border-radius: 1rem;
  padding: 0.3em 1em;
  font-weight: 600;
  font-size: 1em;
  box-shadow: 0 2px 8px rgba(178,247,239,0.15);
}
.badge-admin {
  background: #ffb3b3;
  color: #a10000;
  border-radius: 1rem;
  padding: 0.3em 1em;
  font-weight: 600;
  font-size: 1em;
  box-shadow: 0 2px 8px rgba(255,179,179,0.15);
}
.action-btn {
  background: #fff;
  border: none;
  border-radius: 50%;
  padding: 0.5em 0.7em;
  margin: 0 0.2em;
  color: #6c63ff;
  font-size: 1.1em;
  transition: background 0.2s;
  cursor: pointer;
}
.action-btn:hover {
  background: #e0e0e0;
}
</style> 