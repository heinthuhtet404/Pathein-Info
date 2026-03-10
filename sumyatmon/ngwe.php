<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ngwe Saung Famous Places</title>

<style>

body{
  margin:0;
  font-family:'Poppins',sans-serif;
  background: linear-gradient(-45deg,#90e0ef,#ade8f4,#caf0f8,#bde0fe);
  background-size:400% 400%;
  animation: gradientMove 12s ease infinite;
  
}

/* Background Animation */
@keyframes gradientMove{
  0%{background-position:0% 50%;}
  50%{background-position:100% 50%;}
  100%{background-position:0% 50%;}
}

/* Title */
.title{
  text-align:center;
  font-size:50px;
  padding:60px 0;
  color:#023e8a;
  letter-spacing:2px;
  animation: fadeDown 1.2s ease;
}

/* Fade Animation */
@keyframes fadeDown{
  from{opacity:0; transform:translateY(-30px);}
  to{opacity:1; transform:translateY(0);}
}

/* Container */
.container{
  width:90%;
  max-width:1100px;
  margin:auto;
}

/* Card */
.card{
  position:relative;
  display:flex;
  align-items:center;
  gap:30px;
  padding:30px;
  margin:60px 0;
  border-radius:35px;
  background:rgba(255,255,255,0.75);
  backdrop-filter:blur(15px);
  box-shadow:0 20px 50px rgba(0,0,0,0.15);
  transition:all 0.6s cubic-bezier(.23,1,.32,1);
  overflow:hidden;
  animation: fadeUp 1.2s ease both;
}

/* Smooth Fade Up */
@keyframes fadeUp{
  from{opacity:0; transform:translateY(50px);}
  to{opacity:1; transform:translateY(0);}
}

/* Floating Hover */
.card:hover{
  transform:translateY(-18px) scale(1.03);
  box-shadow:0 30px 70px rgba(0,0,0,0.25);
}

/* Shine Effect */
.card::after{
  content:"";
  position:absolute;
  top:-100%;
  left:-100%;
  width:200%;
  height:200%;
  background:linear-gradient(120deg,transparent,rgba(255,255,255,0.4),transparent);
  transform:rotate(25deg);
  transition:0.7s;
}

.card:hover::after{
  top:100%;
  left:100%;
}

/* Image */
.card img{
  width:350px;
  height:230px;
  object-fit:cover;
  border-radius:25px;
  transition:transform 0.6s ease, filter 0.6s ease;
}

/* Image Effect */
.card:hover img{
  transform:scale(1.1);
  filter:brightness(1.1);
}

/* Text */
.text h2{
  font-size:28px;
  color:#0077b6;
  margin-bottom:15px;
  transition:0.4s;
}

.text p{
  font-size:17px;
  line-height:1.8;
  color:#333;
}

/* Title color shift on hover */
.card:hover h2{
  color:#0096c7;
}

/* Reverse layout */
.reverse{
  flex-direction:row-reverse;
}

/* Responsive */
@media(max-width:768px){
  .card{
    flex-direction:column;
    text-align:center;
  }

  .card img{
    width:100%;
    height:250px;
  }
}

</style>
</head>

<body>

<h1 class="title">ထင်ရှားသောနေရာများ</h1>

<div class="container">

  <div class="card">
    <img src="ct.jpg">
    <div class="text">
      <h2>ချစ်သူများကျွန်း</h2>
      <p>
        ငွေဆောင်ကမ်းခြေရဲ့ တောင်ဘက်အစွန်းမှာရှိတဲ့ ကျောက်ဆောင်ကျွန်းငယ်လေး ဖြစ်ပါတယ်။
        ဒီရေကျချိန်မှာ ကမ်းခြေကနေ ကျွန်းဆီကို သဲသောင်ပြင်လမ်းလေး ပေါ်လာတတ်ပြီး လမ်းလျှောက်သွားလို ရပါတယ်။ ရေတက်ချိန်မှာတော့ ကျွန်းကလေးက ပင်လယ်ထဲမှာ သီးသန့်ဖြစ်နေတတ်ပါတယ်။
        ကျွန်းပေါ်မှာရှိတဲ့ သစ်ပင်ရိပ်တွေအောက်မှာ အနားယူနိုင်သလို၊ ကျောက်ဆောင်တွေကြားမှာ ရေကူးတာ၊ ငါးဖမ်းတာတွေ လုပ်နိုင်ပါတယ်။ 
        နေဝင်ချိန်မှာ ချစ်သူစုံတွဲတွေ လမ်းလျှောက်ရင်း ဓာတ်ပုံရိုက်ဖို အကောင်းဆုံးနေရာ ဖြစ်ပါတယ်။
      </p>
    </div>
  </div>

  <div class="card reverse">
    <img src="e.jpg">
    <div class="text">
      <h2>ဆင်စခန်း</h2>
      <p>
       ငွေဆောင်သိုအသွား လမ်းခရီး (ပုသိမ်-ငွေဆောင်လမ်း) ပေါ်တွင် တည်ရှိပြီး သဘာဝတောတောင်အလှကို ခံစားနိုင်တဲ့ နေရာတစ်ခု ဖြစ်ပါတယ်။
       ဆင်စီးပြီး တောတောင်အလှကြည့်ရှုနိုင်ခြင်း၊ ဆင်လေးတွေကို အစာကျွေးခြင်းနဲ့ ရေချိုးပေးခြင်း စတဲ့ အတွေ့အကြုံသစ်တွေကို ရရှိနိုင်ပါတယ်။
      </p>
    </div>
  </div>

  <div class="card">
    <img src="ii.jpg">
    <div class="text">
      <h2> ဘုရားသုံးဆူ </h2>
      <p>
        ငွေဆောင်ကမ်းခြေ၏ တောင်ဘက်အစွန်းတွင် တည်ရှိပြီး ပင်လယ်ကမ်းစပ်ရှိ သဘာဝကျောက်ဆောင်ကြီးများပေါ်တွင် စေတီတော်သုံးဆူကို ကြည်ညိုဖွယ်ရာ တည်ထားခြင်းဖြစ်ပါသည်။
        ပင်လယ်ဒီရေတက်ချိန်တွင် ရေလယ်၌ သပ္ပာယ်စွာ တည်ရှိနေပြီး၊ ရေကျချိန်တွင် ကမ်းခြေမှတစ်ဆင့် ခြေကျင်လျှောက်၍ သွားရောက်ဖူးမြော်နိုင်ပါသည်။
      </p>
    </div>
  </div>

</div>

</body>
</html>