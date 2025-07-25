<?php
// app/views/admin/company_form.php
include __DIR__ . '/../layout/header.php';
$isEdit = isset($company);
?>
<div class="container py-5">
  <div class="register-card glass-card">
    <h2 class="gradient-text mb-4"><?= $isEdit ? 'Edit Company' : 'Add Company' ?></h2>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required value="<?= $isEdit ? htmlspecialchars($company['name']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required value="<?= $isEdit ? htmlspecialchars($company['email']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="text" name="password" class="form-control" required value="<?= $isEdit ? htmlspecialchars($company['password']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Field</label>
        <input type="text" name="field" class="form-control" required value="<?= $isEdit ? htmlspecialchars($company['field']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required value="<?= $isEdit ? htmlspecialchars($company['username']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"><?= $isEdit ? htmlspecialchars($company['description']) : '' ?></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Website</label>
        <input type="text" name="website" class="form-control" value="<?= $isEdit ? htmlspecialchars($company['website']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Logo (URL)</label>
        <input type="text" name="logo" class="form-control" value="<?= $isEdit ? htmlspecialchars($company['logo']) : '' ?>">
      </div>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger mt-2"> <?= htmlspecialchars($error) ?> </div>
      <?php endif; ?>
      <div class="mb-4">
        <label class="form-label">City</label>
        <input type="text" name="city" class="form-control" required value="<?= $isEdit ? htmlspecialchars($company['city']) : '' ?>">
      </div>
      <div class="d-flex justify-content-between">
        <a href="?controller=admin&action=companies" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-glass btn-primary-glass px-4">Save</button>
      </div>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 