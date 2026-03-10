<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ပန်းခြံအကြောင်း</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI;
}

body{
    background:#f4faf3;
    padding:40px 0;
}

/* Container */
.container{
    width:90%;
    max-width:1200px;
    margin:auto;
}

/* Title */
.title{
    text-align:center;
    font-size:45px;
    color:#2e7d32;
    margin-bottom:40px;
}

/* Description */
.text-box{
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 8px 25px rgba(0,0,0,0.1);
    line-height:1.9;
    margin-bottom:50px;
}

/* Image Grid */
.gallery{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

.gallery img{
    width:100%;
    height:250px;
    object-fit:cover;
    border-radius:18px;
    transition:0.4s;
}

.gallery img:hover{
    transform:scale(1.05);
}

/* Back Button */
.back-btn{
    position:fixed;
    top:25px;
    left:25px;
    padding:10px 18px;
    border:none;
    border-radius:25px;
    background:#1b5e20;
    color:white;
    cursor:pointer;
}

</style>
</head>

<body>

<button class="back-btn" onclick="history.back()">⬅️ နောက်သို့</button>

<div class="container">

<h1 class="title">မဟာဗန္ဓုလပန်းခြံ</h1>

<div class="text-box">
ပုသိမ်မြို့၊ အမှတ် (၃) ရပ်ကွက်ရှိ မဟာဗန္ဓုလပန်းခြံသည် ကန်သုံးဆင့်အနီးတွင် တည်ရှိပြီး မြို့ခံများ ကိုယ်လက်လှုပ်ရှားပြုလုပ်ရန်နှင့် အပန်းဖြေရန် အဓိကအားထားရသော နေရာဖြစ်သည်။ ၎င်းတွင် ကလေးကစားကွင်းနှင့် ပြည်သူ့ဟစ်တိုင်တို့ရှိပြီး မြို့သာယာလှပရေးအတွက် အမြဲမပြတ် ထိန်းသိမ်းထားသည့် စည်ကားရာ အပန်းဖြေကွင်းတစ်ခု ဖြစ်ပါသည်။
</div>

<!-- Image Gallery -->
<div class="gallery">
    <img src="bdl.jpg">
    <img src="bdl1.jpg">
    <img src="bdl2.jpg">
    
</div>

</div>

</body>
</html>