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
                <a class="btn btn-outline-light">Register</a>
                <a class="btn btn-light">Login</a>
            </div>

        </div>
    </nav>



    <!-- ================= MENU BAR ================= -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container">
            <ul class="navbar-nav mx-auto fw-semibold">
                <li class="nav-item px-3"><a class="nav-link text-primary" href="Academic.php">ပညာရေး</a></li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="#">ကျန်းမာရေး</a></li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="#">သယ်ယူပို့ဆောင်ရေး</a></li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="#">ဟိုတယ်</a></li>
                <li class="nav-item px-3"><a class="nav-link text-primary" href="#">လည်ပတ်စရာနေရာများ</a></li>
            </ul>
        </div>
    </nav>