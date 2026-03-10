<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cinema Showcase</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>

body{
  margin:0;
  font-family:'Poppins',sans-serif;
  background:#d1d9eb;
  padding:20px;
}

.container{
  max-width:800px;
  margin:auto;
  margin-bottom:70px; /* Back button safe spacing */
}

h1{
  text-align:center;
  margin-bottom:40px;
  color:#0077ff;
}

.card{
  display:flex;
  background:white;
  margin-bottom:30px;
  border-radius:20px;
  overflow:hidden;
  box-shadow:0 10px 25px rgba(0,0,0,0.15);
  transition:0.3s;
}

.card:hover{
  transform:translateY(-8px);
}

.card img{
  width:40%;
  height:400px;
  object-fit:cover;
  display:block;
}

.content{
  padding:25px;
  width:60%;
}

.content h2{
  margin-top:0;
  color:#0077ff;
}

.content ul{
  padding-left:0;
  list-style:none;
  color:black;
}

.content li{
  margin-bottom:8px;
  font-size:14px;
}

.btn{
  display:inline-block;
  margin-top:15px;
  padding:10px 20px;
  border-radius:30px;
  text-decoration:none;
  background:#0077ff;
  color:white;
  font-size:14px;
}

.reverse{
  flex-direction:row-reverse;
}

@media(max-width:600px){
  .card{flex-direction:column;}
  .card img,.content{width:100%;}
  .reverse{flex-direction:column;}
}

/* Back Button */
.back-btn {
  position: fixed;
  bottom: 30px; /* card နဲ့ နည်းနည်းနီးအောင် */
  right: 20px;
  background: #ffffffcc;
  padding: 10px 25px;
  border-radius: 4px;
  font-size: 14px;
  text-decoration: none;
  color: #000;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
  z-index: 10;
  transition: all 0.3s;
}

.back-btn:hover {
  background: #ff6600;
  color:white;
}

</style>
</head>

<body>

<div class="container">

<h1>ပုသိမ်မြို့ရှိရုပ်ရှင်ရုံများ</h1>

<!-- Mingalar Cinema -->
<div class="card">

<img src="cinema1.jpg" alt="Mingalar Cinema">

<div class="content">

<h2>Mingalar Cinema</h2>

<ul>
<li>🎬 Pathein မြို့၊ Ayeyarwady Region တွင်ရှိသော လူကြိုက်များသော ရုပ်ရှင်ရုံ</li>
<li>🎬 Mingalar Cinemas cinema chain ၏ အစိတ်အပိုင်းတစ်ခု</li>
<li>🎬 မြန်မာနှင့် နိုင်ငံခြား ရုပ်ရှင်အသစ်များ ပြသပေးသည်</li>
<li>🎬 လူငယ်များနှင့် မိသားစုများအတွက် အပန်းဖြေရန်ကောင်းသောနေရာ</li>
<li>🎬 Pathein မြို့တွင် entertainment အရေးပါတဲ့ cinema တစ်ခု</li>
</ul>

<a href="https://www.google.com/maps/search/?api=1&query=Mingalar+Cinemas+Pathein" target="_blank" class="btn">
 Google Map တွင်ကြည့်မည်
</a>

</div>
</div>

<!-- Century Cinema -->
<div class="card reverse">

<img src="cinema2.jpg" alt="Century Cinema">

<div class="content">

<h2>Century Cinema</h2>

<ul>
<li>🎬 Pathein မြို့ရှိ လူကြိုက်များသော ရုပ်ရှင်ရုံတစ်ခု</li>
<li>🎬 Century Cinemas cinema network အောက်တွင် လည်ပတ်သည်</li>
<li>🎬 မြန်မာနှင့် နိုင်ငံခြား ရုပ်ရှင်များကို အချိန်ဇယားအလိုက် ပြသသည်</li>
<li>🎬 မိသားစုနှင့် သူငယ်ချင်းများအတွက် အပန်းဖြေရန်နေရာ</li>
<li>🎬 Pathein မြို့တွင် entertainment center တစ်ခုအဖြစ် အသုံးများသည်</li>
</ul>

<a href="https://www.google.com/maps/search/?api=1&query=Century+Cinemas+Pathein" target="_blank" class="btn">
 Google Map တွင်ကြည့်မည်
</a>

</div>
</div>

</div>

<!-- Back Button -->
<a href="javascript:history.back()" class="back-btn">← နောက်သို့</a>

</body>
</html>