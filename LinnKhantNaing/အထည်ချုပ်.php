<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ပုသိမ် အထည်ချုပ်လုပ်ငန်း လမ်းညွှန်</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #e67e22;
            --bg-light: #f4f7f6;
            --white: #ffffff;
        }

        body {
            font-family: 'Pyidaungsu', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            background-color: var(--bg-light);
            color: #333;
        }

        header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 2rem;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .section {
            background: var(--white);
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .section:hover {
            transform: translateY(-5px);
        }

        h2 {
            color: var(--accent-color);
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 10px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background: #fffaf5;
        }

        .process-list {
            list-style: none;
            padding: 0;
        }

        .process-list li {
            background: #eee;
            margin: 5px 0;
            padding: 10px;
            border-left: 5px solid var(--accent-color);
        }

        .status-badge {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
        }

        footer {
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
            color: #666;
        }

        /* Interactive Button */
        #topBtn {
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            .machine-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

.machine-card {
    background: #ffffff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.machine-card:hover {
    transform: translateY(-5px);
}

.machine-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.machine-card .content {
    padding: 15px;
}

.machine-card h3 {
    margin-top: 0;
    color: var(--primary-color);
}
        }
        .department-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 20px;
}

.department-card {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.department-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}

.department-card img {
    width: 100%;
    height: 170px;
    object-fit: cover;
}

.department-card .content {
    padding: 15px;
}

.department-card h3 {
    margin-top: 0;
    color: var(--primary-color);
}
.process-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
}

.process-card {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.process-card:hover {
    transform: translateY(-6px);
}

.process-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.process-card .content {
    padding: 15px;
}

.process-card h3 {
    margin-top: 0;
    color: var(--accent-color);
}.process-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
}

