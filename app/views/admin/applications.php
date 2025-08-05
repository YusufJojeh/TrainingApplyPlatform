<?php
// app/views/admin/applications.php - Modern glassmorphism admin applications page
include __DIR__ . '/../layout/header.php';
?>
<div class="main-content">
    <div class="container-fluid py-5">
        <div class="glass-card p-4 mx-auto animate__animated animate__fadeInUp" style="max-width:1400px;">
            <h2 class="gradient-text-yellow mb-4">Manage Applications</h2>
            <div id="notification-area"></div>
            <div class="table-responsive d-flex justify-content-center">
                <table class="table table-dark align-middle glass-card animate__animated animate__fadeIn">
                    <thead>
                        <tr>
                            <th class="text-white">ID</th>
                            <th class="text-white">Student</th>
                            <th class="text-white">Company</th>
                            <th class="text-white">Status</th>
                            <th class="text-white">Comment</th>
                            <th class="text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $app): ?>
                        <tr>
                            <td class="text-white fw-bold align-middle"><?= $app['id'] ?></td>
                            <td class="text-white align-middle"><?= htmlspecialchars($app['student_name']) ?></td>
                            <td class="text-white align-middle"><?= htmlspecialchars($app['company_name']) ?></td>
                            <td class="align-middle">
                                <span class="badge bg-<?= $app['status'] === 'accepted' ? 'success' : ($app['status'] === 'rejected' ? 'danger' : 'warning') ?> text-white fw-bold">
                                    <?= ucfirst($app['status']) ?>
                                </span>
                            </td>
                            <td class="text-white align-middle"><?= htmlspecialchars($app['comment']) ?></td>
                            <td class="align-middle">
                                <div class="d-flex gap-2">
                                    <a href="?controller=admin&action=viewApp&id=<?= $app['id'] ?>" 
                                       class="btn btn-sm btn-glass btn-outline-warning text-white" 
                                       data-bs-toggle="tooltip" title="View details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="?controller=admin&action=updateApp&id=<?= $app['id'] ?>" 
                                       class="btn btn-sm btn-glass btn-outline-secondary text-white" 
                                       data-bs-toggle="tooltip" title="Edit application">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-glass btn-outline-danger text-white" 
                                            data-bs-toggle="modal" data-bs-target="#deleteAppModal<?= $app['id'] ?>" 
                                            title="Delete application">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteAppModal<?= $app['id'] ?>" tabindex="-1" 
                                         aria-labelledby="deleteAppModalLabel<?= $app['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content glass-card animate__animated animate__zoomIn">
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title gradient-text-yellow" id="deleteAppModalLabel<?= $app['id'] ?>">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-white-50">
                                                    Are you sure you want to delete application <strong>#<?= $app['id'] ?></strong>?
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="?controller=admin&action=deleteApp&id=<?= $app['id'] ?>" class="btn btn-danger">Delete</a>
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
    </div>
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