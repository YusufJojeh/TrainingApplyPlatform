<?php
// app/views/applications/create.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-4">
    <h2 class="gradient-text mb-4">Apply for Training</h2>
    <form method="post" action="?action=create" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="company_id" class="form-label">Select Company</label>
        <select class="form-select" id="company_id" name="company_id" required>
          <option value="">Choose...</option>
          <?php foreach ($companies as $company): ?>
            <option value="<?= $company['id'] ?>"><?= htmlspecialchars($company['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="subject" class="form-label">Subject</label>
        <input type="text" class="form-control" id="subject" name="subject" placeholder="Cover Letter Subject" required>
      </div>
      <div class="mb-3">
        <label for="cover_letter" class="form-label">Cover Letter</label>
        <textarea class="form-control" id="cover_letter" name="cover_letter" rows="8" placeholder="Write your cover letter here..." required></textarea>
      </div>
      <div class="mb-3">
        <label for="cv" class="form-label">Attach CV (PDF, DOC, DOCX)</label>
        <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
      </div>
      <button type="submit" class="btn btn-warning fw-bold">Send Application</button>
      <a href="?action=list" class="btn btn-outline-secondary">Cancel</a>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 