<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>စက်တော်ရာဘုရား</title>

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
  padding-bottom:80px; /* Back button safe spacing */
  transition:.4s;
}

/* Dark Mode */
body.dark{
  background:linear-gradient(135deg,#1f1a00,#3d3200,#665300);
  color:white;
}

/* Title */
.title{
  text-align:center;
  font-size:42px;
  margin:80px 0 30px;
  color:black;
}

body.dark .title{
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
  z-index:1000;
}

.back-btn:hover{
  transform:translateY(-3px);
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

/* Buttons */
.detail-btn{
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

.detail-btn:hover{
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

<h1 class="title">စက်တော်ရာဘုရား</h1>

<div class="container">
  <div class="card">
    <img src="s1.jpg" alt="Setawya Pagoda">
    <div class="content">
      <h2>စက်တော်ရာဘုရား</h2>
      <p>
        စက်တော်ရာဘုရား သည် ပုသိမ်မြို့ ၏ အထင်ကရသမိုင်းဝင် ဘာသာရေးနေရာတစ်ခုဖြစ်သည်။ ဤဘုရားကို ခန့်မှန်းအားဖြင့် ပုဂံခေတ်အတွင်း တည်ဆောက်ခဲ့ပြီး နောက်ပိုင်းတွင် ဒေသခံဘုရင်များမှ ပြန်လည်ပြုပြင် မြှင့်တင်ခဲ့သည်ဟု သမိုင်းမှတ်တမ်းများတွင် ဖော်ပြထားသည်။ စက်တော်ရာဘုရားသည် ပုသိမ်မြို့မြို့လယ်ပိုင်း၊ စက်တော်ရာလမ်း (Setawya Road) အနီးတွင် တည်ရှိပြီး ဘုရားဖူးများအတွက် လွယ်ကူစွာ သွားရောက်ဖူးမြော်နိုင်သည့် ဘာသာရေးအထင်ကရနေရာတစ်ခုဖြစ်သည်။
      </p>

      <a href="setyardetail.html" class="detail-btn">အသေးစိတ်ကြည့်ရှုရန်</a>

      <!-- Google Map Button -->
      <a href="https://www.google.com/maps/place/Setawya+Pagoda+Pathein+Myanmar/@16.77445,94.73350,17z"
         class="detail-btn"
         target="_blank">
         Google Map တွင်ကြည့်မည်
      </a>
    </div>
  </div>
</div>

<!-- Back Button -->
<button class="back-btn" onclick="goBack()">⬅️ နောက်သို့</button>

<script>
function goBack(){
  window.history.back();
}
</script>

</body>
</html>