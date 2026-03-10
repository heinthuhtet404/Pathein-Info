<!DOCTYPE html>
<html lang="my">

<head>
    <meta charset="UTF-8">

    <title>Myanmar Service Portal</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    /* General Body */
body {
    background: linear-gradient(135deg, #e6f0ff, #f4f8ff);
    font-family: 'Poppins', sans-serif;
}

/* Hero Section */
.hero-section {
    position: relative;
    min-height: 90vh;
    background: url('Photo/Pathein1.png') center/cover no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-align: center;
    overflow: hidden;
}

.hero-section .overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.45); /* dark overlay */
    z-index: 1;
}

.hero-section .hero-content {
    position: relative;
    z-index: 2;
    max-width: 900px;
    padding: 0 20px;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.3;
    text-shadow: 0 4px 10px rgba(0,0,0,0.4);
    margin-bottom: 1.5rem;
}

.hero-title .text-gradient {
    background: linear-gradient(90deg, #0d6efd, #20c997);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero-subtitle {
    font-size: 1.2rem;
    color: #e0e0e0;
    margin-bottom: 2rem;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.btn-hero {
    display: inline-block;
    padding: 0.85rem 2.2rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(90deg, #0d6efd, #20c997);
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.4s ease;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.btn-hero:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.3);
}

/* Service Section */
.service-section {
    padding: 5rem 0;
    text-align: center;
}

.service-section h2 {
    font-weight: 700;
    font-size: 2.5rem;
    color: #0d6efd;
    margin-bottom: 0.5rem;
}

.service-section p {
    color: #6c757d;
    margin-bottom: 3rem;
    font-size: 1rem;
}

/* Service Cards (merge normal + bg image) */
/* Service Cards - Updated Layout */
.service-card,
.service-card-bg {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s ease;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    color: #fff;
    height: 300px;   /* fixed height for clean layout */
    padding: 0;
}

/* ================= SERVICE CARDS FIXED ================= */

.service-card-bg {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    min-height: 300px;
    background-size: cover;
    background-position: center;
    transition: 0.4s ease;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}

/* Remove Bootstrap card effect conflict */
.service-card-bg.card {
    border: none;
}

/* Dark overlay */
.service-card-bg::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.75), rgba(0,0,0,0.2));
    z-index: 1;
    transition: 0.3s ease;
}

/* Hover effect */
.service-card-bg:hover {
    transform: translateY(-8px);
    box-shadow: 0 18px 40px rgba(0,0,0,0.25);
}

.service-card-bg:hover::before {
    background: linear-gradient(to top, rgba(0,0,0,0.6), rgba(0,0,0,0.1));
}

/* Icon */
.icon-circle {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #0d6efd;
    z-index: 2;
    transition: 0.3s ease;
}

.service-card-bg:hover .icon-circle {
    transform: scale(1.1);
}

/* Content Bottom */
.service-content {
    position: absolute;
    bottom: 20px;
    left: 20px;
    right: 20px;
    z-index: 2;
    text-align: left;
    color: #fff;
}

.service-content h5 {
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 8px;
}

.service-content p {
    font-size: 0.95rem;
    color: rgba(255,255,255,0.85);
}

/* Responsive */
@media(max-width: 768px){
    .service-card,
    .service-card-bg {
        margin-bottom: 1.5rem;
    }

    .hero-title {
        font-size: 2rem;
    }

    .hero-subtitle {
        font-size: 1rem;
    }
}

.btn-hero-glass {
    display: inline-block;
    padding: 0.9rem 2.4rem;
    font-size: 1.15rem;
    font-weight: 600;
    color: #fff;
    background: rgba(13, 110, 253, 0.8);
    border-radius: 50px;
    text-decoration: none;
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    border: 1px solid rgba(255,255,255,0.2);
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
}

.btn-hero-glass::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, #0d6efd, #20c997, #0dcaf0);
    transform: rotate(45deg);
    opacity: 0.2;
    transition: all 0.5s ease;
}

.btn-hero-glass:hover::before {
    opacity: 0.4;
    transform: rotate(90deg);
}

