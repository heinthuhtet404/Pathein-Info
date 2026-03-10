<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ရွှေမုဌောဘုရား</title>

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Segoe UI',sans-serif;
}

body{
  background:linear-gradient(135deg,#def8fc,#e2ffff,#ddf7fa);
  min-height:100vh;
  transition:.4s;
  padding-bottom:80px; /* Back button safe spacing */
}

/* Dark Mode */
body.dark{
  background:linear-gradient(135deg,#1f1a00,#3d3200,#665300);
  color:white;
}

/* Header */
.header{
  text-align:center;
  padding:40px 20px 20px;
}

.header h1{
  font-size:38px;
  color:black;
}

body.dark .header h1{
  color:black;
}

/* Back Button - bottom-right fixed */
.back-btn{
  position:fixed;
  bottom:30px;
  right:30px;
  background:linear-gradient(45deg,#95dbf4b3,#006d8b);
  color:white;
  border:none;
  padding:10px 18px;
  border-radius:25px;
  cursor:pointer;
  font-weight:bold;
  box-shadow:0 5px 15px rgba(0,0,0,0.2);
  transition:.3s;
  z-index:10;
}

.back-btn:hover{
  transform:translateY(-3px);
}

/* Title */
.title{
  text-align:center;
  font-size:42px;
  margin:40px 0 30px;
  color:black;
}

body.dark .title{
  color:black;
}

/* Container */
.container{
  width:90%;
  max-width:1100px;
  margin:auto;
}

/* Card */
.card{
  display:flex;
  align-items:center;
  margin:40px 0;
  border-radius:20px;
  background:rgba(255,255,255,0.5);
  backdrop-filter:blur(15px);
  box-shadow:0 15px 35px rgba(0,0,0,0.15);
  overflow:hidden;
  transition:.4s;
}

body.dark .card{
  background:rgba(255,255,255,0.08);
}

.card:hover{
  transform:translateY(-5px);
}

/* Image */
.card img{
  width:45%;
  height:400px;
  object-fit:cover;
}

/* Content */
.content{
  padding:35px;
}

.content h2{
  color:black;
  margin-bottom:15px;
}

body.dark .content h2{
  color:black;
}

.content p{
  line-height:1.8;
  margin-bottom:20px;
  color:black;
}

/* Detail Buttons */
.detail-btn, .map-btn{
  display:inline-block;
  padding:10px 20px;
  background:linear-gradient(45deg,#95dbf4b3,#006d8b);
  color:white;
  text-decoration:none;
  border-radius:25px;
  font-weight:bold;
  transition:.3s;
  box-shadow:0 5px 15px rgba(0,0,0,0.2);
  margin-right:10px;
}

.detail-btn:hover, .map-btn:hover{
  transform:translateY(-3px);
}

/* Responsive */
@media(max-width:768px){
  .card{
    flex-direction:column;
  }

  .card img{
    width:100%;
    height:250px;
  }

  .content{
    text-align:center;
  }
}
</style>
</head>

<body>

<button class="back-btn" onclick="goBack()">⬅ နောက်သို့</button>

<h1 class="title">ရွှေမုဌောဘုရား</h1>

<div class="container">
  <div class="card">
    <img src="pp1.jpg" alt="Shwe Pagoda">
    <div class="content">
      <h2>ရွှေမုဌောဘုရား</h2>
      <p>
        ရွှေမုဌောစေတီတော် သည် ပုသိမ်မြို့၊ ဧရာဝတီတိုင်းဒေသကြီး တွင်တည်ရှိသော အထင်ကရသမိုင်းဝင်စေတီတော်တစ်ဆူဖြစ်သည်။ ဤစေတီတော်ကို အိန္ဒိယဘုရင် အာသောကမင်းက ခန့်မှန်းအားဖြင့် ခရစ်မတိုင်မီ ၃၀၅ ခုနှစ်ခန့်တွင် တည်ခဲ့သည်ဟုဆိုကြသည်။ နောက်ပိုင်းတွင် အလောင်းစည်သူမင်း က ခရစ်နှစ် ၁၁၁၅ ခုနှစ်တွင် ပြန်လည်မြှင့်တင်တည်ဆောက်ခဲ့သည်ဟု သမိုင်းမှတ်တမ်းများတွင်ဖော်ပြထားသည်။ စေတီတော်သည် ပုသိမ်မြို့၏ မြို့လယ်ပိုင်း၊ ရွှေမုဌောဘုရားလမ်း (Shwemokhtaw Pagoda Road) အနီးတွင် တည်ရှိပြီး ဒေသ၏ အရေးပါသော ဘာသာရေးအထင်ကရနေရာတစ်ခုဖြစ်သည်။
      </p>

      <!-- Detail Button -->
      <a href="smdetail.html" class="detail-btn">အသေးစိတ်ကြည့်ရှုရန်</a>

      <!-- Google Map Button -->
      <a href="https://www.google.com/maps/search/?api=1&query=Nhi+Pagoda+Pathein" target="_blank" class="map-btn">
        Google Map တွင်ကြည့်မည်
      </a>

    </div>
  </div>
</div>

<script>
function toggleDark(){
  document.body.classList.toggle("dark");
}

function goBack(){
  window.history.back();
}
</script>

</body>
</html>