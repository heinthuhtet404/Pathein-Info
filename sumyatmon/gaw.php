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
    <img src="mk.jpg">
    <div class="text">
      <h2>မြင်းခေါင်းကျောက်ဆောင်</h2>
      <p>
        ဂေါ်ရန်ဂျီကျွန်းရဲ့ အထင်ကရဆုံး နေရာတစ်ခုဖြစ်ပြီး ပင်လယ်ထဲသို ထိုးထွက်နေသော ကျောက်ဆောင်ကြီး၏ ပုံသဏ္ဌာန်မှာ မြင်းခေါင်းနှင့် တူညီသောကြောင့် ခေါ်တွင်ခြင်းဖြစ်သည်။
        ကျောက်ဆောင်အပေါ်သို တက်ရောက်နိုင်ပြီး အမြင့်မှကြည့်လျှင် ဘေးတစ်ဖက်တစ်ချက်စီတွင် ပင်လယ်ပြာပြာနှင့် သဲသောင်ပြင်တိုကို တစ်ပြိုင်နက် မြင်တွေ့ရသည့် Panoramic View မှာ အလွန်လှပပါသည်။
        နေဝင်ချိန်တွင် မြင်းခေါင်းကျောက်ဆောင်နောက်ခံဖြင့် ရိုက်ကူးသည့် ပုံရိပ်များသည် ခရီးသွားများအကြား အလွန်ရေပန်းစားပါသည်။
      </p>
    </div>
  </div>

  <div class="card reverse">
    <img src="ntm.jpg">
    <div class="text">
      <h2>နတ်သမီးရေတွင်း</h2>
      <p>
        ပင်လယ်ကမ်းစပ် ကျောက်ဆောင်များကြားတွင် သဘာဝအလျောက် ဖြစ်ပေါ်နေသော ကျောက်ကန်ငယ်လေး ဖြစ်ပါသည်။
        ပင်လယ်ဒီရေတက်လာချိန်တွင် လှိင်းပုတ်ခတ်မှုကြောင့် ကျောက်ကန်ထဲသို ရေများ ဖြည့်တင်းပေးပြီး ရေကြည်လင်အေးမြနေတတ်သည်။
        လူတစ်ကိုယ်စာ ခပ်နက်နက်ရှိသော နေရာများရှိသဖြင့် သဘာဝကျောက်ကန်ထဲတွင် ရေစိမ်အနားယူရသည့် ခံစားမှုကို ပေးစွမ်းနိုင်ပါသည်။
      </p>
    </div>
  </div>

  <div class="card">
    <img src="nyk.jpg">
    <div class="text">
      <h2>ငရုတ်ကောင်းမြို့</h2>
      <p>
        ဂေါ်ရန်ဂျီကျွန်းသို သွားရာလမ်းတွင် ဖြတ်သန်းရသည့် ပင်လယ်ကမ်းခြေ အခြေစိုက် မြိုငယ်လေး ဖြစ်ပါသည်။
        ဒေသခံ ရေလုပ်သားများ၏ လူနေမှုဘဝကို လေ့လာနိုင်ပြီး လတ်ဆတ်သော ပင်လယ်စာများကို စျေးနှုန်းသက်သာစွာဖြင့် ဝယ်ယူရရှိနိုင်သည့် ဗဟိုချက်ဖြစ်သည်။
        ဒေသထွက် ငပိ၊ ငါးခြောက်နှင့် လက်ဆောင်ပစ္စည်းများ ဝယ်ယူရန် အကောင်းဆုံးနေရာဖြစ်ပြီး ခရီးသွားများအတွက် နားနေစခန်းတစ်ခုလည်း ဖြစ်ပါသည်။
      </p>
    </div>
  </div>

</div>

</body>
</html>