.btn-hero-glass:hover {
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 12px 35px rgba(0,0,0,0.35);
}

.service-content {
    position: absolute;
    bottom: 20px;
    left: 20px;
    right: 20px;
    z-index: 2;
    text-align: left;
}

.service-content h5 {
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 8px;
}

.service-content p {
    font-size: 0.95rem;
    color: rgba(255,255,255,0.85);
}

.hero {
            position: relative;
            min-height: 85vh;
            width: 100%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background-color: #000;
        }

        .slider-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            width: 100%;
            height: 100%;
            transition: transform 1.2s cubic-bezier(0.65, 0, 0.35, 1);
        }

        .slide {
            min-width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .slide::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero-container {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 0 15px;
        }
        .btn-frosted {
    display: inline-block;
    padding: 0.75rem 2rem;
    font-size: 1.2rem;
    font-weight: 600;
    color: #fff;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-frosted:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.25);
}
.full-section {
    width: 100%;
    background: linear-gradient(135deg, #4facfe, #00f2fe); /* optional gradient */
    color: #fff; /* text color */
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 60vh; /* makes it at least 60% of viewport height */
    text-align: center;
}

.full-section .container {
    max-width: 1000px; /* optional, keeps text readable */
}
.modern-hero {
    position: relative;
    width: 100%;
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: url('Photo/educationforpatheininfo.png') center/cover no-repeat;
    color: #fff;
    overflow: hidden;
}

.modern-hero .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5); /* dark overlay for readability */
    z-index: 1;
}

.modern-hero .hero-content {
    position: relative;
    z-index: 2;
    max-width: 900px;
    padding: 0 20px;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.hero-subtitle {
    font-size: 1.25rem;
    margin-bottom: 2rem;
}

.btn-modern {
    display: inline-block;
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    border: none;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.btn-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.3);
}

/* Hover text overlay (initially hidden) */
.service-card-bg .service-hover-text {
    position: absolute;
    inset: 0; /* top:0; bottom:0; left:0; right:0; */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 1rem 2rem;
    color: #fff;
    background: rgba(0,0,0,0.6); /* semi-transparent overlay */
    opacity: 0;
    transition: opacity 0.4s ease, transform 0.4s ease;
    z-index: 3; /* above icon & existing overlay */
    transform: translateY(20px);
}

/* Show overlay on hover */
.service-card-bg:hover .service-hover-text {
    opacity: 1;
    transform: translateY(0);
}

.backdrop-blur {
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
.bg-white\/10 {
    background: rgba(255, 255, 255, 0.1);
}
.bg-white\/20 {
    background: rgba(255, 255, 255, 0.2);
}
.text-white-50 {
    color: rgba(255, 255, 255, 0.5);
}
.fw-mono {
    font-family: 'SF Mono', 'Courier New', monospace;
    font-weight: 500;
}

/* ========== SERVICE CARDS - MINOR UPGRADES ========== */
.service-card-bg {
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 2px solid transparent;
}

/* Card border effect on hover */
.service-card-bg:hover {
    border-color: rgba(13, 110, 253, 0.5);
    transform: translateY(-10px) scale(1.02);
}

/* Icon circle upgrade */
.icon-circle {
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    backdrop-filter: blur(4px);
    border: 2px solid rgba(13, 110, 253, 0.3);
    transition: all 0.4s ease;
}

.service-card-bg:hover .icon-circle {
    transform: scale(1.15) rotate(5deg);
    background: #fff;
    border-color: #0d6efd;
    box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
}

/* Hover text overlay upgrade */
.service-card-bg .service-hover-text {
    background: rgba(255, 255, 255, 0.15);
backdrop-filter: blur(2px);
border: 1px solid rgba(255, 255, 255, 0.2);
    transition: opacity 0.5s ease, transform 0.5s ease;
}

.service-card-bg .service-hover-text h5 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 12px;
    text-shadow: 0 2px 5px rgba(0,0,0,0.3);
    transform: translateY(10px);
    transition: transform 0.5s ease 0.1s;
}

