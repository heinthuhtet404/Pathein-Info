<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>နှီးဘုရား</title>

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
.detail-btn,
.map-btn{
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

.detail-btn:hover,
.map-btn:hover{
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

<h1 class="title">နှီးဘုရား</h1>

<div class="container">
  <div class="card">
    <img src="n2.jpg" alt="Nhi Pagoda">
    <div class="content">
      <h2>နှီးဘုရား</h2>
      <p>
        ပုသိမ်မြို့၊ အမှတ် (၁၃) ရပ်ကွက်၊ ကိုးသိန်းအားကစားကွင်းအနီးတွင် ကိန်းဝပ်စံပယ်တော်မူသော ရွှေရောင်တော်နှီးဘုရားကြီးကို သက္ကရာဇ် ၁၂၇၄ ခုနှစ် (ခရစ်နှစ် ၁၉၁၂) တွင် စတင်တည်ထားခြင်းဖြစ်သည်။ ဤဘုရားကြီးသည် ဝါးနှီးများဖြင့် ပြုလုပ်ထားသော်လည်း ခိုင်ခံ့မှုရှိပြီး မြန်မာ့လက်မှုအနုပညာနှင့် ဘာသာရေးယုံကြည်မှု ပေါင်းစပ်ထားသည့် ပုသိမ်မြို့၏ ဂုဏ်ဆောင် အမှတ်အသားတစ်ခုဖြစ်သည်။
      </p>

      <a href="nipagodadetail.html" class="detail-btn">အသေးစိတ်ကြည့်ရှုရန်</a>

      <a href="https://www.google.com/maps/place/16.7745,94.7338"
         class="detail-btn"
         target="_blank">
         Google Map တွင်ကြည့်မည်
      </a>

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