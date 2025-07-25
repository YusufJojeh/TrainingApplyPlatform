<?php
// app/views/errors/500.php
include __DIR__ . '/../layout/header.php';
?>
<div class="container py-5 text-center">
  <div class="glass-card p-5">
    <h1 class="display-1 gradient-text">500</h1>
    <h2 class="mb-4">Server Error</h2>
    <p class="lead">Oops! Something went wrong on our end.</p>
    <a href="/" class="btn btn-warning fw-bold mt-3">Go to Home</a>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?> 