.service-card-bg .service-hover-text p {
    font-size: 1rem;
    transform: translateY(10px);
    transition: transform 0.5s ease 0.2s;
    color: white;
}

.service-card-bg:hover .service-hover-text h5,
.service-card-bg:hover .service-hover-text p {
    transform: translateY(0);
}

/* Category section title upgrade */
.service-section h2 {
    position: relative;
    display: inline-block;
    padding-bottom: 15px;
}

.service-section h2:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #8B5CF6, #EC4899);
    border-radius: 2px;
    transition: width 0.3s ease;
}

.service-section:hover h2:after {
    width: 120px;
}

/* Card container spacing */
.row.g-4 {
    margin-top: 20px;
}

/* Card wrapper for better shadow effect */
.col-md-4 {
    transition: all 0.3s ease;
}

.col-md-4:hover {
    transform: translateY(-5px);
}

/* Optional: Add subtle animation on page load */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.service-card-bg {
    animation: fadeInUp 0.8s ease forwards;
    opacity: 0; /* Start invisible */
}

/* Stagger animation for cards */
.col-md-4:nth-child(1) .service-card-bg { animation-delay: 0.1s; }
.col-md-4:nth-child(2) .service-card-bg { animation-delay: 0.2s; }
.col-md-4:nth-child(3) .service-card-bg { animation-delay: 0.3s; }
.col-md-4:nth-child(4) .service-card-bg { animation-delay: 0.4s; }
.col-md-4:nth-child(5) .service-card-bg { animation-delay: 0.5s; }
.col-md-4:nth-child(6) .service-card-bg { animation-delay: 0.6s; }

