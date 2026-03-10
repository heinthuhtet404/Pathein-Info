<!DOCTYPE html>
<html lang="my">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ရုံး ၄ ခုအကြောင်း</title>

<style>
body{
    font-family: Pyidaungsu, sans-serif;
    background: #f2f2f2;
}

/* Header */
.header{
    text-align:center;
    padding:70px 20px;
    color:#3a3a3a;
    background: linear-gradient(45deg,#e0e0e0,#d6d6d6);
    border-radius:0 0 60px 60px;
}

/* Container */
.container{
    max-width:1200px;
    margin:60px auto;
    padding:0 20px;
    display:grid;
    grid-template-columns:repeat(2, 1fr);
    gap:35px;
}

/* Responsive (Mobile) */
@media(max-width:768px){
    .container{
        grid-template-columns:1fr;
    }
}

/* Card */
.card{
    background:#ffffff;
    border-radius:25px;
    overflow:hidden;
    transition:0.4s;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
}

/* Hover Effect */
.card:hover{
    transform:translateY(-10px);
}

/* Image */
.card img{
    width:100%;
    height:240px;
    object-fit:cover;
}

/* Content */
.card-content{
    padding:25px;
}

.card h2{
    color:#444;
    margin-bottom:15px;
}

.card p{
    color:#555;
    line-height:1.7;
}

/* Button inside Card */
.btn{
    display:inline-block;
    margin-top:15px;
    padding:10px 18px;
    background:#007bff;
    color:#fff;
    border-radius:8px;
    text-decoration:none;
    font-size:16px;
    font-weight:500;
    transition:0.3s;
}

.btn:hover{
    background:#0056b3;
}

/* Footer */
.footer{
    text-align:center;
    padding:25px;
    background:#e0e0e0;
    color:#3a3a3a;
    margin-top:60px;
    border-radius:60px 60px 0 0;
}

/* Back Button - Fixed Bottom Right */
.back-btn{
    position:fixed;
    bottom:20px;
    right:20px;
    background:linear-gradient(45deg,#95dbf4b3,#006d8b);
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:50px;
    cursor:pointer;
    font-weight:bold;
    box-shadow:0 5px 15px rgba(0,0,0,0.3);
    z-index:2000;
    transition:0.3s;
}

.back-btn:hover{
    transform:translateY(-3px) scale(1.05);
}
</style>
</head>

<body>

<div class="header">
    <h1>ပုသိမ်မြို့ရှိ ရုံးလုပ်ငန်းအကြောင်းများ</h1>
</div>

<div class="container">

<!-- Card 1 -->
<div class="card">
    <img src="Ep1.jpg" alt="ရုံး ၁">
    <div class="card-content">
        <h2>လျှပ်စစ်နှင့်စွမ်းအင်ဝန်ကြီးဌာန</h2>
        <p>ပုသိမ် EPC ရုံးဟာ ပုသိမ်မြို့ (Pathein), အေးယာဝတီတိုင်းဒေသကြီး, မြန်မာနိုင်ငံတွင်ရှိတဲ့ လျှပ်စစ်ဓာတ်အား ဖြန့်ဖြူးခြင်း၊ စီမံခန့်ခွဲမှုဆိုင်ရာ တာဝန်ယူတဲ့ ရုံး/ဌာန ဖြစ်ပါတယ်။...</p>
        <a href="https://www.google.com/maps/search/?api=1&query=Pathein+EPC+Office" target="_blank" class="btn"> Google Map တွင်ကြည့်မည်</a>
    </div>
</div>

<!-- Card 2 -->
<div class="card">
    <img src="off1.jpg" alt="ရုံး ၂">
    <div class="card-content">
        <h2>တိုင်းဒေသကြီးပညာရေးမှူးရုံး</h2>
        <p>ပုသိမ်မြို့ ပညာရေးမှူးရုံး သည် ပုသိမ်မြို့နယ်အတွင်းရှိ ပညာရေးလုပ်ငန်းများကို စီမံအုပ်ချုပ်ရန် တာဝန်ယူထားသော အစိုးရရုံးတစ်ခုဖြစ်သည်...</p>
        <a href="https://www.google.com/maps/search/?api=1&query=Pathein+Education+Office+Ayeyarwady" target="_blank" class="btn"> Google Map တွင်ကြည့်မည်</a>
    </div>
</div>

<!-- Card 3 -->
<div class="card">
    <img src="off2.jpg" alt="ရုံး ၃">
    <div class="card-content">
        <h2>ပတ်ဝန်းကျင်ထိန်းသိမ်းရေးဦးစီးဌာန</h2>
        <p>ပတ်ဝန်းကျင်ထိန်းသိမ်းရေး၊ EIA စစ်ဆေးခြင်း၊ သဘာဝပတ်ဝန်းကျင်ကို ကာကွယ်စောင့်ရှောက်ရေး စီမံခန့်ခွဲခြင်း...</p>
        <a href="https://www.google.com/maps/search/?api=1&query=Environmental+Conservation+Department+Pathein" target="_blank" class="btn">Google Map တွင်ကြည့်မည်</a>
    </div>
</div>

<!-- Card 4 -->
<div class="card">
    <img src="off3.jpg" alt="ရုံး ၄">
    <div class="card-content">
        <h2>ပုသိမ်ခရိုင်တရားရုံး</h2>
        <p>ပုသိမ်ခရိုင် တရားရုံး သည် မြန်မာနိုင်ငံအရှေ့တောင်အာရှတွင် တည်ရှိသည့် ပုသိမ်မြို အတွင်းရှိ ခရိုင်အဆင့် တရားရုံး ဖြစ်သည်...</p>
        <a href="https://www.google.com/maps/search/?api=1&query=Pathein+District+Court+Myanmar" target="_blank" class="btn">Google Map တွင်ကြည့်မည်</a>
    </div>
</div>

</div>

<!-- Back Button -->
<button class="back-btn" onclick="goBack()">⬅ နောက်သို့</button>

<script>
function goBack(){
    window.history.back();
}
</script>

</body>
</html>