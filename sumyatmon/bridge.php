<!DOCTYPE html>
<html lang="my">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iconic Bridges Gallery</title>

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Pyidaungsu','Segoe UI',sans-serif;
}

body{
  background:#ffffff;
  min-height:100vh;
  display:flex;
  justify-content:center;  /* horizontal center */
  align-items:center;      /* vertical center */
  flex-direction:column;
  padding:20px 20px 100px; /* bottom padding for back button */
}

/* Back Button - Bottom Right */
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
  transition:.3s;
  z-index:2000;
}

.back-btn:hover{
  transform:translateY(-3px) scale(1.05);
}

/* Container */
.container{
  display:flex;
  flex-wrap:wrap;
  justify-content:center;  /* horizontal center */
  align-items:center;      /* vertical center if multiple rows */
  gap:40px;
  max-width:1000px;
}

/* Bridge Card */
.bridge-card{
  position:relative;
  width:350px;
  height:480px;
  background:#fff;
  border-radius:25px;
  overflow:hidden;
  box-shadow:15px 15px 40px #d1d9e6,-15px -15px 40px #ffffff;
  transition:0.5s cubic-bezier(0.4,0,0.2,1);
}

.bridge-card:hover{
  transform:translateY(-15px);
}

.img-box{
  width:100%;
  height:100%;
}

.img-box img{
  width:100%;
  height:100%;
  object-fit:cover;
  transition:0.5s;
}

.content{
  position:absolute;
  bottom:-100%;
  left:0;
  width:100%;
  height:100%;
  background:rgba(255,255,255,0.2);
  backdrop-filter:blur(12px);
  -webkit-backdrop-filter:blur(12px);
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  padding:30px;
  transition:0.6s ease-in-out;
  text-align:center;
}

.bridge-card:hover .content{
  bottom:0;
}

.content h2{
  color:#2c3e50;
  font-size:1.6rem;
  margin-bottom:15px;
  font-weight:700;
}

.content p{
  color:#444;
  font-size:0.95rem;
  line-height:1.7;
  margin-bottom:25px;
}

.btn{
  padding:12px 25px;
  background:#2c3e50;
  color:#fff;
  text-decoration:none;
  border-radius:12px;
  font-size:0.9rem;
  font-weight:600;
  transition:0.3s;
  display:inline-block;
}

.btn:hover{
  background:#3498db;
  transform:scale(1.05);
}

.map-container{
  margin-top:20px;
  text-align:center;
}

@media(max-width:768px){
  .bridge-card{
    width:320px;
    height:450px;
  }
}
</style>
</head>

<body>

<!-- Back Button -->
<button class="back-btn" onclick="goBack()">⬅ နောက်သို့</button>

<div class="container">

<!-- Bridge 1 -->
<div class="bridge-card">
  <div class="img-box">
    <img src="b1.jpg">
  </div>
  <div class="content">
    <h2>အမှတ်(၁)တံတား</h2>
    <p>
    • သံကူကွန်ကရစ် ကြိုးတံတား (Suspension Bridge)။<br>
    • ပုသိမ်မြို့၊ ငဝန်မြစ်ကို ဖြတ်သန်း၍ မေယံချောင်းရွာနှင့် ကန္နီရွာတို့ကို ဆက်သွယ်ထားသည်။<br>
    • အရှည် ၂,၁၄၀ ပေ၊ ယာဉ်သွားလမ်း ၂၈ ပေ နှင့် တစ်ဖက်လျှင် ၄ ပေစီရှိသော လူသွားလမ်းများ ပါဝင်သည်။<br>
    • ၂၀၀၄ ခုနှစ်၊ နိုဝင်ဘာလ ၂၂ ရက်။<br>
    • ကာလကြာလာ၍ တံတားတိုင်များ ကြံ့ခိုင်မှုအားနည်းလာသဖြင့် ၂၀၂၀ တွင် တံတားအမှတ်(၂) တည်ဆောက်ခဲ့သည်။
    </p>
    <div class="map-container">
      <a href="https://www.google.com/maps/search/?api=1&query=Pathein+Bridge" target="_blank" class="btn">
         Google Map တွင်ကြည့်မည်
      </a>
    </div>
  </div>
</div>

<!-- Bridge 2 -->
<div class="bridge-card">
  <div class="img-box">
    <img src="b2.jpg">
  </div>
  <div class="content">
    <h2>အမှတ်(၂)တံတား</h2>
    <p>
    ပုသိမ်တံတား (၂) ကို ၂၀၁၈ ခုနှစ် အောက်တိုဘာတွင် စတင်တည်ဆောက်ခဲ့သည်။<br>
    • သံမဏိ သံပေါင်ခုံးတံတားဖြစ်ပြီး ကုန်ကျစရိတ် ၂၈.၅ ဘီလျံခန့်ရှိသည်။<br>
    • အရှည် ၂၃၈၀ ပေ၊ ယာဉ်လမ်း ၂၈ ပေ၊ လူသွားလမ်း ၅ ပေစီ ပါဝင်သည်။<br>
    • Load Test ပြုလုပ်ပြီး ၁၀၀% ပြီးစီးမည်ဖြစ်သည်။
    </p>
    <div class="map-container">
      <a href="https://www.google.com/maps/search/?api=1&query=Pathein+Bridge+2" target="_blank" class="btn">
         Google Map တွင်ကြည့်မည်
      </a>
    </div>
  </div>
</div>

</div>

<script>
function goBack(){
  window.history.back();
}
</script>

</body>
</html>