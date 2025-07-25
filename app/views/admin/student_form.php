<?php
// app/views/admin/student_form.php
include __DIR__ . '/../layout/header.php';
$isEdit = isset($student);
?>
<div class="container py-5">
  <div class="register-card glass-card">
    <h2 class="gradient-text mb-4"><?= $isEdit ? 'Edit Student' : 'Add Student' ?></h2>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required value="<?= $isEdit ? htmlspecialchars($student['name']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required value="<?= $isEdit ? htmlspecialchars($student['email']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="text" name="password" class="form-control" required value="<?= $isEdit ? htmlspecialchars($student['password']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required value="<?= $isEdit ? htmlspecialchars($student['username']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">CV (URL)</label>
        <input type="text" name="cv" class="form-control" value="<?= $isEdit ? htmlspecialchars($student['cv']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">LinkedIn (URL)</label>
        <input type="text" name="linkedin" class="form-control" value="<?= $isEdit ? htmlspecialchars($student['linkedin']) : '' ?>">
      </div>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger mt-2"> <?= htmlspecialchars($error) ?> </div>
      <?php endif; ?>
      <div class="mb-3">
        <label class="form-label">Major</label>
        <input type="text" name="major" class="form-control" required value="<?= $isEdit ? htmlspecialchars($student['major']) : '' ?>">
      </div>
      <div class="mb-4">
        <label class="form-label">City</label>
        <input type="text" name="city" class="form-control" required value="<?= $isEdit ? htmlspecialchars($student['city']) : '' ?>">
      </div>
      <div class="d-flex justify-content-between">
        <a href="?controller=admin&action=students" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-glass btn-primary-glass px-4">Save</button>
      </div>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 