/* ===== PARTNER SECTION STYLES (No Conflict with existing classes) ===== */
        
        /* Floating Shapes */
        .partner-bg-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .partner-shape-1 {
            position: absolute;
            top: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            animation: floatAnimation 20s infinite ease-in-out;
        }

        .partner-shape-2 {
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: floatAnimation 25s infinite reverse;
        }

        .partner-shape-3 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulseGlow 8s infinite;
        }

        @keyframes floatAnimation {
            0% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }

        @keyframes pulseGlow {
            0% { opacity: 0.3; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: 0.6; transform: translate(-50%, -50%) scale(1.2); }
            100% { opacity: 0.3; transform: translate(-50%, -50%) scale(1); }
        }

        /* Promo Badge */
        .partner-promo-badge {
            display: inline-block;
            animation: slideDown 0.8s ease;
        }

        .badge-content {
            display: inline-block;
            padding: 12px 30px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 50px;
            color: #fff;
            font-weight: 600;
            letter-spacing: 1px;
            font-size: 1.1rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
        }

        .badge-content:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .badge-content i {
            color: #ffd700;
        }

        /* Main Headline */
        .partner-main-headline {
            text-shadow: 0 5px 20px rgba(0,0,0,0.3);
            line-height: 1.3;
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        .headline-highlight {
            background: linear-gradient(120deg, #ffffff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 15px rgba(255,255,255,0.3);
            position: relative;
            display: inline-block;
        }

        .headline-highlight::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #fff, transparent);
            border-radius: 3px;
        }

        /* Description */
        .partner-description {
            max-width: 750px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.25rem;
            line-height: 1.7;
            animation: fadeInUp 0.8s ease 0.3s both;
        }

        .partner-description strong {
            color: #fff;
            text-decoration: underline;
            text-underline-offset: 8px;
            text-decoration-thickness: 2px;
            text-decoration-color: rgba(255,255,255,0.5);
        }

        /* Contact Card */
        .partner-contact-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 40px;
            padding: 3rem 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            max-width: 650px;
            margin: 0 auto;
            transition: all 0.5s ease;
            animation: fadeInUp 0.8s ease 0.4s both;
        }

        .partner-contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 50px rgba(0,0,0,0.3);
            border-color: rgba(255,255,255,0.3);
        }

        /* Card Header */
        .card-header-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .icon-wrapper {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #4158D0, #C850C0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            border: 2px solid rgba(255,255,255,0.3);
            transition: all 0.4s ease;
        }

        .partner-contact-card:hover .icon-wrapper {
            transform: scale(1.1) rotate(5deg);
            border-color: #fff;
        }

        .icon-wrapper i {
            font-size: 2rem;
            color: #fff;
        }

        .card-title {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        /* Email Display */
        .email-display-wrapper {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 15px;
            padding: 20px 25px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 60px;
            margin: 25px 0 15px;
            transition: all 0.3s ease;
        }

        .email-display-wrapper:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255,255,255,0.4);
        }

        .email-address {
            font-size: 1.4rem;
            font-weight: 500;
            color: #fff;
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
            text-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .copy-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 40px;
            padding: 12px 30px;
            color: #fff;
            font-weight: 600;
            font-size: 1rem;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }

        .copy-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
            border-color: rgba(255,255,255,0.5);
        }

        .copy-btn:active {
            transform: translateY(0);
        }

        /* Info Note */
        .info-note {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            padding: 10px;
            border-radius: 30px;
            background: rgba(0,0,0,0.1);
            display: inline-block;
            padding: 10px 25px;
        }

        .info-note i {
            color: #ffd700;
        }

        /* Footer Note */
        .partner-footer-note {
            color: rgba(255, 255, 255, 0.75);
            font-size: 1rem;
            padding: 15px 30px;
            background: rgba(0,0,0,0.15);
            border-radius: 50px;
            display: inline-block;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.1);
            animation: fadeInUp 0.8s ease 0.5s both;
        }

        .partner-footer-note i {
            color: #ffd700;
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .partner-main-headline {
                font-size: 2.2rem !important;
            }
            
            .email-address {
                font-size: 1.1rem !important;
            }
            
            .partner-contact-card {
                padding: 2rem 1.5rem;
            }
            
            .card-title {
                font-size: 1.5rem;
            }
            
            .icon-wrapper {
                width: 60px;
                height: 60px;
            }
            
            .icon-wrapper i {
                font-size: 1.5rem;
            }
            
            .badge-content {
                font-size: 0.9rem;
                padding: 10px 20px;
            }
            
            .partner-footer-note {
                font-size: 0.85rem;
                padding: 12px 20px;
            }
        }

        /* Mobile Small */
        @media (max-width: 480px) {
            .email-display-wrapper {
                flex-direction: column;
            }
            
            .copy-btn {
                width: 100%;
            }
            
            .email-address {
                font-size: 1rem !important;
                word-break: break-all;
            }
        }

        /* Loading Animation for elements */
        .partner-promo-badge,
        .partner-main-headline,
        .partner-description,
        .partner-contact-card,
        .partner-footer-note {
            animation-fill-mode: both;
        }
    </style>
</head>

<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid align-items-center">

            <a class="navbar-brand d-flex align-items-center  text-white fw-bold" href="#">
                <img src="Photo/u.png" width="70px" height="60px" class="logo">ပုသိမ်မြို့
                <!-- <span class="brand-text">ပုသိမ်မြို့</span> -->
            </a>

            <div class="ms-auto d-flex align-items-center gap-2">
                <!-- <a class="btn btn-outline-light">Register</a> -->


                <a class="btn btn-light" href="Admin/login.php">Login</a>
            </div>

        </div>
    </nav>



    <!-- ================= MENU BAR ================= -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container">
            <ul class="navbar-nav mx-auto fw-semibold">
                <li class="nav-item px-3"><a class="nav-link text-primary" href="Academic.php">ပညာရေး</a></li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="healthhomepage.php">ကျန်းမာရေး</a></li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="bus1.php">သယ်ယူပို့ဆောင်ရေး</a>
                </li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="#">ဟိုတယ်</a></li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="LinnKhantNaing/business.php">လုပ်ငန်းများ</a></li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="sumyatmon/main.php">လည်ပတ်စရာနေရာများ</a>
                </li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="">စီးပွားရေးလုပ်ငန်း</a>
                </li>
                 <li class="nav-item px-3"><a class="nav-link text-primary" href="#">ဒေသထွက်ကုန်များ</a>
            </ul>
        </div>
    </nav>

    <!-- ================= HERO SECTION ================= -->
    <!-- <section class="hero-section">
    <div class="overlay"></div>
    <div class="hero-content text-center">
        <h1 class="hero-title">
            <span class="text-gradient">ပုသိမ်မြို့</span> 
            ၏ ပညာရေး၊ ကျန်းမာရေး၊ သယ်ယူပို့ဆောင်ရေး၊ ဟိုတယ်နှင့် လည်ပတ်စရာနေရာများ
        </h1>
        <p class="hero-subtitle">
            တစ်နေရာတည်းတွင် အချက်အလက်များကို ရှာဖွေနိုင်ပါသည်
        </p>
        <a href="#services" class="btn-hero-glass">
    စတင်ကြည့်ရှုမည်
