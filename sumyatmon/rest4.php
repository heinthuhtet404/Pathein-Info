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

<h1 class="title">Heaven For You</h1>

<div class="text-box">
ပုသိမ်မြို့ရှိ Heaven for you-garden and resort သည် သဘာဝအလှတရားကို ချစ်မြတ်နိုးသူများအတွက် စိမ်းလန်းစိုပြေသော ဥယျာဉ်ပတ်ဝန်းကျင်တွင် အေးချမ်းစွာ အနားယူနိုင်သည့် နေရာတစ်ခုဖြစ်ပါသည်။ ဤနေရာသည် ကလေး၊ လူငယ်၊ လူကြီး အရွယ်မရွေး စိတ်အပန်းဖြေရန် သင့်တော်ပြီး၊ လှပသော ပန်းခြံရှုခင်းများကြောင့် ဓာတ်ပုံရိုက်ဝါသနာပါသူများအကြား အထူးရေပန်းစားပါသည်။ မိသားစုလိုက်ဖြစ်စေ၊ မိတ်ဆွေသူငယ်ချင်းများနှင့်ဖြစ်စေ လာရောက်လည်ပတ်နိုင်ကာ Picnic ထွက်ခြင်း၊ ရေကူးခြင်းနှင့် ကလေးများအတွက် ကစားကွင်းများလည်း ပါဝင်သောကြောင့် ပုသိမ်မြို့အနီးတဝိုက်တွင် ခရီးတိုအပျော်ခရီးသွားရန် အကောင်းဆုံး အပန်းဖြေစခန်းတစ်ခု ဖြစ်ပါသည်။
</div>

<!-- Image Gallery -->
<div class="gallery">
    <img src="fish.jpg">
    <img src="sw.jpg">
    <img src="ppk.jpg">
    

</div>

</body>
</html>