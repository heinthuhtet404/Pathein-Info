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
                <li class="nav-item px-3"><a class="nav-link text-primary" href="#">ကျန်းမာရေး</a></li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="#">သယ်ယူပို့ဆောင်ရေး</a>
                </li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="#">ဟိုတယ်</a></li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="#">လည်ပတ်စရာနေရာများ</a>
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
        <a href="#" class="btn-frosted">
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

    <section class="service-section py-5 bg-light">
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

            <!-- Icon -->
            <div class="icon-circle">
                <i class="bi bi-mortarboard"></i>
            </div>

            <!-- Text -->
            <div class="service-content">
                <h5>ပညာရေး</h5>
                <p>
                    ကျောင်းများ၊ တက္ကသိုလ်များနှင့် သင်တန်းများ
                </p>
            </div>

        </div>
    </a>
</div>

                <!-- Health -->
                <div class="col-md-4">
    <a href="#" class="text-decoration-none">
        <div class="service-card-bg h-100"
             style="background-image: url('Photo/healthforpatheininfo.JPG.webp');">

            <div class="icon-circle">
                <i class="bi bi-heart-pulse"></i>
            </div>

            <div class="service-content">
                <h5>ကျန်းမာရေး</h5>
                <p>
                    ဆေးရုံများ၊ ဆေးခန်းများနှင့် ကျန်းမာရေးဝန်ဆောင်မှုများ
                </p>
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

            <div class="service-content">
                <h5>သယ်ယူပို့ဆောင်ရေး</h5>
                <p>
                    ကား၊ ဘတ်စ်၊ လေကြောင်းနှင့် သယ်ယူပို့ဆောင်ရေးများ
                </p>
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

            <div class="service-content">
                <h5>ဟိုတယ်</h5>
                <p>
                    ဟိုတယ်များ၊ တည်းခိုခန်းများနှင့် အပန်းဖြေစရာများ
                </p>
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

            <div class="service-content">
                <h5>လည်ပတ်စရာနေရာများ</h5>
                <p>
                    ခရီးသွားနေရာများနှင့် အထင်ကရနေရာများ
                </p>
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

            <div class="service-content">
                <h5>ဒေသထွက်ကုန်များ</h5>
                <p>
                    ခရိုင်အလိုက် ဒေသထွက်ကုန်များ
                </p>
            </div>

        </div>
    </a>
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
    </script>
</body>

</html>