</a>
    </div>
</section> -->
<section class="hero">
    <div class="slider-wrapper" id="sliderWrapper">
        <?php
        $heroImages = [
            "Photo/Pathein1.png",
            "Photo/educationforpatheininfo.png",
            "Photo/healthforpatheininfo.JPG.webp",
            "Photo/transportationforpatheininfo.jpg",
            "Photo/hotelforpatheininfo.jpg",
            "Photo/localproductforpatheininfo.png",
            "Photo/travelforpatheininfo.jpg"
        ];

        foreach ($heroImages as $img):
        ?>
            <div class="slide" style="background-image: url('<?php echo $img; ?>');"></div>
        <?php endforeach; ?>
    </div>

    <div class="container hero-container">
        <!-- <h3 class="fw-bold mb-3 display-6">
            <span class="text-warning">ပုသိမ်မြို့၏</span> ပညာရေး၊ ကျန်းမာရေး၊ သယ်ယူပို့ဆောင်ရေး၊ ဟိုတယ်နှင့် လည်ပတ်စရာနေရာများကို
        </h3>
        <p class="lead mb-4 fs-4">
            တစ်နေရာတည်းတွင်ရှာဖွေနိုင်ပါသည်။
        </p> -->
        <a href="#services" class="btn-frosted">
    စတင်ကြည့်ရှုမည်
</a>
    </div>
</section>
<!-- <section class="modern-hero">
    <div class="overlay"></div>
    <div class="hero-content text-center">
        <h3 class="hero-title">
            <span class="text-warning">ပုသိမ်မြို့၏</span> 
            ပညာရေး၊ ကျန်းမာရေး၊ သယ်ယူပို့ဆောင်ရေး၊ ဟိုတယ်နှင့် လည်ပတ်စရာနေရာများကို
        </h3>
        <p class="hero-subtitle">
            တစ်နေရာတည်းတွင်ရှာဖွေနိုင်ပါသည်။
        </p>
        <a href="#services" class="btn-modern">
            စတင်ကြည့်ရှုမည်
        </a>
    </div>
</section> -->

    <!-- ================= CATEGORY SECTION ================= -->

    <section id="services" class="service-section py-5 bg-light">
        <div class="container">

            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">ဝန်ဆောင်မှုကဏ္ဍများ</h2>
                <p class="text-muted">သင်လိုအပ်သော ကဏ္ဍကို ရွေးချယ်ပါ</p>
            </div>

            <div class="row g-4">

                <!-- Education -->
<div class="col-md-4">
    <a href="Academic.php" class="text-decoration-none">
        <div class="service-card-bg h-100"
     style="background-image: url('Photo/educationforpatheininfo.png');">

    <div class="icon-circle">
        <i class="bi bi-mortarboard"></i>
    </div>

    <!-- NEW overlay wrapper for hover text -->
    <div class="service-hover-text">
        <h5>ပညာရေး</h5>
        <p>ကျောင်းများ၊ တက္ကသိုလ်များနှင့် သင်တန်းများ</p>
    </div>
</div>
    </a>
</div>

                <!-- Health -->
                <!-- Health -->
