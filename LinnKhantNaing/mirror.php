<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <title>မှန်စက်ရုံ | Glass Factory Project</title>

    <style>
        body{
            margin:0;
            font-family:"Myanmar Text","Noto Sans Myanmar",Arial,sans-serif;
            background:linear-gradient(to right,#e0f2fe,#e0f2fe);
            line-height:1.9;
            color:#1e293b;
        }

        /* Navigation Bar */
        nav{
            background:linear-gradient(to right,#0284c7,#0f766e);
            padding:18px 50px;
            position:sticky;
            top:0;
            z-index:1000;
            box-shadow:0 4px 10px rgba(0,0,0,0.15);
        }

        nav a{
            color:white;
            text-decoration:none;
            margin:0 18px;
            font-weight:600;
            letter-spacing:0.5px;
        }

        nav a:hover{
            border-bottom:2px solid #bae6fd;
            padding-bottom:5px;
        }

        /* Section Design */
        section{
            padding:60px 90px;
            background:white;
            margin:40px auto;
            width:85%;
            border-radius:14px;
            box-shadow:0 10px 25px rgba(0,0,0,0.08);
        }

        h2{
            color:#0369a1;
            margin-bottom:20px;
            border-left:6px solid #0f766e;
            padding-left:15px;
        }

        p, li{
            font-size:16px;
        }

        /* Process list */
        ol li{
            margin-bottom:10px;
        }

        /* Products */
        .products{
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap:30px;
            margin-top:30px;
        }

        .product{
            background:#f0f9ff;
            border-radius:15px;
            overflow:hidden;
            box-shadow:0 6px 15px rgba(0,0,0,0.1);
            transition:transform 0.3s;
        }

        .product:hover{
            transform:translateY(-8px);
        }

        .product img{
            width:100%;
            height:190px;
            object-fit:cover;
        }

        .product p{
            padding:15px;
            font-weight:bold;
            color:#075985;
        }

        /* Benefits */
        ul li{
            margin-bottom:10px;
        }

        /* Footer */
        footer{
            background:linear-gradient(to right,#0f766e,#0284c7);
            color:white;
            text-align:center;
            padding:30px 20px;
            margin-top:60px;
        }

        footer p{
            margin:5px;
            font-size:14px;
        }
        /* Working Principle */
.process-container{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
    gap:30px;
    margin-top:40px;
}

.process-card{
    background:#f8fafc;
    border-radius:16px;
    padding:30px 20px;
    text-align:center;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:transform 0.3s;
}

.process-card:hover{
    transform:translateY(-8px);
}

.process-number{
    width:45px;
    height:45px;
    background:#0284c7;
    color:white;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    margin:0 auto 15px;
}

.process-card h3{
    margin-bottom:10px;
    color:#475569;
}

.process-card p{
    font-size:14px;
    color:#475569;
}

.process-note{
    text-align:center;
    margin-top:30px;
    font-size:14px;
    color:#475569;
}
    </style>
</head>

<body>

<!-- Navigation -->
<nav>
    <a href="#home">Home</a>
    <a href="#about">စက်ရုံအကြောင်း</a>
    <a href="#location">တည်နေရာ</a>
    <a href="#process">ထုတ်လုပ်ပုံ</a>
    <a href="#products">ထုတ်ကုန်</a>
    <a href="#benefits">အကျိုးကျေးဇူး</a>
</nav>

<section id="home">
    <h2>ပင်မစာမျက်နှာ (Home)</h2>
    <p>
        မှန်စက်ရုံသည် လူနေမှုဘဝနှင့် စက်မှုလုပ်ငန်းများအတွက် မရှိမဖြစ်လိုအပ်သော
        မှန်ထုတ်ကုန်များကို စနစ်တကျ ထုတ်လုပ်ပေးသော စက်မှုလုပ်ငန်းတစ်ခုဖြစ်ပါသည်။
        ဤ website သည် မှန်စက်ရုံ၏ လုပ်ငန်းစဉ်များ၊ ထုတ်ကုန်များနှင့်
        အကျိုးကျေးဇူးများကို လေ့လာနိုင်ရန် ဖန်တီးထားပါသည်။
    </p>
</section>

<section id="about">
    <h2>စက်ရုံအကြောင်း (About)</h2>
    <p>
        မှန်စက်ရုံသည် ခေတ်မီနည်းပညာများကို အသုံးပြု၍အရည်အသွေးမြင့် မှန်ထုတ်ကုန်များကို ထုတ်လုပ်ပေးသော
    စက်မှုလုပ်ငန်းတစ်ခုဖြစ်ပါသည်။လူနေအိမ်များ၊ စီးပွားရေးအဆောက်အဦးများနှင့်စက်မှုလုပ်ငန်းအမျိုးမျိုးတွင် အသုံးပြုနိုင်သော
    မှန်အမျိုးအစားများကို စနစ်တကျ ထုတ်လုပ်လျက်ရှိပါသည်။ထိုမှန်စက်ရုံသည် အရည်အသွေး၊ လုံခြုံရေးနှင့်ပတ်ဝန်းကျင်ထိန်းသိမ်းရေးကို ဦးစားပေးထားပြီးနောက်ဆုံးပေါ် စက်ကိရိယာများနှင့်ကျွမ်းကျင်သော အလုပ်သမားများကို အသုံးပြုထားပါသည်။ထို့အပြင် ပြည်တွင်းလိုအပ်ချက်များကို ဖြည့်ဆည်းပေးနိုင်ရန်
    ဆက်လက်တိုးချဲ့ ထုတ်လုပ်သွားရန် ရည်ရွယ်ထားပါသည်။
    </p>
</section>

<section id="location">
    <h2>တည်နေရာ (Location)</h2>
    <p>
        
ပုသိန်မြို့ရှိ မှန်စက်ရုံသည် အစိုးရပိုင် စက်ရုံတစ်ရုံဖြစ်ပြီး ၁၉၇၇ ခုနှစ်တွင် စတင်တည်ဆောက်ခဲ့ခြင်း ဖြစ်ပါသည်။အမှတ် (၃၆) အကြီးစားမှန်စက်ရုံ (ပုသိမ်)ဟုလူသိများပြီးစက်မှုဝန်ကြီးဌာန၊ အမှတ် (၂) အကြီးစားစက်မှုလုပ်ငန်း၏ ကြီးကြပ်မှုအောက်တွင် ရှိပါသည်။ ဧရာဝတီတိုင်းဒေသကြီး၊ ပုသိမ်မြို့ မြောက်ဘက် (၇) မိုင်အကွာ၊ ပုသိမ်-ဝါးယားချောင်းသွား ကားလမ်းမပေါ်ရှိ ကြည်သာကျေးရွာမှ အရှေ့ဘက် (၁) မိုင်ခန့်အကွာတွင် တည်ရှိပါသည်။ စုစုပေါင်း ဧရိယာ ၆၇၈.၅၀ ဧက ရှိပြီး စက်ရုံမြေ ၁၉၅.၄၃ ဧက နှင့် ဝန်ထမ်းအိမ်ရာမြေ ၄၈၃.၀၇ ဧက ပါဝင်ပါသည်။
    </p>
</section>

<section id="process">
    <h2>ထုတ်လုပ်ပုံအဆင့်ဆင့် (Manufacturing Process)</h2>
    
        <p>ပုသိမ်မှန်စက်ရုံ (အမှတ် ၃၆ အကြီးစားစက်ရုံ) ၏ မှန်ထုတ်လုပ်မှု လုပ်ငန်းစဉ်မှာ အောက်ပါအတိုင်း ဖြစ်ပါသည်။စက်ရုံတွင် အကြည်မှန် (Clear Glass) များကို အဓိကအားဖြင့် Float Glass နည်းစဉ်ဖြင့် ထုတ်လုပ်လေ့ရှိပြီး အခြေခံအဆင့်များမှာ -</p>
    
    <div class="process-container">

        <div class="process-card">
            <div class="process-number">1</div>
            <h3>ကုန်ကြမ်းစုဆောင်းခြင်း</h3>
            <p>
               သဲဖြူ (Silica Sand)၊ ဆိုဒါပြာ (Soda Ash)၊ ထုံးကျောက် (Limestone) နှင့် ဒိုလိုမိုက် (Dolomite) တို့ကို အချိုးကျရောစပ်ပါသည်။
            </p>
        </div>

        <div class="process-card">
            <div class="process-number">2</div>
            <h3>အရည်ကျိုခြင်း</h3>
            <p>
                ရောစပ်ထားသော ကုန်ကြမ်းများကို အပူဒီဂရီ ၁၅၀၀°C မှ ၁၆၀၀°C ခန့်ရှိသော ဖိုကြီးများအတွင်း ထည့်သွင်း၍ အရည်ကျိုပါသည်။
            </p>
        </div>

        <div class="process-card">
            <div class="process-number">3</div>
            <h3>ပုံသဏ္ဌာန် ဖော်ခြင်း</h3>
            <p>
               အရည်ပျော်နေသော မှန်ရည်များကို အရည်ပျော်နေသော သံဖြူ (Molten Tin) ဗန်းပေါ်သို့ စီးဆင်းစေပြီး ပြန့်ပြူးသော မှန်ချပ်မျက်နှာပြင် ဖြစ်လာစေရန် ဆောင်ရွက်ပါသည်။
            </p>
        </div>

        <div class="process-card">
            <div class="process-number">4</div>
            <h3>အအေးခံခြင်း</h3>
            <p>
               မှန်ချပ်များ ခိုင်မာစေရန်နှင့် ကွဲအက်ခြင်းမရှိစေရန် အပူချိန်ကို စနစ်တကျ တဖြည်းဖြည်း လျှော့ချကာ အအေးခံစက် (Lehr) အတွင်း ဖြတ်သန်းစေပါသည်
            </p>
        </div>
        <div class="process-card">
            <div class="process-number">5</div>
            <h3>ဖြတ်တောက်ခြင်းနှင့် စစ်ဆေးခြင်း</h3>
            <p>
               လိုအပ်သော ဆိုဒ်များအတိုင်း စက်ဖြင့် အလိုအလျောက် ဖြတ်တောက်ပြီး အရည်အသွေး စစ်ဆေးကာ ထုပ်ပိုးပါသည်။
            </p>
        </div>

    </div>

    <div class="process-note">
အဓိကထုတ်လုပ်သော အထူများမှာ၃ မီလီမီတာ (3mm) မှ ၁၂ မီလီမီတာ (12mm) အထိ အကြည်မှန် (Clear Float Glass) များကို အဓိကထား ထုတ်လုပ်ပါသည်
    </div>
</section>

<section id="products">
    <h2>ထုတ်ကုန်များ (Products)</h2>

    <div class="products">
        <div class="product">
            <img src="p14.jpg">
           
        </div>

        <div class="product">
            <img src="p9.jpg">

        </div>

        <div class="product">
            <img src="p12.jpg">
            
        </div>

        <div class="product">
            <img src="p13.jpg">
            
        </div>

        <div class="product">
            <img src="p17.jpg">
            
        </div>
    </div>
</section>

<section id="benefits">
    <h2>အကျိုးကျေးဇူးများ (Benefits)</h2>
    <ul>
        <li>ဒေသခံများအတွက် အလုပ်အကိုင်အခွင့်အလမ်းများ ဖန်တီးပေးနိုင်သည်</li>
        <li>ဆောက်လုပ်ရေးနှင့် စက်မှုလုပ်ငန်းများကို အထောက်အကူပြုသည်</li>
        <li>ပြည်တွင်းထုတ်လုပ်မှုကြောင့် ကုန်ကျစရိတ် သက်သာစေသည်</li>
        <li>နိုင်ငံ့စီးပွားရေး ဖွံ့ဖြိုးတိုးတက်မှုကို ကူညီပေးသည်</li>
    </ul>
</section>

<footer>
    <p>© 2026 Glass Factory Project</p>
    <p>PHP & HTML Academic Project</p>
</footer>

</body>
</html>