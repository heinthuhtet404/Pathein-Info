<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>လေးကျွန်းရန်အောင်ဖောင်တော်ဦးစေတီတော်</title>

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
  padding-bottom:100px; /* Back button နဲ့ content မထိအောင် */
  transition:.4s;
}

/* Title / Header */
.title{
  text-align:center;
  font-size:38px;
  color:black;
  margin:40px 20px 20px;
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
  z-index:2000; /* content ထက်အမြင့် */
}

.back-btn:hover{
  transform:translateY(-3px) scale(1.05);
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
  position: relative;
  z-index:1;
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

.content p{
  line-height:1.8;
  margin-bottom:20px;
  color:black;
}

/* Detail Buttons */
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

<!-- Back Button -->
<button class="back-btn" onclick="goBack()">⬅ နောက်သို့</button>

<!-- Title Centered -->
<h1 class="title">လေးကျွန်းရန်အောင်ဖောင်တော်ဦးစေတီတော်</h1>

<div class="container">
  <div class="card">
    <img src="y3.jpg" alt="Shwe Pagoda">
    <div class="content">
      <h2>လေးကျွန်းရန်အောင်ဖောင်တော်ဦးစေတီတော်</h2>
      <p>
        လေးကျွန်းမာရ်အောင် ဖောင်တော်ဦးစေတီတော် သည် ပုသိမ်မြို့၊ ဧရာဝတီတိုင်းဒေသကြီးတွင် တည်ရှိသော သမိုင်းဝင်စေတီတော်တစ်ဆူဖြစ်သည်။ 
        စေတီတော်သည် ပုသိမ်မြို့အတွင်းရှိ ရှေးဟောင်းဘာသာရေးအထင်ကရနေရာတစ်ခုဖြစ်ပြီး ဘုရားဖူးများအများအပြားလာရောက်ဖူးမြော်ကြပါသည်။
      </p>

      <!-- Detail Button -->
      <a href="yakyidetail.html" class="detail-btn">အသေးစိတ်ကြည့်ရှုရန်</a>

      <!-- Google Map Button -->
      <a href="https://www.google.com/maps/search/?api=1&query=Laykyun+Yaung+Aung+PhaungdawOo+Pagoda+Pathein+Myanmar"
         class="detail-btn"
         target="_blank">
          Google Map တွင်ကြည့်မည်
      </a>

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