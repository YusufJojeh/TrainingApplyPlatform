<?php
// app/views/reviews/submit.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5">
  <div class="glass-card p-4">
    <h2 class="gradient-text mb-4">Submit a Review</h2>
    <form method="post" action="?action=submit">
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
        <label for="rating" class="form-label">Rating</label>
        <select class="form-select" id="rating" name="rating" required>
          <option value="">Choose...</option>
          <?php for ($i=1; $i<=5; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="review" class="form-label">Review</label>
        <textarea class="form-control" id="review" name="review" rows="3" required></textarea>
      </div>
      <button type="submit" class="btn btn-warning fw-bold">Submit</button>
      <a href="?action=list" class="btn btn-outline-secondary">Cancel</a>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 