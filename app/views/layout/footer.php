<?php
// app/views/layout/footer.php - Reusable footer
?>
<footer class="footer-glass animate__animated animate__fadeInUp animate__delay-3s">
    <div class="container py-4 d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="footer-brand mb-3 mb-md-0">
            <span class="fw-bold gradient-text-yellow" style="font-size:1.3rem; letter-spacing:1px;">Training System</span>
            <span class="text-white-50 ms-2" style="font-size:1rem;">&copy; <?php echo date('Y'); ?> All rights reserved.</span>
        </div>
        <div class="footer-social">
            <a href="#" class="footer-icon" title="Twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="footer-icon" title="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="footer-icon" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
            <a href="#" class="footer-icon" title="Email"><i class="bi bi-envelope"></i></a>
        </div>
    </div>
</footer>
<style>
.footer-glass {
    background: rgba(10, 10, 10, 0.85);
    border-top: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 -8px 32px 0 rgba(0,0,0,0.25);
    backdrop-filter: blur(12px) saturate(160%);
    -webkit-backdrop-filter: blur(12px) saturate(160%);
    color: #fff;
    position: relative;
    z-index: 10;
}
.footer-brand {
    display: flex;
    align-items: center;
}
.footer-social {
    display: flex;
    gap: 1.2rem;
}
.footer-icon {
    color: var(--accent-yellow, #ffe259);
    font-size: 1.5rem;
    transition: color 0.2s, transform 0.2s;
    opacity: 0.85;
}
.footer-icon:hover {
    color: #fff;
    transform: scale(1.15) rotate(-6deg);
    opacity: 1;
}
@media (max-width: 767px) {
    .footer-glass .container {
        flex-direction: column !important;
        text-align: center;
    }
    .footer-social {
        justify-content: center;
        margin-top: 0.5rem;
    }
}
</style>
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<!-- Add any additional animation or custom scripts here -->
<script>
// FAQ toggle (accordion) - with debugging and fallback
function initFAQ() {
    console.log('FAQ init started');
    if (typeof $ === 'undefined') {
        console.log('jQuery not loaded, retrying in 100ms');
        setTimeout(initFAQ, 100);
        return;
    }
    
    $(document).ready(function() {
        console.log('Document ready, binding FAQ events');
        
        // Remove any existing click handlers
        $('.faq-question-fancy').off('click');
        
        // Bind new click handlers
        $('.faq-question-fancy').on('click', function(e) {
            console.log('FAQ question clicked:', $(this).text());
            e.preventDefault();
            
            var $this = $(this);
            var $answer = $this.next('.faq-answer-fancy');
            
            if (!$this.hasClass('active')) {
                // Close all other questions
                $('.faq-question-fancy').removeClass('active');
                $('.faq-answer-fancy').slideUp(200);
                
                // Open this question
                $this.addClass('active');
                $answer.slideDown(300);
                console.log('Opening answer');
            } else {
                // Close this question
                $this.removeClass('active');
                $answer.slideUp(200);
                console.log('Closing answer');
            }
        });
        
        console.log('FAQ events bound successfully');
    });
    
    // Parallax shapes
    $(window).on('scroll', function() {
        var scrolled = $(window).scrollTop();
        $('.shape').each(function(index) {
            var speed = (index + 1) * 0.5;
            $(this).css('transform', 'translateY(' + (scrolled * speed) + 'px)');
        });
    });
}

// Initialize FAQ when page loads
initFAQ();

// Also try to initialize when jQuery is loaded
$(document).ready(function() {
    initFAQ();
});
</script>
</body>
</html> 