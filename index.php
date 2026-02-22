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
    body {
    background: linear-gradient(135deg, #e6f0ff, #f4f8ff);
    font-family: 'Poppins', sans-serif;
}

/* Hero Section */
.hero {
    min-height: 85vh;
    display: flex;
    align-items: center;
    background:
        linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
        url('Photo/Pathein1.png') center/cover no-repeat;
    color: #fff;
}

/* Service Section */
.service-section {
    padding: 5rem 0;
    text-align: center;
}

/* Section Title */
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

/* Glassmorphism Cards */
.service-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 2rem 1rem;
    transition: all 0.4s ease;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.2);
}

.service-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 20px 40px rgba(13,110,253,0.2);
}

/* Top gradient line on hover */
.service-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #0d6efd, #20c997);
    transition: 0.3s;
    opacity: 0;
}

.service-card:hover::before {
    opacity: 1;
}

/* Icon Circle */
.icon-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem auto;
    font-size: 32px;
    color: #fff;
    background: linear-gradient(135deg, #0d6efd, #20c997);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    transition: transform 0.4s ease;
}

.service-card:hover .icon-circle {
    transform: scale(1.2) rotate(10deg);
}

/* Card Title */
.service-card h5 {
    font-weight: 600;
    font-size: 1.2rem;
    color: #ffffff;
    text-shadow: 0 2px 5px rgba(0,0,0,0.2);
    transition: color 0.3s ease;
}

.service-card:hover h5 {
    color: #0d6efd;
}

/* Card Description */
.service-card p {
    color: rgba(255,255,255,0.8);
    font-size: 0.95rem;
}

/* Responsive */
@media(max-width: 768px){
    .service-card {
        margin-bottom: 1.5rem;
    }
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
            </ul>
        </div>
    </nav>

    <!-- ================= HERO SECTION ================= -->
    <section class="hero text-center">
        <div class="container">
            <h3 class="fw-bold mb-3">
                <span class="text-warning">ပုသိမ်မြို့၏</span> ပညာရေး၊ ကျန်းမာရေး၊ သယ်ယူပို့ဆောင်ရေး၊ ဟိုတယ်နှင့်
                လည်ပတ်စရာနေရာများကို
            </h3>

            <p class="lead mb-4">
                တစ်နေရာတည်းတွင်ရှာဖွေနိုင်ပါသည်။
            </p>
            <a href="#" class="btn btn-light btn-lg text-primary fw-semibold">
                စတင်ကြည့်ရှုမည်
            </a>
        </div>
    </section>

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
                        <div class="card service-card h-100 text-center p-4">
                            <div class="icon-circle bg-primary">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <h5 class="fw-bold mt-4 text-dark">ပညာရေး</h5>
                            <p class="text-muted">
                                ကျောင်းများ၊ တက္ကသိုလ်များနှင့် သင်တန်းများ
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Health -->
                <div class="col-md-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card service-card h-100 text-center p-4">
                            <div class="icon-circle bg-danger">
                                <i class="bi bi-heart-pulse"></i>
                            </div>
                            <h5 class="fw-bold mt-4 text-dark">ကျန်းမာရေး</h5>
                            <p class="text-muted">
                                ဆေးရုံများ၊ ဆေးခန်းများနှင့် ကျန်းမာရေးဝန်ဆောင်မှုများ
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Transport -->
                <div class="col-md-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card service-card h-100 text-center p-4">
                            <div class="icon-circle bg-success">
                                <i class="bi bi-bus-front"></i>
                            </div>
                            <h5 class="fw-bold mt-4 text-dark">သယ်ယူပို့ဆောင်ရေး</h5>
                            <p class="text-muted">
                                ကား၊ ဘတ်စ်၊ လေကြောင်းနှင့် သယ်ယူပို့ဆောင်ရေးများ
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Hotel -->
                <div class="col-md-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card service-card h-100 text-center p-4">
                            <div class="icon-circle bg-warning text-dark">
                                <i class="bi bi-building"></i>
                            </div>
                            <h5 class="fw-bold mt-4 text-dark">ဟိုတယ်</h5>
                            <p class="text-muted">
                                ဟိုတယ်များ၊ တည်းခိုခန်းများနှင့် အပန်းဖြေစရာများ
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Travel -->
                <div class="col-md-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card service-card h-100 text-center p-4">
                            <div class="icon-circle bg-info">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <h5 class="fw-bold mt-4 text-dark">လည်ပတ်စရာနေရာများ</h5>
                            <p class="text-muted">
                                ခရီးသွားနေရာများနှင့် အထင်ကရနေရာများ
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Local Products -->
                 <div class="col-md-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card service-card h-100 text-center p-4">
                            <div class="icon-circle bg-secondary">
                                <i class="bi bi-bus-front"></i>
                            </div>
                            <h5 class="fw-bold mt-4 text-dark">ဒေသထွက်ကုန်များ</h5>
                            <p class="text-muted">
                                ခရိုင်အလိုက် ဒေသထွက်ကုန်များ
                            </p>
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
</body>

</html>