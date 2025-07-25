<?php include __DIR__ . '/../layout/header.php'; ?>
<style>
.main-content { padding-top: 90px; }
.gradient-text-yellow {
    background: linear-gradient(90deg, #ffe259 0%, #ffa751 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
}
.cta-section {
    background: var(--secondary-gradient);
    color: var(--accent-black);
    border-radius: 2rem;
    box-shadow: var(--glass-shadow);
    padding: 3rem 2rem;
    margin: 4rem 0 2rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.cta-section .btn {
    font-size: 1.3rem;
    padding: 1rem 3rem;
    border-radius: 2rem;
    font-weight: 700;
    margin-top: 2rem;
    box-shadow: 0 8px 32px rgba(255, 221, 51, 0.18);
    transition: background 0.2s, color 0.2s, transform 0.2s;
}
.cta-section .btn:hover {
    background: var(--accent-black);
    color: var(--accent-yellow);
    transform: scale(1.05);
}
.testimonial-card {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: 1.5rem;
    box-shadow: var(--glass-shadow);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    color: var(--accent-yellow);
    position: relative;
    min-height: 200px;
}
.testimonial-card .bi {
    font-size: 2rem;
    color: var(--accent-yellow);
    opacity: 0.7;
}
.faq-section {
    margin: 4rem 0 2rem 0;
}
.faq-question {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: 1rem;
    margin-bottom: 1rem;
    padding: 1.25rem 1.5rem;
    color: var(--accent-yellow);
    cursor: pointer;
    transition: background 0.2s;
}
.faq-question:hover {
    background: rgba(255, 221, 51, 0.18);
}
.faq-answer {
    display: none;
    padding: 1rem 1.5rem 1.5rem 1.5rem;
    color: var(--text-light);
    background: transparent;
}
.faq-question.active + .faq-answer {
    display: block;
    animation: fadeInUp 0.7s;
}
.cta-section.glass-liquid {
    background: rgba(10, 10, 10, 0.7);
    border-radius: 2rem;
    box-shadow: 0 8px 32px 0 rgba(0,0,0,0.37);
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    border: 1px solid rgba(255,255,255,0.18);
    position: relative;
    overflow: hidden;
}
.liquid-bg {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    z-index: 1;
    pointer-events: none;
    background: radial-gradient(circle at 20% 40%, rgba(255,255,255,0.08) 0%, transparent 60%),
                radial-gradient(circle at 80% 60%, rgba(255,255,255,0.10) 0%, transparent 70%),
                linear-gradient(120deg, rgba(30,30,30,0.7) 0%, rgba(0,0,0,0.8) 100%);
    animation: liquidMove 8s ease-in-out infinite alternate;
    border-radius: 2rem;
}
@keyframes liquidMove {
    0% {
        background-position: 0% 0%, 100% 100%, 0% 0%;
    }
    100% {
        background-position: 100% 100%, 0% 0%, 100% 100%;
    }
}
.faq-section.glass-liquid-faq {
    background: rgba(10, 10, 10, 0.8);
    border-radius: 2rem;
    box-shadow: 0 8px 32px 0 rgba(0,0,0,0.37);
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    border: 1px solid rgba(255,255,255,0.18);
    position: relative;
    overflow: hidden;
    margin: 4rem 0 2rem 0;
}
.liquid-bg-faq {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    z-index: 1;
    pointer-events: none;
    background: radial-gradient(circle at 30% 60%, rgba(255,255,255,0.08) 0%, transparent 60%),
                radial-gradient(circle at 70% 30%, rgba(255,255,255,0.10) 0%, transparent 70%),
                linear-gradient(120deg, rgba(30,30,30,0.7) 0%, rgba(0,0,0,0.8) 100%);
    animation: liquidMoveFaq 10s ease-in-out infinite alternate;
    border-radius: 2rem;
}
@keyframes liquidMoveFaq {
    0% {
        background-position: 0% 0%, 100% 100%, 0% 0%;
    }
    100% {
        background-position: 100% 100%, 0% 0%, 100% 100%;
    }
}
.faq-item {
    background: rgba(30,30,30,0.7);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 1.2rem;
    margin-bottom: 1.2rem;
    box-shadow: 0 2px 12px 0 rgba(0,0,0,0.12);
    overflow: hidden;
}
.faq-question-fancy {
    color: var(--accent-yellow, #ffe259);
    font-size: 1.2rem;
    font-weight: 600;
    padding: 1.25rem 1.5rem;
    cursor: pointer;
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.2s;
    user-select: none;
}
.faq-question-fancy.active, .faq-question-fancy:hover {
    background: rgba(255, 221, 51, 0.10);
}
.faq-answer-fancy {
    display: none;
    padding: 1rem 1.5rem 1.5rem 1.5rem;
    color: var(--text-light, #fff);
    background: transparent;
    animation: fadeInUp 0.7s;
}
.faq-question-fancy.active + .faq-answer-fancy {
    display: block;
}
</style>
<div class="main-content">
<!-- HERO SECTION -->
<section class="hero">
    <div class="shape shape1"></div>
    <div class="shape shape2"></div>
    <div class="shape shape3"></div>
    <div class="shape shape4"></div>
    <div class="container hero-content">
        <h1 class="display-1 fw-bold mb-4 animate__animated animate__fadeInDown gradient-text-yellow">
            Platform for Practical Training
        </h1>
        <p class="lead mb-5 animate__animated animate__fadeInUp animate__delay-1s">
            Join 10,000+ students and 2,000+ companies already using <b>Training System</b> to launch their future.<br>
            <span class="fw-bold text-yellow-50">Find your dream internship or your next top talent today!</span>
        </p>
        <div class="hero-cta animate__animated animate__fadeInUp animate__delay-2s">
            <a href="?controller=student&action=register" class="btn btn-glass btn-primary-glass">
                <i class="bi bi-person-plus me-2"></i>Get Started as Student
            </a>
            <a href="?controller=company&action=register" class="btn btn-glass">
                <i class="bi bi-building-add me-2"></i>Get Started as Company
            </a>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="section" id="features" style="opacity:1;transform:none;">
    <div class="container py-5">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-4 fw-bold mb-3 gradient-text-yellow">Why Training System?</h2>
                <p class="lead text-white-50">The most trusted, innovative, and effective way to connect students and companies for practical training.</p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="glass-card h-100 animate__animated animate__zoomIn">
                    <div class="mb-4">
                        <div class="feature-icon">
                            <i class="bi bi-lightbulb display-1 text-white-50"></i>
                        </div>
                    </div>
                    <h4 class="mb-3 gradient-text-yellow">Smart Matching</h4>
                    <p class="text-white-50">Our AI-powered system matches students with the best companies and opportunities in seconds.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="glass-card h-100 animate__animated animate__zoomIn animate__delay-1s">
                    <div class="mb-4">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up-arrow display-1 text-white-50"></i>
                        </div>
                    </div>
                    <h4 class="mb-3 gradient-text-yellow">Real-Time Tracking</h4>
                    <p class="text-white-50">Track every application, get instant feedback, and never miss an opportunity with live notifications.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="glass-card h-100 animate__animated animate__zoomIn animate__delay-2s">
                    <div class="mb-4">
                        <div class="feature-icon">
                            <i class="bi bi-people-fill display-1 text-white-50"></i>
                        </div>
                    </div>
                    <h4 class="mb-3 gradient-text-yellow">Community & Support</h4>
                    <p class="text-white-50">24/7 support, a vibrant community, and resources to help you succeed at every step.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS SECTION -->
<section class="section" id="stats" style="opacity:1;transform:none;">
    <div class="container py-5">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="glass-card">
                    <div class="stat-number display-4 fw-bold gradient-text-yellow mb-2">10,000+</div>
                    <div class="text-white-50">Active Students</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="glass-card">
                    <div class="stat-number display-4 fw-bold gradient-text-yellow mb-2">2,000+</div>
                    <div class="text-white-50">Partner Companies</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="glass-card">
                    <div class="stat-number display-4 fw-bold gradient-text-yellow mb-2">15,000+</div>
                    <div class="text-white-50">Applications Processed</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="glass-card">
                    <div class="stat-number display-4 fw-bold gradient-text-yellow mb-2">98%</div>
                    <div class="text-white-50">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section class="section" id="testimonials" style="opacity:1;transform:none;">
    <div class="container py-5">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold mb-3 gradient-text-yellow">Loved by Students & Companies</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card animate__animated animate__fadeInLeft">
                    <div class="testimonial-icon mb-3">
                        <i class="bi bi-mortarboard-fill" style="font-size:2.5rem;color:#ffe259;"></i>
                    </div>
                    <p class="mb-3 gradient-text-yellow">“I landed my dream internship in less than a week! The process was smooth and the support team is amazing.”</p>
                    <div class="fw-bold gradient-text-yellow">— Fatima, Economics Student</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card animate__animated animate__fadeInRight animate__delay-1s">
                    <div class="testimonial-icon mb-3">
                        <i class="bi bi-briefcase-fill" style="font-size:2.5rem;color:#ffe259;"></i>
                    </div>
                    <p class="mb-3 gradient-text-yellow">“We hired three talented interns this summer. Training System is a game changer for our HR!”</p>
                    <div class="fw-bold gradient-text-yellow">— Mr. Khaled, CEO, Tech Innovators</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="testimonial-icon mb-3">
                        <i class="bi bi-bell-fill" style="font-size:2.5rem;color:#ffe259;"></i>
                    </div>
                    <p class="mb-3 gradient-text-yellow">“The dashboard is so easy to use and I love the instant notifications. Highly recommended!”</p>
                    <div class="fw-bold gradient-text-yellow">— Layla, Student</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CALL TO ACTION SECTION -->
<section class="cta-section glass-liquid animate__animated animate__fadeInUp" style="min-height: 350px; position:relative; overflow:hidden;">
    <div class="liquid-bg"></div>
    <div class="container py-5 position-relative" style="z-index:2;">
        <h2 class="display-5 fw-bold mb-3 gradient-text-yellow text-white">Ready to Join the Future?</h2>
        <p class="lead mb-4 text-white">Sign up now and become part of the fastest-growing training network in the region.</p>
        <a href="?controller=student&action=register" class="btn btn-primary-glass btn-glass me-3 text-white">
            <i class="bi bi-person-plus me-2"></i>Sign Up as Student
        </a>
        <a href="?controller=company&action=register" class="btn btn-glass text-white">
            <i class="bi bi-building-add me-2"></i>Sign Up as Company
        </a>
    </div>
</section>

<!-- FAQ SECTION -->
<section class="faq-section glass-liquid-faq">
    <div class="liquid-bg-faq"></div>
    <div class="container position-relative" style="z-index:2;">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-6 fw-bold mb-3 gradient-text-yellow">Frequently Asked Questions</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="faq-item mb-3">
                    <div class="faq-question-fancy">Is Training System really free? <i class="bi bi-chevron-down ms-2"></i></div>
                    <div class="faq-answer-fancy">Yes! All core features are free for both students and companies. No hidden fees.</div>
                </div>
                <div class="faq-item mb-3">
                    <div class="faq-question-fancy">How fast can I get matched? <i class="bi bi-chevron-down ms-2"></i></div>
                    <div class="faq-answer-fancy">Most students get their first company match within 48 hours of signing up!</div>
                </div>
                <div class="faq-item mb-3">
                    <div class="faq-question-fancy">What kind of companies are on the platform? <i class="bi bi-chevron-down ms-2"></i></div>
                    <div class="faq-answer-fancy">From global tech giants to local startups, we have 2,000+ companies in all fields.</div>
                </div>
                <div class="faq-item mb-3">
                    <div class="faq-question-fancy">Can I get support if I need help? <i class="bi bi-chevron-down ms-2"></i></div>
                    <div class="faq-answer-fancy">Absolutely! Our support team is available 24/7 via chat and email.</div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
<script>
// FAQ toggle (accordion)
$(document).ready(function() {
    $('.faq-question-fancy').click(function() {
        if (!$(this).hasClass('active')) {
            $('.faq-question-fancy').removeClass('active');
            $('.faq-answer-fancy').slideUp(200);
            $(this).addClass('active').next('.faq-answer-fancy').slideDown(300);
        } else {
            $(this).removeClass('active').next('.faq-answer-fancy').slideUp(200);
        }
    });
    // Parallax shapes (keep existing)
    $(window).on('scroll', function() {
        var scrolled = $(window).scrollTop();
        $('.shape').each(function(index) {
            var speed = (index + 1) * 0.5;
            $(this).css('transform', 'translateY(' + (scrolled * speed) + 'px)');
        });
    });
});
</script>
