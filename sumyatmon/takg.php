<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>တဂေါင်းဘုရား</title>

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
  padding-bottom:100px; /* button နဲ့ content မထိအောင် */
  transition:.4s;
}

/* Header */
.header{
  text-align:center;
  padding:20px;
}

.header h1{
  font-size:38px;
  color:black;
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
  z-index:2000; /* Card content ထက် အမြင့် */
}

.back-btn:hover{
  transform:translateY(-3px) scale(1.05);
}

/* Container */
.container{
  width:90%;
  max-width:1100px;
  margin:auto;
  position: relative;
  z-index:1;
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

/* Detail / Map Buttons */
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
<button class="back-btn" onclick="goBack()">⬅️ နောက်သို့</button>

<!-- Page Title -->
<h1 class="header">တဂေါင်းဘုရား</h1>

<div class="container">
  <div class="card">
    <img src="tk1.jpg" alt="Ta Gaung Pagoda">
    <div class="content">
      <h2>တဂေါင်းဘုရား</h2>
      <p>
        ဧရာဝတီတိုင်းဒေသကြီး၊ ပုသိမ်မြို့၏ အထင်ကရ ရွှေမုဋ္ဌောစေတီတော်မြတ်ကြီး၏ ရင်ပြင်တော် အရှေ့တောင်ထောင့်တွင် တဂေါင်းဘုရား တည်ရှိပါသည်။ အဆိုပါစေတီတော်ကို ရှေးအခါက တဂေါင်းနေပြည်တော်မှ ရောက်ရှိလာသော တဂေါင်းမင်းဆက်ဝင် တဂေါင်းမင်းသား (စောဖြူမင်းသား) က တည်ထားကိုးကွယ်ခဲ့ခြင်း ဖြစ်ပါသည်။ သမိုင်းအဆိုအရ သီရိဓမ္မာသောကမင်းကြီး တည်ထားခဲ့သော စေတီတော်ပေါင်း ရှစ်သောင်းလေးထောင်အနက် တစ်ဆူအဖြစ်လည်း ယုံကြည်ကြပါသည်။ တဂေါင်းဘုရားသည် အထက်မြန်မာပြည် တဂေါင်းယဉ်ကျေးမှုနှင့် အောက်မြန်မာပြည် ပုသိမ်ဒေသတို၏ ရှေးဟောင်းသမိုင်းဝင် ဆက်နွှယ်မှုကို ဖော်ပြနေသည့် သက်သေတစ်ခုဖြစ်ပြီး၊ ယနေ့တိုင် ပုသိမ်မြို့၏ အထင်ကရ သမိုင်းဝင်အမွေအနှစ်အဖြစ် ကြည်ညိုသပ္ပာယ်စွာ ဖူးမြော်နိုင်ပါသည်။ ပုသိမ်မြို့အတွင်းရှိ တဂေါင်းဘုရားလမ်း (Ta Gaung Pagoda Road) အနီးမှာ တည်ရှိပါတယ်။
      </p>

      <!-- Detail Button -->
      <a href="takgdetail.html" class="detail-btn">အသေးစိတ်ကြည့်ရှုရန်</a>

      <!-- Google Map Button -->
      <a href="https://www.google.com/maps/search/?api=1&query=16.76457,94.73456"
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