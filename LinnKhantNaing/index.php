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
        background-color: #f4f8ff;
    }

    .hero {

        /* linear-gradient(rgba(13, 110, 253, 0.7), rgba(13, 110, 253, 0.7)), */
        /* url('') cover no-repeat; */
        min-height: 85vh;
        /* screen height 75% */
        display: flex;
        align-items: center;

        background:
            linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
            url('Photo/Pathein1.png') center/ cover no-repeat;

        color: #fff;
    }

    .hero-slide {
        min-height: 75vh;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .hero-slide::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
    }

    .hero-slide .container {
        position: relative;
        z-index: 2;
    }

    .category-card {
        transition: 0.3s;
        border-radius: 15px;
    }

    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .icon-box {
        font-size: 40px;
        color: #0d6efd;
    }

    .navbar-brand span {
        font-size: 1.2rem;
        letter-spacing: 1px;
    }

    .service-card {
        border: none;
        border-radius: 18px;
        transition: all 0.35s ease;
        background: #ffffff;
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.08);
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(13, 110, 253, 0.2);
    }

    .icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        color: #fff;
        font-size: 36px;
        transition: 0.3s;
    }

    .service-card:hover .icon-circle {
        transform: scale(1.1);
    }

    a.text-decoration-none:hover h5 {
        color: #0d6efd;
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

    <section class="py-5 bg-light">
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
                <div class="col-md-6">
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
                <div class="col-md-6">
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

            </div>
        </div>
    </section>


    <!-- ================= FOOTER ================= -->
    <footer class="bg-primary text-white text-center py-3">
        <p class="mb-0">© 2026 University of Computer Studies(Pathein). All Rights Reserved.</p>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>