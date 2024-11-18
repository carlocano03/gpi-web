<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/logo-no-bg.png');?>" />
    <title>GPI - God's People's Initiative</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
    :root {
        --gpi-blue: #2563eb;
        --gpi-red: #ff4b4b;
        --gpi-yellow: #fbbf24;
        --gpi-dark: #111827;
        --gpi-gradient: linear-gradient(135deg, var(--gpi-blue), var(--gpi-red));
    }

    body {
        overflow-x: hidden;
    }

    .hero-gradient {
        background:
            linear-gradient(135deg, var(--gpi-blue), var(--gpi-red)),
            radial-gradient(circle at top right, var(--gpi-yellow) 0%, transparent 60%),
            radial-gradient(circle at bottom left, #4F46E5 0%, transparent 50%);
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    .hero-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background:
            url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.1;
        animation: patternMove 30s linear infinite;
    }

    @keyframes patternMove {
        0% {
            background-position: 0 0;
        }

        100% {
            background-position: 100px 100px;
        }
    }

    .navbar {
        background: rgba(255, 255, 255, 0.1) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        transition: all 0.4s ease;
        padding: 1.5rem 0;
        z-index: 1000;
    }

    .navbar.scrolled {
        background: rgba(255, 255, 255, 0.98) !important;
        padding: 1rem 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .nav-link {
        font-weight: 500;
        margin: 0 1rem;
        transition: all 0.3s;
        position: relative;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gpi-yellow);
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    .btn {
        border-radius: 50px;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .btn-primary {
        background: var(--gpi-gradient);
        border: none;
        padding: 0.8rem 2rem;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
    }

    .feature-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 1.5rem;
        padding: 2.5rem;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .feature-icon {
        font-size: 3rem;
        margin-bottom: 1.5rem;
        background: var(--gpi-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .stats-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 1.5rem;
        padding: 2.5rem;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.4s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px) scale(1.03);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .stats-number {
        font-size: 3.5rem;
        font-weight: 800;
        background: var(--gpi-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .cta-section {
        background: var(--gpi-gradient);
        color: white;
        padding: 8rem 0;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before,
    .cta-section::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
    }

    .cta-section::before {
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: var(--gpi-yellow);
        animation: float 6s ease-in-out infinite;
    }

    .cta-section::after {
        bottom: -100px;
        left: -100px;
        width: 300px;
        height: 300px;
        background: var(--gpi-blue);
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    footer {
        background: var(--gpi-dark);
        color: white;
        padding: 6rem 0 4rem;
        position: relative;
        overflow: hidden;
    }

    footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.2) 50%,
                transparent 100%);
    }

    .footer-title {
        color: white;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 40px;
        height: 2px;
        background: var(--gpi-gradient);
    }

    .footer-link {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s;
        display: block;
        margin-bottom: 0.8rem;
    }

    .footer-link:hover {
        color: white;
        transform: translateX(5px);
    }

    .social-icon {
        width: 45px;
        height: 45px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        margin: 0 0.5rem;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        font-size: 1.2rem;
    }

    .social-icon:hover {
        background: var(--gpi-gradient);
        transform: translateY(-3px) scale(1.1);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    .newsletter-input {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        padding: 0.8rem 1.5rem;
        color: white;
        transition: all 0.3s;
    }

    .newsletter-input:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
    }

    .newsletter-input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .footer-bottom {
        position: relative;
        padding-top: 2rem;
        margin-top: 4rem;
    }

    .footer-bottom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        height: 1px;
        background: linear-gradient(90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.2) 50%,
                transparent 100%);
    }

    @media (max-width: 768px) {
        .navbar {
            padding: 1rem 0;
        }

        .feature-card,
        .stats-card {
            padding: 1.5rem;
        }

        .stats-number {
            font-size: 2.5rem;
        }

        .footer-column {
            margin-bottom: 2rem;
        }
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="#">
                <img src="<?php echo base_url('assets/images/logo-w-bg.jpg'); ?>" alt="Logo"
                    style="width:54px;height:52px; border-radius:100%;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#features">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#cta-section">Download</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#footer">Contact</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="btn btn-light rounded-pill text-white px-4 fw-medium" href="#join"
                            style="background: linear-gradient(45deg, #FF6B6B, #FF8E53);">
                            Download App
                            <i class="fa-solid fa-mobile ms-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="home" class="hero-gradient d-flex align-items-center mt-5 mt-lg-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-up">
                    <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill">Welcome to GPI</span>
                    <h1 class="display-4 fw-bold text-white mb-4">Making a Positive Impact Together</h1>
                    <p class="lead text-white opacity-90 mb-4">Join our community of like-minded individuals dedicated
                        to creating meaningful change through collective action.</p>
                    <div class="d-inline-block">
                        <a href="#join" class="btn btn-lg" style="
								background: linear-gradient(45deg, #FF6B6B, #FF8E53);
								color: white;
								padding: 12px 28px;
								border-radius: 50px;
								border: none;
								font-weight: 500;
								box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
								transition: all 0.3s ease;
							">
                            Download Our App - Join Today
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16" style="margin-left: 8px;">
                                <path
                                    d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0" data-aos="fade-left" data-aos-delay="200">
                    <img src="<?php echo base_url('assets/images/bg-pic-2.avif'); ?>" alt="Logo"
                        class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="badge bg-primary bg-gradient px-3 py-2 rounded-pill mb-3">Why Choose Us</span>
                <h2 class="display-5 fw-bold mb-3">Empowering Change Together</h2>
                <p class="lead text-muted">Experience the power of community and make a lasting difference</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card h-100">
                        <i class="fas fa-users feature-icon"></i>
                        <h3 class="h4 mb-3">Community Connection</h3>
                        <p class="text-muted mb-0">Connect with fellow members and participate in meaningful discussions
                        </p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card h-100">
                        <i class="fas fa-calendar-alt feature-icon"></i>
                        <h3 class="h4 mb-3">Events & Gatherings</h3>
                        <p class="text-muted mb-0">Join regular events</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card h-100">
                        <i class="fas fa-file-signature feature-icon"></i>
                        <h3 class="h4 mb-3">Petitions & Initiatives</h3>
                        <p class="text-muted mb-0">Support important causes and make your voice heard</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-3 col-6" data-aos="fade-up">
                    <div class="stats-card">
                        <div class="stats-number">5,000+</div>
                        <div class="text-muted fw-medium">Active Members</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stats-card">
                        <div class="stats-number">200+</div>
                        <div class="text-muted fw-medium">Download App</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stats-card">
                        <div class="stats-number">1,000+</div>
                        <div class="text-muted fw-medium">Petitions Signed</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stats-card">
                        <div class="stats-number">50+</div>
                        <div class="text-muted fw-medium">Communities</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cta-section" class="cta-section">
        <div class="container text-center" data-aos="fade-up">
            <span class="badge bg-white text-primary px-3 py-2 rounded-pill mb-3">Join Us Today</span>
            <h2 class="display-5 fw-bold mb-4">Ready to Make a Difference?</h2>
            <p class="lead opacity-90 mb-5">Become a member today and help create positive change in your community</p>
            <div class="d-inline-block">
                <a href="#join" class="btn btn-lg" style="
								background: linear-gradient(45deg, #FF6B6B, #FF8E53);
								color: white;
								padding: 12px 28px;
								border-radius: 50px;
								border: none;
								font-weight: 500;
								box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
								transition: all 0.3s ease;
							">
                    Become a Member
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        viewBox="0 0 16 16" style="margin-left: 8px;">
                        <path
                            d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 footer-column" data-aos="fade-up">
                    <div class="mb-4">
                        <img src="<?php echo base_url('assets/images/logo-w-bg.jpg'); ?>" alt="Logo"
                            style="width:54px;height:52px; border-radius:100%;margin-right:10px;">
                        <h3 class="h5 footer-title">About GPI</h3>
                        <p class="text-white-50">God's People's Initiative - Making a positive impact through community
                            action and collective engagement.</p>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <a href="#" class="social-icon" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 footer-column" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="h5 footer-title">Quick Links</h3>
                    <a href="#about" class="footer-link">About Us</a>
                    <a href="#events" class="footer-link">Events</a>
                    <a href="#membership" class="footer-link">Membership</a>
                    <a href="#resources" class="footer-link">Resources</a>
                </div>
                <div class="col-lg-2 col-md-6 footer-column" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="h5 footer-title">Connect</h3>
                    <a href="#community" class="footer-link">Community</a>
                    <a href="#contact" class="footer-link">Contact</a>
                    <a href="#support" class="footer-link">Support</a>
                    <a href="#faq" class="footer-link">FAQ</a>
                </div>
                <div class="col-lg-2 col-md-6 footer-column" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="h5 footer-title">Other</h3>
                    <a href="#download" class="footer-link">Downloads</a>
                    <a href="#privacy" class="footer-link">Privacy Policy</a>
                    <a href="#tos" class="footer-link">Terms of Service</a>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0 text-white-50">&copy; 2024 GPI. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                        <a href="#" class="text-white-50 text-decoration-none me-3">Privacy Policy</a>
                        <a href="#" class="text-white-50 text-decoration-none">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });


    const navbar = document.querySelector('.navbar');
    let
        lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        if (currentScroll > 50) {
            navbar.classList.add('scrolled text-black');
        } else {
            navbar.classList.remove('scrolled');
        }

        lastScroll = currentScroll;
    });
    </script>
</body>


</html>
