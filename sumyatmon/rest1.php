<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pagoda & Park Gallery</title>

<link href="https://fonts.googleapis.com/css2?family=Saira+Stencil+One&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}

body{
  min-height:100vh;
  font-family:'Open Sans',sans-serif;
  background: radial-gradient(circle at 20% 20%, rgba(189, 205, 225, 0.8), transparent 40%),
              radial-gradient(circle at 80% 80%, rgba(191,219,254,.5), transparent 40%),
              linear-gradient(135deg,#e0f2fe 0%,#bfdbfe 100%);
  display:flex;
  justify-content:center;
  align-items:center;
  padding:40px 20px;
  color:#1a202c;
}

.gallery-container{
  width:100%;
  max-width:1200px;
  display:flex;
  flex-direction:column;
  align-items:center;
  gap:40px;
  margin-bottom:70px; /* Back button safe spacing */
}

.gallery-title{
  font-family:'Saira Stencil One',cursive;
  font-size:2.5rem;
  color:#1e40af;
  letter-spacing:2px;
  text-align:center;
}

.gallery{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
  gap:40px;
  width:100%;
}

.card-container{
  perspective:1500px;
  height:480px;
  cursor:pointer;
}

.card{
  position:relative;
  width:100%;
  height:100%;
  transform-style:preserve-3d;
  transition:transform .8s cubic-bezier(.175,.885,.32,1.275), box-shadow .4s;
  border-radius:25px;
}

.card-container:hover .card{
  transform:rotateY(180deg);
  box-shadow:0 0 40px rgba(59,130,246,.4);
}

.card-front,.card-back{
  position:absolute;
  width:100%;
  height:100%;
  backface-visibility:hidden;
  border-radius:25px;
  overflow:hidden;
  display:flex;
  flex-direction:column;
  box-shadow:0 15px 35px rgba(0,0,0,.1);
  border:2px solid rgba(255,255,255,.6);
}

.card-front img{
  width:100%;
  height:100%;
  object-fit:cover;
}

.card-back{
  background:white;
  transform:rotateY(180deg);
  justify-content:center;
  align-items:center;
  padding:35px;
  text-align:center;
  overflow-y:auto;
}

.card-back h3{
  margin-bottom:15px;
  font-size:1.8rem;
  color:#1e40af;
}

.card-back p{
  font-size:1rem;
  color:#4b5563;
  line-height:1.7;
  margin-bottom:25px;
}

.visit-btn{
  display:inline-block;
  padding:12px 30px;
  background:#3b82f6;
  color:white;
  text-decoration:none;
  border-radius:50px;
  font-weight:600;
  font-size:.95rem;
  transition:.3s;
  margin-top:10px;
}

.visit-btn:hover{
  background:#1d4ed8;
  transform:translateY(-2px);
}

.card-back::-webkit-scrollbar{
  width:6px;
}

.card-back::-webkit-scrollbar-thumb{
  background:#bfdbfe;
  border-radius:10px;
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

@media(max-width:600px){
  .gallery-container{padding:10px; margin-bottom:90px;}
  .card-container{height:450px;}
  .gallery-title{font-size:1.8rem;}
}
</style>
</head>

<body>

<div class="gallery-container">
  <h1 class="gallery-title">ပုသိမ်မြို့ရှိပန်းခြံများအကြောင်း</h1>

  <div class="gallery">

    <!-- Kan Thone Sint -->
    <div class="card-container">
      <div class="card">
        <div class="card-front">
          <img src="u.jpg" alt="Kan Thone Sint Park">
        </div>
        <div class="card-back">
          <h3>ကန်သုံးဆင့်</h3>
          <a href="rest2.php?location=kanthonsint" class="visit-btn">အသေးစိတ်ကြည့်ရန်</a>
          <a href="https://www.google.com/maps/search/?api=1&query=Pathein+Kanthonsint+Park+Myanmar" class="visit-btn" target="_blank">Google Mapတွင်ကြည့်မည်</a>
        </div>
      </div>
    </div>

    <!-- Bandula Park -->
    <div class="card-container">
      <div class="card">
        <div class="card-front">
          <img src="b.jpg" alt="Bandula Park">
        </div>
        <div class="card-back">
          <h3>ဗန္ဓုလပန်းခြံ</h3>
          <a href="rest3.php?location=bandula" class="visit-btn">အသေးစိတ်ကြည့်ရန်</a>
          <a href="https://www.google.com/maps/search/?api=1&query=Bandula+Park+Yangon+Myanmar" class="visit-btn" target="_blank">Google Mapတွင်ကြည့်မည်</a>
        </div>
      </div>
    </div>

    <!-- Heaven For You -->
    <div class="card-container">
      <div class="card">
        <div class="card-front">
          <img src="h.jpg" alt="Heaven For You">
        </div>
        <div class="card-back">
          <h3>Heaven For You</h3>
          <a href="rest4.php?location=heaven" class="visit-btn">အသေးစိတ်ကြည့်ရန်</a>
          <a href="https://www.google.com/maps/search/?api=1&query=Heaven+For+You+Pathein+Myanmar" class="visit-btn" target="_blank"> Google Mapတွင်ကြည့်မည်</a>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Back Button -->
<a href="javascript:history.back()" class="back-btn">← နောက်သို့</a>

</body>
</html>