<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gallery Layout</title>

<style>
body{
  margin:0;
  font-family:Arial, sans-serif;
  background:#f4f6f9;
}

.wrapper{
  width:90%;
  max-width:1300px;
  margin:50px auto;
  display:flex;
  gap:40px;
}

/* LEFT SIDE IMAGES */
.gallery{
  flex:2;
  display:flex;
  flex-direction:column;
  gap:20px;
}

/* Row */
.row{
  display:grid;
  gap:20px;
}

.row.two{
  grid-template-columns:repeat(2,1fr);
}

.row.one{
  grid-template-columns:1fr;
}

.gallery img{
  width:100%;
  height:250px;
  object-fit:cover;
  border-radius:12px;
  box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

/* RIGHT SIDE TEXT */
.text{
  flex:1;
  background:white;
  padding:30px;
  border-radius:12px;
  box-shadow:0 10px 25px rgba(0,0,0,0.1);
  display:flex;
  align-items:center;
}

.text p{
  line-height:1.8;
  font-size:16px;
}

/* Responsive */
@media(max-width:900px){
  .wrapper{
    flex-direction:column;
  }
}
</style>
</head>
<body>

<div class="wrapper">

  <!-- LEFT SIDE 7 IMAGES -->
  <div class="gallery">

    <div class="row two">
      <img src="p1.jpg">
      <img src="p2.jpg">
    </div>

    <div class="row one">
      <img src="p3.jpg">
    </div>

    <div class="row two">
      <img src="p4.jpg">
      <img src="p5.jpg">
    </div>

    <div class="row one">
      <img src="p6.jpg">
    </div>

    <div class="row one">
      <img src="p7.jpg">
    </div>

  </div>

  <!-- RIGHT SIDE TEXT -->
  <div class="text">
    <p>
      ဒီနေရာမှာ ပုံ ၇ ပုံအားလုံးအတွက် စုပေါင်းဖော်ပြချက်ရေးပါ။
      သမိုင်းကြောင်း၊ အရေးပါမှု၊ တည်နေရာနှင့် သက်ဆိုင်ရာ
      အချက်အလက်များကို ဒီဘက်မှာ ရေးနိုင်ပါသည်။
    </p>
  </div>

</div>

</body>
</html>