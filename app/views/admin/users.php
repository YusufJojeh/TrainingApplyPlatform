<?php
// app/views/admin/users.php - Modern glassmorphism admin users page with dark table and white data
include __DIR__ . '/../layout/header.php';
if (!isset($students)) $students = [];
if (!isset($companies)) $companies = [];
?>
<div class="container-fluid py-5">
  <?php if (!empty($students)): ?>
  <div class="glass-card p-4 mb-4 mx-auto animate__animated animate__fadeInUp" style="max-width:1400px;">
    <h2 class="gradient-text mb-0 text-white">Manage Students</h2>
    <div id="notification-area"></div>
    <div class="d-flex justify-content-between align-items-center mb-3">
      <a href="?controller=admin&action=createStudent" class="btn btn-glass btn-primary-glass text-white" data-bs-toggle="tooltip" title="Add new student">
        <i class="bi bi-person-plus me-1"></i> Add Student
      </a>
    </div>
    <div class="table-responsive d-flex justify-content-center">
      <table class="table table-dark align-middle glass-card animate__animated animate__fadeIn"
        style="background: rgba(0,0,0,0.85); border-radius: 1.5rem; box-shadow: 0 8px 32px rgba(0,0,0,0.25); overflow: hidden; border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(20px); color: #fff;">
        <thead style="background: rgba(0,0,0,0.95);">
          <tr>
            <th class="text-white">ID</th>
            <th class="text-white">Name</th>
            <th class="text-white">Email</th>
            <th class="text-white">Major/Field</th>
            <th class="text-white">City</th>
            <th class="text-white">Username</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($students as $student): ?>
          <tr style="background: rgba(0,0,0,0.55); color: #fff;">
            <td class="text-white"><?= $student['id'] ?></td>
            <td class="text-white"><?= htmlspecialchars($student['name']) ?></td>
            <td class="text-white"><?= htmlspecialchars($student['email']) ?></td>
            <td class="text-white"><?= htmlspecialchars($student['major']) ?></td>
            <td class="text-white"><?= htmlspecialchars($student['city']) ?></td>
            <td class="text-white"><?= htmlspecialchars($student['username']) ?></td>
            <td>
              <div class="d-flex gap-2">
                <a href="?controller=admin&action=viewStudent&id=<?= $student['id'] ?>" class="btn btn-sm btn-glass btn-outline-warning text-white" data-bs-toggle="tooltip" title="View details" style="border-color: #ffe259; color: #ffe259;"><i class="bi bi-eye"></i></a>
                <a href="?controller=admin&action=editStudent&id=<?= $student['id'] ?>" class="btn btn-sm btn-glass btn-outline-secondary text-white" data-bs-toggle="tooltip" title="Edit student" style="border-color: #aaa; color: #fff;"><i class="bi bi-pencil"></i></a>
                <button type="button" class="btn btn-sm btn-glass btn-outline-danger text-white" data-bs-toggle="modal" data-bs-target="#deleteStudentModal<?= $student['id'] ?>" title="Delete student" style="border-color: #ef4444; color: #ef4444;"><i class="bi bi-trash"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="deleteStudentModal<?= $student['id'] ?>" tabindex="-1" aria-labelledby="deleteStudentModalLabel<?= $student['id'] ?>" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content glass-card animate__animated animate__zoomIn" style="background: #23232a;">
                      <div class="modal-header border-0">
                        <h5 class="modal-title gradient-text text-white" id="deleteStudentModalLabel<?= $student['id'] ?>">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-white-50">
                        Are you sure you want to delete <strong><?= htmlspecialchars($student['name']) ?></strong>?
                      </div>
                      <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="?controller=admin&action=deleteStudent&id=<?= $student['id'] ?>" class="btn btn-danger">Delete</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>
  <?php if (!empty($companies)): ?>
  <div class="glass-card p-4 mx-auto animate__animated animate__fadeInUp" style="max-width:1400px;">
    <h2 class="gradient-text mb-0 text-white">Manage Companies</h2>
    <div id="notification-area"></div>
    <div class="d-flex justify-content-between align-items-center mb-3">
      <a href="?controller=admin&action=createCompany" class="btn btn-glass btn-primary-glass text-white" data-bs-toggle="tooltip" title="Add new company">
        <i class="bi bi-building-add me-1"></i> Add Company
      </a>
    </div>
    <div class="table-responsive d-flex justify-content-center">
      <table class="table table-dark align-middle glass-card animate__animated animate__fadeIn"
        style="background: rgba(0,0,0,0.85); border-radius: 1.5rem; box-shadow: 0 8px 32px rgba(0,0,0,0.25); overflow: hidden; border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(20px); color: #fff;">
        <thead style="background: rgba(0,0,0,0.95);">
          <tr>
            <th class="text-white">ID</th>
            <th class="text-white">Name</th>
            <th class="text-white">Email</th>
            <th class="text-white">Field</th>
            <th class="text-white">City</th>
            <th class="text-white">Username</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($companies as $company): ?>
          <tr style="background: rgba(0,0,0,0.55); color: #fff;">
            <td class="text-white"><?= $company['id'] ?></td>
            <td class="text-white"><?= htmlspecialchars($company['name']) ?></td>
            <td class="text-white"><?= htmlspecialchars($company['email']) ?></td>
            <td class="text-white"><?= htmlspecialchars($company['field']) ?></td>
            <td class="text-white"><?= htmlspecialchars($company['city']) ?></td>
            <td class="text-white"><?= htmlspecialchars($company['username']) ?></td>
            <td>
              <div class="d-flex gap-2">
                <a href="?controller=admin&action=viewCompany&id=<?= $company['id'] ?>" class="btn btn-sm btn-glass btn-outline-warning text-white" data-bs-toggle="tooltip" title="View details" style="border-color: #ffe259; color: #ffe259;"><i class="bi bi-eye"></i></a>
                <a href="?controller=admin&action=editCompany&id=<?= $company['id'] ?>" class="btn btn-sm btn-glass btn-outline-secondary text-white" data-bs-toggle="tooltip" title="Edit company" style="border-color: #aaa; color: #fff;"><i class="bi bi-pencil"></i></a>
                <button type="button" class="btn btn-sm btn-glass btn-outline-danger text-white" data-bs-toggle="modal" data-bs-target="#deleteCompanyModal<?= $company['id'] ?>" title="Delete company" style="border-color: #ef4444; color: #ef4444;"><i class="bi bi-trash"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="deleteCompanyModal<?= $company['id'] ?>" tabindex="-1" aria-labelledby="deleteCompanyModalLabel<?= $company['id'] ?>" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content glass-card animate__animated animate__zoomIn" style="background: #23232a;">
                      <div class="modal-header border-0">
                        <h5 class="modal-title gradient-text text-white" id="deleteCompanyModalLabel<?= $company['id'] ?>">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-white-50">
                        Are you sure you want to delete <strong><?= htmlspecialchars($company['name']) ?></strong>?
                      </div>
                      <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="?controller=admin&action=deleteCompany&id=<?= $company['id'] ?>" class="btn btn-danger">Delete</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.forEach(function(tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
</script>
<?php include __DIR__ . '/../layout/footer.php'; ?>