<div class="col-md-4">
    <a href="healthhomepage.php" class="text-decoration-none">
        <div class="service-card-bg h-100"
             style="background-image: url('Photo/healthforpatheininfo.JPG.webp');">

            <div class="icon-circle">
                <i class="bi bi-heart-pulse"></i>
            </div>

            <!-- Hover Text -->
            <div class="service-hover-text">
                <h5>ကျန်းမာရေး</h5>
                <p>ဆေးရုံများ၊ ဆေးခန်းများနှင့် ကျန်းမာရေးဝန်ဆောင်မှုများ</p>
            </div>

        </div>
    </a>
</div>

<!-- Transport -->
<div class="col-md-4">
    <a href="#" class="text-decoration-none">
        <div class="service-card-bg h-100"
             style="background-image: url('Photo/transportationforpatheininfo.jpg');">

            <div class="icon-circle">
                <i class="bi bi-bus-front"></i>
            </div>

            <!-- Hover Text -->
            <div class="service-hover-text">
                <h5>သယ်ယူပို့ဆောင်ရေး</h5>
                <p>ကား၊ ဘတ်စ်၊ လေကြောင်းနှင့် သယ်ယူပို့ဆောင်ရေးများ</p>
            </div>

        </div>
    </a>
</div>

<!-- Hotel -->
<div class="col-md-4">
    <a href="#" class="text-decoration-none">
        <div class="service-card-bg h-100"
             style="background-image: url('Photo/hotelforpatheininfo.jpg');">

            <div class="icon-circle">
                <i class="bi bi-building"></i>
            </div>

            <!-- Hover Text -->
            <div class="service-hover-text">
                <h5>ဟိုတယ်</h5>
                <p>ဟိုတယ်များ၊ တည်းခိုခန်းများနှင့် အပန်းဖြေစရာများ</p>
            </div>

        </div>
    </a>
</div>

<!-- Travel -->
<div class="col-md-4">
    <a href="#" class="text-decoration-none">
        <div class="service-card-bg h-100"
             style="background-image: url('Photo/travelforpatheininfo.jpg');">

            <div class="icon-circle">
                <i class="bi bi-geo-alt"></i>
            </div>

            <!-- Hover Text -->
            <div class="service-hover-text">
                <h5>လည်ပတ်စရာနေရာများ</h5>
                <p>ခရီးသွားနေရာများနှင့် အထင်ကရနေရာများ</p>
            </div>

        </div>
    </a>
</div>

<!-- Local Products -->
<div class="col-md-4">
    <a href="#" class="text-decoration-none">
        <div class="service-card-bg h-100"
             style="background-image: url('Photo/localproductforpatheininfo.png');">

            <div class="icon-circle">
                <i class="bi bi-basket"></i>
            </div>

            <!-- Hover Text -->
            <div class="service-hover-text">
                <h5>ဒေသထွက်ကုန်များ</h5>
                <p>ခရိုင်အလိုက် ဒေသထွက်ကုန်များ</p>
            </div>

        </div>
    </a>
</div>

            </div>
        </div>
    </section>

    <!-- ================= BUSINESS CONTACT SECTION (UPDATED - MATCHING COLORS) ================= -->
