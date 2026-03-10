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
    <img src="tt.jpg">
    <div class="text">
      <h2>သည်းဖြူကျွန်း </h2>
      <p>
        ချောင်းသာကမ်းခြေမှ စက်လှေဖြင့် ၁၅ မိနစ်ခန့် သွားရောက်ရသော ကျွန်းငယ်လေး ဖြစ်ပါသည်။
        ကျွန်းပတ်လည်တွင် ဖြူလွှသော သဲသောင်ပြင်များရှိပြီး ရေကြည်လင်သဖြင့် ရေကူးရန်နှင့် Snorkeling (ရေအောက်ငါးကြည့်ခြင်း) လုပ်ရန် အကောင်းဆုံးနေရာဖြစ်သည်။
        ရေတက်ချိန်တွင် သောင်ပြင်များ နစ်မြုပ်သွားတတ်သဖြင့် ရေကျချိန်တွင် သွားရောက်လည်ပတ်ရန် ပိုမိုသင့်လျော်ပါသည်။
      </p>
    </div>
  </div>

  <div class="card reverse">
    <img src="k.jpg">
    <div class="text">
      <h2>ကျောက်မောင်နှမ</h2>
      <p>ကမ်းခြေ၏ မြောက်ဘက်အစွန်းတွင် တည်ရှိပြီး ပင်လယ်ထဲတွင် ထူးခြားစွာ ပေါ်ထွက်နေသော ကျောက်ဆောင်ကြီးနှစ်ခု ဖြစ်ပါသည်။
         ရှေးယခင်က မောင်နှမနှစ်ယောက် ကျောက်ဖြစ်သွားရာမှ ဖြစ်ပေါ်လာသည်ဟု ဒေသအယူအဆရှိကြသည်။
         ဒီရေကျချိန်တွင် ကျောက်ဆောင်များအထိ လမ်းလျှောက်သွားနိုင်ပြီး ကျောက်ဆောင်ကြားရှိ ရေကန်ငယ်လေးများတွင် ငါးလေးများကို ကြည့်ရှုနိုင်ပါသည်။
         ဓာတ်ပုံရိုက်ရန် အလွန်နာမည်ကြီးသော နေရာတစ်ခုဖြစ်သည်။
      </p>
    </div>
  </div>

  <div class="card">
    <img src="pk.jpg">
    <div class="text">
      <h2>ဖိုးကုလားကျွန်း </h2>
      <p>
         ချောင်းသာကမ်းခြေနှင့် မျက်စိတစ်ဆုံး မြင်ရသော အကွာအဝေးတွင်ရှိပြီး စက်လှေဖြင့် ခဏချင်း ကူးရုံဖြင့် ရောက်ရှိနိုင်သော ကျွန်းကြီးတစ်ကျွန်း ဖြစ်ပါသည်။
         ကျွန်းပေါ်တွင် အုန်းပင်များ စီတန်းနေပြီး အေးချမ်းဆိတ်ငြိမ်သည်။ ဒေသထွက် အုန်းရည်ချိုချိုကို သောက်ရင်း အနားယူနိုင်သလို ကျွန်းကို ပတ်၍ စက်ဘီးစီးခြင်း၊ လမ်းလျှောက်ခြင်းများ ပြုလုပ်နိုင်ပါသည်။      </p>
    </div>
  </div>

</div>

</body>
</html>