.process-card {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.process-card:hover {
    transform: translateY(-6px);
}

.process-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.process-card .content {
    padding: 15px;
}

.process-card h3 {
    margin-top: 0;
    color: var(--accent-color);
}/* Process Steps Vertical Layout */
.process-vertical-grid {
    display: grid;
    grid-template-columns: 1fr; /* အလျားလိုက် */
    row-gap: 20px;
}

.process-card {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.process-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

.process-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.process-card .content {
    padding: 15px;
}

.process-card h3 {
    margin-top: 0;
    color: var(--accent-color);
}

/* Responsive: tablet screen 2 column */
@media screen and (min-width: 768px) {
    .process-vertical-grid {
        grid-template-columns: repeat(2, 1fr);
        column-gap: 20px;
    }
}

/* Responsive: desktop screen 4 column */
@media screen and (min-width: 1200px) {
    .process-vertical-grid {
        grid-template-columns: repeat(4, 1fr);
        column-gap: 20px;
    }
}
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 20px;
}

.product-card {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}

.product-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.product-card .content {
    padding: 15px;
}

.product-card h3 {
    margin-top: 0;
    color: var(--primary-color);
}
.finance-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.finance-card {
    padding: 20px;
    border-radius: 12px;
    color: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.finance-card:hover {
    transform: translateY(-6px);
}

.finance-card ul {
    padding-left: 20px;
}

.finance-card li {
    margin-bottom: 8px;
}

/* Profit Style */
.finance-card.profit {
    background: linear-gradient(135deg, #27ae60, #2ecc71);
}

/* Loss Style */
.finance-card.loss {
    background: linear-gradient(135deg, #c0392b, #e74c3c);
}
/* Worker Role Gradient Section */
.worker-section {
    background: linear-gradient(135deg, #3fcee7, #345c2b);
    color: white;
    padding: 30px;
    border-radius: 12px;
}

.worker-list {
    list-style: none;
    padding: 0;
    margin-top: 20px;
}

.worker-list li {
    background: rgba(227, 231, 234, 0.1);
    margin-bottom: 12px;
    padding: 12px 15px;
    border-left: 5px solid #e5b90a;
    border-radius: 6px;
    transition: 0.3s ease;
}

.worker-list li:hover {
    background: rgba(75, 30, 241, 0.2);
    transform: translateX(8px);
}
/* Subtle Worker Section Gradient Background for all cards */
.process-card,
.product-card,
.department-card {
    background: linear-gradient(135deg, rgba(63,206,231,0.2), rgba(52,92,43,0.2)); /* soft, transparent gradient */
    color: #333; /* dark text for readability */
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.process-card:hover,
.product-card:hover,
.department-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.process-card .content,
.product-card .content,
.department-card .content {
    padding: 15px;
}

.process-card h3,
.product-card h3,
.department-card h3 {
    margin-top: 0;
    color: var(--primary-color); /* dark text */
}

.process-card p,
.product-card p,
.department-card p {
    color: #555; /* slightly dark text for readability */
}

.card-grid .card {
    background: linear-gradient(135deg, rgba(63,206,231,0.2), rgba(52,92,43,0.2)); /* soft gradient */
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-grid .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.12);
}
/* Remove default margin */
body, html {
    margin: 0;
    padding: 0;
}

/* Full Screen Hero */
.hero {
    position: relative;
    height: 100vh; /* Screen full height */
    width: 100%;
    background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
                url('homepage2.jpg') center/cover no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
}

/* Glass Effect Content */
.hero-content {
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(10px);
    padding: 40px 60px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.hero-content h1 {
    font-size: 3rem;
    margin-bottom: 15px;
}

.hero-content p {
    font-size: 1.3rem;
    opacity: 0.95;
}
/* Full Screen Card Section */
.card-section {
    min-height: 100vh; /* Screen အပြည့် */
    width: 100%;
    padding: 80px 5%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #dbeafe, #e0f2fe); /* Soft Blue Gradient */
}

/* Section Title */
.card-section h2 {
    font-size: 2.5rem;
    margin-bottom: 50px;
    color: #1e3a8a;
    text-align: center;
}

/* Card Grid */
.card-grid {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

/* Individual Card */
.card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    text-align: center;
    transition: 0.3s ease;
}

/* Hover Effect */
.card:hover {
    transform: translateY(-10px);
    background: linear-gradient(135deg, #bbf7d0, #fde047); /* Click Color Green+Yellow */
}

/* Card Image */
.card img {
    width: 80px;
    margin-bottom: 15px;
}

/* Card Text */
.card h3 {
    margin-bottom: 10px;
    color: #0f172a;
}/* Reset */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html, body{
    height:100%;
    font-family:'Segoe UI', sans-serif;
}

/* ===== Pastel Makeup Animated Gradient Background ===== */
body{
    min-height:100vh;
    background: linear-gradient(
        -45deg,
        #ffe6e6,   /* very soft pink */
        #ffd9d9,   /* pastel pink */
        #fff0e6,   /* peach cream */
        #ffe5cc,   /* light coral */
        #fff5f0    /* soft nude */
    );
    background-size: 600% 600%;
    animation: pastelMakeupFlow 30s ease-in-out infinite;
}

/* Smooth Gradient Movement */
@keyframes pastelMakeupFlow{
    0%{
        background-position: 0% 50%;
    }
    25%{
        background-position: 50% 100%;
    }
    50%{
        background-position: 100% 50%;
    }
    75%{
        background-position: 50% 0%;
    }
    100%{
        background-position: 0% 50%;
    }
}

/* Section Full Screen */
section{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* Glass Card Style */
.card{
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(20px);
    padding:30px;
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
    color:white;
    transition:0.4s ease;
    max-width:400px;
    text-align:center;
}

.card:hover{
    transform:translateY(-8px) scale(1.03);
}
/* Worker Section Animated Pastel Makeup Gradient */
.worker-section {
    background: linear-gradient(-45deg,
        #ffe6e6,   /* soft pink */
        #ffd9d9,   /* pastel pink */
        #fff0e6,   /* peach cream */
        #ffe5cc,   /* light coral */
        #fff5f0    /* soft nude */
    );
    background-size: 600% 600%;
    animation: workerGradientFlow 25s ease-in-out infinite;
    color: #333; /* text အရောင် */
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    transition: transform 0.4s ease;
}

/* Gradient Animation Keyframes */
@keyframes workerGradientFlow{
    0% { background-position: 0% 50%; }
    25% { background-position: 50% 100%; }
    50% { background-position: 100% 50%; }
    75% { background-position: 50% 0%; }
    100% { background-position: 0% 50%; }
}

/* Worker List Items */
.worker-list li {
    background: rgba(255,255,255,0.25); /* Slightly transparent glass effect */
    color: #222; /* dark text for readability */
    margin-bottom: 12px;
    padding: 12px 15px;
    border-left: 5px solid #e67e22; /* accent line */
    border-radius: 10px;
    transition: all 0.3s ease;
}

.worker-list li:hover {
    background: rgba(255, 182, 193, 0.3); /* soft pink highlight on hover */
    transform: translateX(8px);
}/* ===== All Cards Pastel Makeup Animated Gradient ===== */
.process-card,
.product-card,
.department-card,
.card-grid .card {
    background: linear-gradient(
        -45deg,
        #ffe6e6,  /* soft pink */
        #ffd9d9,  /* pastel pink */
        #fff0e6,  /* peach cream */
        #ffe5cc,  /* light coral */
        #fff5f0   /* soft nude */
    );
    background-size: 600% 600%;
    animation: cardGradientFlow 30s ease-in-out infinite;
    color: #222; /* dark text for readability */
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover Effect for Cards */
.process-card:hover,
.product-card:hover,
.department-card:hover,
.card-grid .card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 12px 30px rgba(0,0,0,0.2);
}

/* Card Content Padding */
.process-card .content,
.product-card .content,
.department-card .content,
.card-grid .card .content {
    padding: 20px;
}

/* Card Titles & Text */
.process-card h3,
.product-card h3,
.department-card h3,
.card-grid .card h3 {
    color: #0f172a; /* dark text */
    margin-top: 0;
}

.process-card p,
.product-card p,
.department-card p,
.card-grid .card p {
    color: #333;
}

/* Keyframes for Smooth Animated Gradient */
@keyframes cardGradientFlow {
    0% { background-position: 0% 50%; }
    25% { background-position: 50% 100%; }
    50% { background-position: 100% 50%; }
    75% { background-position: 50% 0%; }
    100% { background-position: 0% 50%; }
}
/* ===== Pastel Makeup Animated Gradient for Finance Cards ===== */
.finance-card.profit {
    background: linear-gradient(
        -45deg,
        #a8f0d1,  /* soft mint */
        #b0f7ea,  /* pastel turquoise */
        #d0f7f0,  /* light aqua */
        #c0ffe0   /* soft green */
    );
    background-size: 600% 600%;
    animation: pastelFlow 25s ease-in-out infinite;
    color: #0f172a; /* dark text for readability */
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    padding: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.finance-card.loss {
    background: linear-gradient(
        -45deg,
        #ffd6d6,  /* soft pink */
        #ffcccc,  /* pastel red */
        #ffe6e6,  /* light coral */
        #fff0f0   /* soft nude */
    );
    background-size: 600% 600%;
    animation: pastelFlow 25s ease-in-out infinite;
    color: #0f172a;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    padding: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Smooth Gradient Animation Keyframes */
@keyframes pastelFlow {
    0% { background-position: 0% 50%; }
    25% { background-position: 50% 100%; }
    50% { background-position: 100% 50%; }
    75% { background-position: 50% 0%; }
    100% { background-position: 0% 50%; }
}

/* Hover Effect */
.finance-card:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 12px 25px rgba(0,0,0,0.25);
}/* Contact Section Cards */
.section .card-grid .card {
    background: linear-gradient(
        -45deg,
        #d0f0fd,
        #f0f7fd,
        #e0f4fb,
        #d0f0fd
    );
    color: #0f172a;
    text-align: center;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.section .card-grid .card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 12px 25px rgba(0,0,0,0.2);
}/* ===== Clear Image Hero ===== */
.hero {
    position: relative;
    height: 100vh;
    width: 100%;
    background: url('homepage2.jpg') center/cover no-repeat;
    display: flex;
    align-items: flex-start;   /* အပေါ်ကိုထား */
    justify-content: center;
    padding-top: 80px;         /* အပေါ်မှာ အနည်းငယ်ကွာ */
    text-align: center;
}

/* Text Box */
.hero-content {
    background: rgba(0, 0, 0, 0.4);  /* ပုံမဖုံးအောင် light overlay */
    padding: 20px 40px;
    border-radius: 10px;
    color: #fff;
}

/* Title */
.hero-content h1 {
    font-size: 3rem;
    margin-bottom: 10px;
}

/* Subtitle */
.hero-content p {
    font-size: 1.2rem;
}/* ===== Animated Gradient Section Style ===== */
.animated-section {
    background: linear-gradient(-45deg,
        #ffe6e6,
        #ffd9d9,
        #fff0e6,
        #ffe5cc,
        #fff5f0
    );
    background-size: 600% 600%;
    animation: animatedFlow 25s ease-in-out infinite;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    transition: 0.4s ease;
}

@keyframes animatedFlow {
    0% { background-position: 0% 50%; }
    25% { background-position: 50% 100%; }
    50% { background-position: 100% 50%; }
    75% { background-position: 50% 0%; }
    100% { background-position: 0% 50%; }
}

/* List Animation */
.animated-section ul {
    list-style: none;
    padding: 0;
}

.animated-section li {
    background: rgba(255,255,255,0.4);
    margin-bottom: 12px;
    padding: 12px 15px;
    border-left: 5px solid #e67e22;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.animated-section li:hover {
    transform: translateX(10px);
    background: rgba(255,182,193,0.4);
}.economic-section {
    background: linear-gradient(135deg, #dbeafe, #93c5fd);
}/* ===== Introduction Animated Gradient ===== */
.intro-box {
    margin-top: 20px;
    padding: 25px;
    border-radius: 20px;
    background: linear-gradient(-45deg,
        #ffe6e6,
        #ffd9d9,
        #fff0e6,
        #ffe5cc,
        #fff5f0
    );
    background-size: 600% 600%;
    animation: introFlow 25s ease-in-out infinite;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.intro-box ul {
    list-style: none;
    padding: 0;
}

.intro-box li {
    background: rgba(255,255,255,0.4);
    margin-bottom: 12px;
    padding: 12px 15px;
    border-left: 5px solid #e67e22;
    border-radius: 10px;
    transition: 0.3s ease;
}

.intro-box li:hover {
    transform: translateX(8px);
    background: rgba(255,182,193,0.4);
}

@keyframes introFlow {
    0% { background-position: 0% 50%; }
    25% { background-position: 50% 100%; }
    50% { background-position: 100% 50%; }
    75% { background-position: 50% 0%; }
    100% { background-position: 0% 50%; }
}
    </style>
</head>
<body>

   <section class="hero">
    <div class="hero-content">
        <h1>Pathein Garment Industry</h1>
        <p>ဧရာဝတီတိုင်း၏ စီးပွားရေးအရေးပါသော အထည်ချုပ်လုပ်ငန်း</p>
    </div>
</section>

    <div class="container">
        
       <div class="intro-box">
        <h3>📌 အထည်ချုပ်စက်ရုံ (Introduction)</h3>
        <ul>
            <li>အထည်ချုပ်စက်ရုံသည် အဝတ်အထည်များကို စက်ကိရိယာများအသုံးပြု၍ ထုတ်လုပ်သော စက်မှုလုပ်ငန်းတစ်ခု ဖြစ်သည်။</li>
            <li>ဒီဇိုင်းရေးဆွဲခြင်းမှ စတင်၍ ဖြတ်တောက်ခြင်း၊ ချုပ်လုပ်ခြင်း၊ အရည်အသွေးစစ်ဆေးခြင်းအထိ လုပ်ငန်းစဉ်အဆင့်ဆင့် ပါဝင်သည်။</li>
            <li>မြန်မာနိုင်ငံတွင် အထည်ချုပ်လုပ်ငန်းသည် အလုပ်အကိုင်အခွင့်အလမ်းများ ဖန်တီးပေးသော အရေးကြီးသော စီးပွားရေးကဏ္ဍတစ်ခု ဖြစ်သည်။</li>
            <li>အထူးသဖြင့် ပုသိမ်မြို့ ကဲ့သို့သော ဒေသများတွင် အထည်ချုပ်စက်ရုံများ တိုးတက်ဖွံ့ဖြိုးလာနေသည်။</li>
            <li>အထည်ချုပ်စက်ရုံများသည် ဒေသစီးပွားရေး ဖွံ့ဖြိုးတိုးတက်ရေးနှင့် နိုင်ငံခြားဝင်ငွေ ရရှိရေးတွင် အရေးပါသော အခန်းကဏ္ဍရှိသည်။</li>
        </ul>
    </div>

       <!-- Process Steps Section -->
<div class="section">
    <h2>အဓိကဌာနများ (Departments)</h2>

    <div class="process-vertical-grid">
        <div class="process-card">
            <img src="design.jpg" alt="Design Department">
            <div class="content">
                  <h3>Design & Sampling</h3>
                <p>CAD Software အသုံးပြု၍ Pattern ဆွဲခြင်း၊ Sample ချုပ်လုပ်ခြင်းများ ပြုလုပ်သည်။</p>
            </div>
        </div>

        <div class="process-card">
             <img src="cutting2.jpg" alt="Cutting Department">
            <div class="content">
                 <h3>Cutting Department</h3>
                <p>Fabric များကို အလွှာလိုက် စီပြီး အတိအကျ ဖြတ်တောက်ပေးသော ဌာနဖြစ်သည်။</p>
            </div>
        </div>

        <div class="process-card">
              <img src="sewing.jpg" alt="Sewing Department">
            <div class="content">
                <h3>Sewing Department</h3>
                <p>Production Line စနစ်ဖြင့် အထည်ချုပ်လုပ်ငန်း၏ အဓိက ချုပ်လုပ်မှုများ ပြုလုပ်သည်။</p>
            </div>
        </div>

        <div class="process-card">
              <img src="qc.jpg" alt="Finishing Department">
            <div class="content">
                <h3>Finishing & QC</h3>
                <p>အရည်အသွေးစစ်ဆေးခြင်း၊ မီးပူတိုက်ခြင်းနှင့် ထုပ်ပိုးခြင်းများ ပြုလုပ်သော အဆင့်ဖြစ်သည်။</p>
            </div>
        </div>
    </div>
</div>
        <!-- Process Steps Section -->
<div class="section">
    <h2>အသုံးပြုသော စက်ကိရိယာများ</h2>

    <div class="process-vertical-grid">
        <div class="process-card">
            <img src="single.jpg" alt="Order">
            <div class="content">
                  <h3>Single Needle Machine</h3>
                <p>အခြေခံချုပ်လုပ်မှုများအတွက် အသုံးပြုသည်။ Shirt၊ Pant များအတွက် အဓိကစက်ဖြစ်သည်။</p>
            </div>
        </div>

        <div class="process-card">
             <img src="overclock.jpg" alt="Overlock Machine">
            <div class="content">
                 <h3>Overlock Machine</h3>
                <p>အထည်အနားသားမပြုတ်စေရန် ချုပ်ပေးသောစက်ဖြစ်သည်။</p>
            </div>
        </div>

        <div class="process-card">
              <img src="button.jpg" alt="Button Machine">
            <div class="content">
                <h3>Button Hole / Attach Machine</h3>
                <p>ကြယ်သီးပေါက်ဖောက်ခြင်းနှင့် ကြယ်သီးတပ်ခြင်းများအတွက် အသုံးပြုသည်။</p>
            </div>
        </div>

        <div class="process-card">
             <img src="cutting1.jpg" alt="Cutting Machine">
            <div class="content">
                <h3>Cutting Machine</h3>
                <p>Straight Knife နှင့် Band Knife များဖြင့် အထည်များကို အတိအကျ ဖြတ်တောက်ပေးသည်။</p>
            </div>
        </div>
    </div>
</div>

       
<div class="section">
    <h2>လုပ်ငန်းစဉ် အဆင့်ဆင့်</h2>

    <div class="process-grid">

        <div class="process-card">
            <img src="order.jpg" alt="Order">
            <div class="content">
                <h3>၁။ Order လက်ခံခြင်း</h3>
                <p>Buyer မှ အော်ဒါ လက်ခံပြီး ထုတ်လုပ်မှု စတင်ပြင်ဆင်သည်။</p>
            </div>
        </div>

        <div class="process-card">
            <img src="sample.jpg" alt="Sample">
            <div class="content">
                <h3>၂။ Sample အတည်ပြုခြင်း</h3>
                <p>နမူနာချုပ်ပြီး အတည်ပြုချက် ရယူသည်။</p>
            </div>
        </div>

        <div class="process-card">
            <img src="fabric.jpg" alt="Fabric Purchase">
            <div class="content">
                <h3>၃။ Fabric & Materials ဝယ်ယူခြင်း</h3>
                <p>Fabric နှင့် ကုန်ကြမ်းများ အရည်အသွေးမြင့် ဝယ်ယူသည်။</p>
            </div>
        </div>

        <div class="process-card">
            <img src="fabri cutting.jpg" alt="Cutting">
            <div class="content">
                <h3>၄။ Fabric Cutting</h3>
                <p>Fabric များကို အလွှာလိုက် စီပြီး အတိအကျ ဖြတ်တောက်သည်။</p>
            </div>
        </div>

        <div class="process-card">
            <img src="sewing line.jpg" alt="Sewing">
            <div class="content">
                <h3>၅။ Sewing Line</h3>
                <p>Production Line စနစ်ဖြင့် အထည်ချုပ်လုပ်သည်။</p>
            </div>
        </div>

        <div class="process-card">
            <img src="qc control.jpg" alt="QC">
            <div class="content">
                <h3>၆။ Quality Control</h3>
                <p>အရည်အသွေး စစ်ဆေးပြီး အမှားများကို အလိုက်သင့် ပြင်ဆင်သည်။</p>
            </div>
        </div>

        <div class="process-card">
            <img src="qc control.jpg" alt="QC">
            <div class="content">
                <h3>၇။ Finishing</h3>
                <p>Sewing Line ပြီးတဲ့အခါThread အပိုတွေ ဖြတ်ခြင်းသန့်ရှင်းရေးလုပ်ခြင်းပုံစံအမှန်စစ်ဆေးခြင်းLabel / Tag ထည့်ခြင်းစတာတွေကို လုပ်ဆောင်တဲ့ အဆင့်ဖြစ်ပါတယ်။</p>
            </div>
        </div>

        <div class="process-card">
            <img src="ironing.jpg" alt="Ironing & Packing">
            <div class="content">
                <h3>၈။ Ironing & Packing</h3>
                <p>မီးပူတိုက်ပြီး အထည်များကို ထုပ်ပိုးကာ စားသုံးသူသို့ ပြင်ဆင်သည်။</p>
            </div>
        </div>

        <div class="process-card">
            <img src="export.jpg" alt="Export">
            <div class="content">
                <h3>၉။ Export</h3>
                <p>ထုပ်ပိုးပြီး သယ်ယူပို့ဆောင်ခြင်းအဆင့်မှတဆင့် ထုတ်ကုန်တင်ပို့သည်။</p>
            </div>
        </div>

    </div>
</div>
 <div class="section worker-section">
    <h2 style="color:white;">အလုပ်သမား အခန်းကဏ္ဍ</h2>

    <ul class="worker-list">
        <li><strong>Production Manager</strong> – စက်ရုံထုတ်လုပ်ရေး လုပ်ငန်းစဉ်အားလုံးကို စီမံခန့်ခွဲသည်။</li>
        <li><strong>Line Leader</strong> – Production Line ကို ဦးဆောင်ထိန်းချုပ်သည်။</li>
        <li><strong>Supervisor</strong> – အလုပ်သမားများနှင့် အရည်အသွေးကို ကြီးကြပ်သည်။</li>
        <li><strong>Sewing Operator</strong> – စက်လည်ပတ်၍ အထည်ချုပ်လုပ်ငန်း၏ အဓိကတာဝန်ထမ်းဆောင်သည်။</li>
        <li><strong>QC Inspector</strong> – အရည်အသွေးစစ်ဆေးပြီး အမှားများကို ဖော်ထုတ်ပြင်ဆင်သည်။</li>
        <li><strong>Helper</strong> – စက်လည်ပတ်မှုအကူအညီပေးပြီး စုစည်းမှုများ ပြုလုပ်သည်။</li>
    </ul>

    <p style="margin-top:15px;">
        စက်ရုံတစ်ခုတွင်အလုပ်သမား ၁၀၀ မှ ၅၀၀ အထိ ရှိနိုင်ပြီး ဒေသခံအမျိုးသမီးများအတွက်အဓိကအလုပ်အကိုင်အခွင့်အလမ်းများ ဖန်တီးပေးသည်။
    </p>
</div>
<!-- ၆။ ထုတ်ကုန်များ -->
<div class="section">
    <h2>ထုတ်ကုန်များ (Products)</h2>

    <div class="product-grid">

        <div class="product-card">
            <img src="shirt.jpg" alt="Shirt">
            <div class="content">
                <h3>Shirt (အင်္ကျီ)</h3>
                <p>အမျိုးသားနှင့် အမျိုးသမီး အင်္ကျီများကို အရည်အသွေးမြင့် ချုပ်လုပ်တင်ပို့သည်။</p>
            </div>
        </div>

        <div class="product-card">
            <img src="tshirt.jpg" alt="T-Shirt">
            <div class="content">
                <h3>T-Shirt</h3>
                <p>Overlock နှင့် Flatlock စက်များဖြင့် ချုပ်လုပ်ထားသော Casual ဝတ်စုံများ။</p>
            </div>
        </div>

        <div class="product-card">
            <img src="pant.jpg" alt="Pant">
            <div class="content">
                <h3>Pant (ဘောင်းဘီ)</h3>
                <p>Formal နှင့် Casual Pant များကို Export အတွက် ထုတ်လုပ်သည်။</p>
            </div>
        </div>

        <div class="product-card">
            <img src="sportwear.jpg" alt="Sportswear">
            <div class="content">
                <h3>Sportswear</h3>
                <p>အားကစားဝတ်စုံများကို Flat Lock စက်ဖြင့် ချုပ်လုပ်သည်။</p>
            </div>
        </div>

        <div class="product-card">
            <img src="jacket.jpg" alt="Jacket">
            <div class="content">
                <h3>Jacket</h3>
                <p>ရာသီဥတုအလိုက် ဝတ်ဆင်နိုင်သော Jacket များကို ထုတ်လုပ်သည်။</p>
            </div>
        </div>

        <div class="product-card">
            <img src="uniform.jpg" alt="Uniform">
            <div class="content">
                <h3>Uniform</h3>
                <p>ကျောင်းဝတ်စုံ၊ အလုပ်ဝတ်စုံများကို အစုလိုက် ထုတ်လုပ်သည်။</p>
            </div>
        </div>

    </div>
</div>
<!-- ၇။ အကျိုးအမြတ်နှင့် အရှုံး -->
<div class="section">
    <h2>လုပ်ငန်း၏ အကျိုးအမြတ်နှင့် အရှုံး</h2>

    <div class="finance-grid">

        <!-- Profit Card -->
        <div class="finance-card profit">
            <h3>📈 အကျိုးအမြတ် (Profit)</h3>
            <ul>
                <li>ပြည်ပ Export မှ နိုင်ငံခြားဝင်ငွေ ရရှိခြင်း</li>
                <li>ဒေသခံ အလုပ်အကိုင် ဖန်တီးပေးခြင်း</li>
                <li>အစုလိုက်အပြုံလိုက် ထုတ်လုပ်နိုင်ခြင်းကြောင့် Unit Cost လျော့နည်းခြင်း</li>
                <li>Brand နာမည်တိုးတက်လာခြင်း</li>
                <li>နှစ်စဉ် အမြတ်ငွေ တိုးတက်လာနိုင်ခြင်း</li>
            </ul>
        </div>

        <!-- Loss Card -->
        <div class="finance-card loss">
            <h3>📉 အရှုံး (Loss)</h3>
            <ul>
                <li>ကုန်ကြမ်းဈေး တက်ခြင်း</li>
                <li>လျှပ်စစ်မီး မလုံလောက်မှုကြောင့် ထုတ်လုပ်မှု လျော့နည်းခြင်း</li>
                <li>နိုင်ငံခြား Order လျော့နည်းခြင်း</li>
                <li>အလုပ်သမား ထွက်ပြေးမှု</li>
                <li>စက်ပစ္စည်းပျက်စီးမှုနှင့် ပြုပြင်စရိတ်များ</li>
            </ul>
        </div>

    </div>

    <p style="margin-top:15px;">
        💡 မှတ်ချက် - စက်ရုံတစ်ခု၏ အကျိုးအမြတ်သည် Order ပမာဏ၊ ထုတ်လုပ်မှုစွမ်းရည်၊ကုန်ကြမ်းဈေးနှုန်းများအပေါ်မူတည်ပြီး ကွဲပြားနိုင်သည်။
    </p>
</div>

<section class="section">
<div class="container">

<h2>🏭 ပုသိမ်မြို့ရှိ အထည်ချုပ်လုပ်ငန်း၏ စီးပွားရေးအရေးပါမှု</h2>

<div class="card-grid">

<div class="card">
<h3>1️⃣ အလုပ်အကိုင်ဖန်တီးမှု</h3>
<p>စက်ရုံများမှ လူငယ်နှင့် အမျိုးသမီးများအတွက် အလုပ်အကိုင်အခွင့်အလမ်းများ ဖန်တီးပေးပြီး မိသားစုဝင်ငွေ တိုးတက်စေသည်။</p>
</div>

<div class="card">
<h3>2️⃣ ဒေသစီးပွားရေးလှုပ်ရှားမှု</h3>
<p>ကုန်ကြမ်းဝယ်ယူခြင်း၊ သယ်ယူပို့ဆောင်ခြင်းနှင့် စျေးကွက်တင်ရောင်းချမှုတို့မှ ဒေသတွင်း ငွေလှုပ်ရှားမှု တိုးတက်စေသည်။</p>
</div>

<div class="card">
<h3>3️⃣ နိုင်ငံတော်ဝင်ငွေ</h3>
<p>အခွန်ပေးဆောင်မှုနှင့် ပြည်ပတင်ပို့မှုများမှ နိုင်ငံတော်ဘဏ္ဍာဝင်ငွေ တိုးတက်စေသည်။</p>
</div>

<div class="card">
<h3>4️⃣ လူမှုရေးတိုးတက်မှု</h3>
<p>ဝင်ငွေတိုးတက်ခြင်းကြောင့် ပညာရေးနှင့် ကျန်းမာရေးအခြေအနေများ ပိုမိုကောင်းမွန်လာသည်။</p>
</div>

<div class="card">
<h3>5️⃣ နည်းပညာဖွံ့ဖြိုးမှု</h3>
<p>ခေတ်မီစက်ပစ္စည်းများအသုံးပြုခြင်းကြောင့် နည်းပညာကျွမ်းကျင်မှုများ တိုးတက်လာသည်။</p>
</div>

<div class="card">
<h3>6️⃣ အမြတ်နှင့် အရှုံး</h3>
<p><strong>အမြတ်:</strong> ဝင်ငွေတိုးတက်မှု၊ အလုပ်အကိုင်တိုးတက်မှု<br>
<strong>အရှုံး:</strong> ကုန်ကြမ်းဈေးမြင့်တက်ခြင်း၊ စျေးကွက်ပြိုင်ဆိုင်မှု</p>
</div>

</div>

<div class="highlight">
<strong>နိဂုံးချုပ် :</strong>ပုသိမ်မြို့ရှိ အထည်ချုပ်လုပ်ငန်းများသည် ဒေသစီးပွားရေးဖွံ့ဖြိုးတိုးတက်မှုအတွက် အရေးပါသော အခန်းကဏ္ဍတစ်ခုဖြစ်ပြီး ရေရှည်တည်တံ့သော စီးပွားရေးတိုးတက်မှုကိုဖြစ်စေနိုင်သည်။
</div>

</div>
</section>
<!-- ၉။ စီးပွားရေး အရေးပါမှု -->
<div class="section animated-section">
    <h2>စီးပွားရေး အရေးပါမှု</h2>
    <ul>
        <li>ဒေသခံအမျိုးသမီးများအတွက် အလုပ်အကိုင် ဖန်တီးပေးသည်</li>
        <li>မိသားစုဝင်ငွေ တိုးတက်စေသည်</li>
        <li>ပြည်ပသို့ Export လုပ်နိုင်သည်</li>
        <li>ဒေသစီးပွားရေးကို တိုးတက်စေသည်</li>
    </ul>
</div>

<div class="section animated-section" style="border-left:5px solid #e74c3c;">
    <h2>ကြုံတွေ့နေရသော စိန်ခေါ်မှုများ</h2>
    <ul>
        <li>လျှပ်စစ်မီး မလုံလောက်မှု</li>
        <li>ကုန်ကြမ်းဈေး တက်ခြင်း</li>
        <li>နိုင်ငံခြား Order လျော့နည်းခြင်း</li>
        <li>အလုပ်သမား ထွက်ပြေးမှု</li>
    </ul>
</div>
<!-- ပုသိမ် စက်မှုဇုန် Google Map -->
<div class="section">
    <h2>စက်မှုဇုန် တည်နေရာ (Pathein Industrial Zone)</h2>

    <div style="width:100%; height:400px; border-radius:15px; overflow:hidden; box-shadow:0 8px 20px rgba(0,0,0,0.15);">
        <iframe 
            src="https://www.google.com/maps?q=Pathein+Industrial+Zone,+Myanmar&output=embed"
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>

    <p style="margin-top:15px;">
        📍 ပုသိမ်မြို့ စက်မှုဇုန်အတွင်းရှိ အထည်ချုပ်စက်ရုံများကို မြေပုံမှတဆင့် ကြည့်ရှုနိုင်ပါသည်။
    </p>
</div>


    <button onclick="topFunction()" id="topBtn" title="Go to top">↑</button>

    <footer>
        <p>&copy; 2024 Pathein Garment Industry Info - Prepared for Knowledge Sharing</p>
    </footer>

    <script>
        // Scroll Button Logic
        let mybutton = document.getElementById("topBtn");

        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        function topFunction() {
            window.scrollTo({top: 0, behavior: 'smooth'});
        }

        // Simple Animation for List Items
        document.querySelectorAll('.process-list li').forEach((item, index) => {
            item.style.opacity = "0";
            item.style.transition = "all 0.5s ease";
            setTimeout(() => {
                item.style.opacity = "1";
                item.style.transform = "translateX(10px)";
            }, index * 200);
        });
    </script>
</body>
</html>