<!-- ================= BUSINESS PARTNER SECTION (UPDATED) ================= -->
<section class="partner-cta-section d-flex align-items-center justify-content-center text-center"
    style="min-height: 100vh; background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%); color: #fff; position: relative; overflow: hidden;" style="padding: 60px 0;">

    <!-- Floating Background Elements -->
    <div class="partner-bg-shapes">
        <div class="partner-shape-1"></div>
        <div class="partner-shape-2"></div>
        <div class="partner-shape-3"></div>
    </div>

    <div class="container position-relative" style="z-index: 5;">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">

                <!-- Promo Badge -->
                <div class="partner-promo-badge mb-5" style="margin-top: 20px;">
                    <span class="badge-content">
                        <i class="bi bi-megaphone-fill me-2"></i>
                        လုပ်ငန်းရှင်များအတွက် အထူးဖိတ်ခေါ်ခြင်း
                    </span>
                </div>

                <!-- Main Headline -->
                <h2 class="partner-main-headline display-4 fw-bold mb-4">
                    သင့်လုပ်ငန်းကို 
                    <span class="headline-highlight">
                        ပုသိမ်မြို့
                    </span> 
                    ရဲ့ ဝန်ဆောင်မှုစာရင်းမှာ ထည့်သွင်းလိုက်ပါ။
                </h2>

                <!-- Description Text -->
                <p class="partner-description lead mb-5 mx-auto">
                    ခရီးသွားများ၊ ပြည်သူများဆီသို့ သင့်လုပ်ငန်းကို ရောက်ရှိစေဖို့အတွက် 
                    <strong class="fw-bold">ပုသိမ်မြို့ ဝန်ဆောင်မှုပေါ်တယ်</strong> မှာ နေရာယူလိုက်ပါ။
                </p>

                <!-- Contact Card -->
                <div class="partner-contact-card">
                    
                    <!-- Card Header -->
                    <div class="card-header-wrapper mb-4">
                        <div class="icon-wrapper">
                            <i class="bi bi-envelope-paper-fill"></i>
                        </div>
                        <h4 class="card-title mb-0">ဆက်သွယ်ရန်</h4>
                    </div>

                    <!-- Email Display Section -->
                    <div class="email-display-wrapper">
                        <span class="email-address" id="partnerEmail">patheininfo2026@gmail.com</span>
                        <button class="copy-btn" onclick="copyPartnerEmail()">
                            <i class="bi bi-clipboard-check me-2"></i>
                            ကူးယူရန်
                        </button>
                    </div>

                    <!-- Info Note -->
                    <p class="info-note mt-4 mb-0">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        အထက်ပါ Email သို့ သင့်လုပ်ငန်းအချက်အလက်များ ပေးပို့ပြီး စာရင်းသွင်းနိုင်ပါသည်။
                    </p>

                </div>

                <!-- Footer Note -->
                <div class="partner-footer-note mt-5" style="margin-bottom: 20px;">
                    <i class="bi bi-star-fill me-2"></i>
                    လက်ရှိတွင် ပညာရေး၊ ကျန်းမာရေး၊ ဟိုတယ်၊ စားသောက်ဆိုင်၊ ခရီးသွားလုပ်ငန်းများ စာရင်းသွင်းနိုင်ပါသည်။
                </div>

            </div>
        </div>
    </div>

</section>

    <!-- ================= Location Section ================= -->
     <iframe height="500" width="100%" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d122233.53243081593!2d94.66536439288318!3d16.786728123085606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30bfea063fe53f85%3A0xd07f864b399e7c13!2sPathein!5e0!3m2!1sen!2smm!4v1771767312787!5m2!1sen!2smm" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>


    <!-- ================= FOOTER ================= -->
    <footer class="bg-primary text-white text-center py-3">
        <p class="mb-0">© 2026 University of Computer Studies(Pathein). All Rights Reserved.</p>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const wrapper = document.getElementById('sliderWrapper');
        const slides = document.querySelectorAll('.slide');
        let index = 0;

        function startSlider() {
            index++;
            if (index >= slides.length) {
                index = 0;
            }
            wrapper.style.transform = `translateX(-${index * 100}%)`;
        }

        setInterval(startSlider, 3000);

        function copyEmail() {
    const email = document.getElementById('adminEmail').innerText;
    navigator.clipboard.writeText(email).then(() => {
        // Optional: Show a small toast/alert (you can style this better)
        alert('Email ကူးယူပြီးပါပြီ။');
    }).catch(err => {
        console.error('Copy failed: ', err);
    });
}

function copyPartnerEmail() {
            const email = document.getElementById('partnerEmail').innerText;
            navigator.clipboard.writeText(email).then(() => {
                // Visual feedback
                const btn = event.target.closest('.copy-btn');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>ကူးယူပြီးပါပြီ';
                btn.style.background = 'rgba(40, 167, 69, 0.3)';
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.background = 'rgba(255, 255, 255, 0.2)';
                }, 2000);
            }).catch(err => {
                // alert('❌ ကူးယူမရပါ။ ကိုယ်တိုင်ကူးယူပါ။');
                // console.error('Copy failed: ', err);
                    
            });
        }
    </script>
</body>

</html>