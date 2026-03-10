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

<h1 class="title">ကန်သုံးဆင့်ပန်းခြံ</h1>

<div class="text-box">
<p>ပုသိမ်မြို့ရှိ ကန်သုံးဆင့် သည် ဧရာဝတီတိုင်းဒေသကြီး၏ ထင်ရှားသော အမှတ်အသားတစ်ခုဖြစ်ပြီး မြို့ပြ၏မွန်းကြပ်မှုများမှ ကင်းဝေးစေသည့် အဓိကအပန်းဖြေနားခိုရာနေရာဖြစ်သည်။ ဤကန်သည် သဘာဝရေပြင်နှင့် စိမ်းလန်းသောပတ်ဝန်းကျင် ပေါင်းစပ်ထားသည့်အတွက် မြို့သူမြို့သားများ နံနက်ခင်းနှင့် ညနေခင်းများတွင် ကိုယ်လက်လှုပ်ရှား လမ်းလျှောက်ခြင်း၊ အားကစားပြုလုပ်ခြင်းနှင့် အနားယူခြင်းတို့အတွက် အစဉ်အမြဲစည်ကားလျက်ရှိသည်။ ကန်ပတ်ဝန်းကျင်တွင် ပုသိမ်တက္ကသိုလ် ကဲ့သို့သော အရေးကြီးသည့် ပညာရေးအဆောက်အအုံများ တည်ရှိပြီး ၊ ကန်အတွင်း၌လည်း လှေလှော်အားကစား လေ့ကျင့်မှုများနှင့် ငါးမျိုးစိုက်ထည့်ခြင်းလုပ်ငန်းများကို အခါအားလျော်စွာ ဆောင်ရွက်လေ့ရှိသည် [၁.၁.၂၃]။ ထို့ကြောင့် ကန်သုံးဆင့်သည် ပုသိမ်မြို့၏ သာယာလှပမှု၊ ကျန်းမာရေးနှင့် ပညာရေးကဏ္ဍတို့တွင် အချက်အချာကျသော အထင်ကရနယ်မြေ တစ်ခုအဖြစ် တည်ရှိနေပါသည်။</p>

</div>

<!-- Image Gallery -->
<div class="gallery">
    <img src="kt.jpg">
    <img src="ttt.jpg">
    <img src="rl.jpg">
    <img src="tree.jpg">
    >
</div>

</div>

</body>
</html>