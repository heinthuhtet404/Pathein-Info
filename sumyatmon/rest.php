<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Myanmar Beaches Gallery</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Playfair+Display:ital@0;1&display=swap');

html, body {
  margin: 0;
  padding: 0;
  height: 100%;
  font-family: 'Quicksand', sans-serif;
  background: linear-gradient(135deg, #c2e0f0 0%, #b5d8e8 40%, #f5e6d3 100%);
  display: flex;
  justify-content: center;
  align-items: center;
}

body::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background-image: 
    url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 100" opacity="0.1"><path d="M0 50 Q 50 30, 100 50 T 200 50" stroke="%234283f5" fill="none" stroke-width="2"/><path d="M0 60 Q 50 40, 100 60 T 200 60" stroke="%233366cc" fill="none" stroke-width="2"/><path d="M0 70 Q 50 50, 100 70 T 200 70" stroke="%23224499" fill="none" stroke-width="1.5"/></svg>'),
    radial-gradient(circle at 20% 30%, rgba(255,255,255,0.3) 0%, transparent 30%),
    radial-gradient(circle at 90% 70%, rgba(255,215,0,0.15) 0%, transparent 40%);
  background-repeat: repeat-x, no-repeat, no-repeat;
  background-position: bottom, center, center;
  pointer-events: none;
  animation: waveMove 15s linear infinite;
  z-index: 0;
}

@keyframes waveMove {
  0% { background-position: 0 100%, center, center; }
  100% { background-position: 200px 100%, center, center; }
}

body::after {
  content: '🐚';
  position: absolute;
  bottom: 30px;
  right: 40px;
  font-size: 80px;
  opacity: 0.15;
  transform: rotate(15deg);
  filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.1));
  z-index: 1;
}

.gallery-container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  width: 100%;
  padding: 20px;
  box-sizing: border-box;
  position: relative;
  z-index: 2;
}

.gallery {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 35px;
  width: 100%;
  max-width: 1400px;
}

/* Card */
.card {
  background: rgba(255,255,255,0.75);
  backdrop-filter: blur(10px);
  border-radius: 60px 30px 80px 30px;
  overflow: hidden;
  box-shadow: 0 30px 50px rgba(0,40,80,0.2);
  display: flex;
  flex-direction: column;
  transition: transform 0.6s;
  position: relative;
}

.card:hover {
  transform: translateY(-15px);
}

.card img {
  width: 100%;
  height: 300px;
  object-fit: cover;
}

/* Card Title */
.card h3 {
  position: absolute;
  bottom: 80px;
  left: 0;
  right: 0;
  text-align: center;
  padding: 20px 10px;
  margin: 0;
  background: linear-gradient(to top, rgba(10,40,65,0.9), transparent);
  color: #fff9e6;
  font-size: 1.5rem;
  font-weight: 600;
  z-index: 2;
}

/* Buttons below card */
.card-buttons {
  display: flex;
  justify-content: center;
  gap: 12px;
  margin-top: 10px;
}

.card-buttons a {
  background: #ffffffcc;
  padding: 10px 22px;
  min-width: 120px;
  text-align: center;
  border-radius: 4px;
  font-size: 13px;
  text-decoration: none;
  color: #000;
  transition: all 0.3s;
}

.card-buttons .button-visit:hover {
  background: #ff9900;
  color:white;
}

.card-buttons .button-map:hover {
  background: #0099cc;
  color:white;
}

/* Back Button */
.back-btn {
  position:fixed;
  bottom:20px;
  right:20px;
  background:#ffffffcc;
  padding:10px 25px;
  border-radius:4px;
  font-size:14px;
  text-decoration:none;
  color:#000;
  box-shadow:0 4px 10px rgba(0,0,0,0.2);
  z-index:10;
}

.back-btn:hover {
  background:#ff6600;
  color:white;
}

</style>
</head>
<body>

<div class="gallery-container">
  <div class="gallery">

    <!-- Card 1 -->
    <div>
      <div class="card">
        <img src="ngwe1.jpg" alt="ငွေဆောင်ကမ်းခြေ">
        <h3>ငွေဆောင်ကမ်းခြေ</h3>
      </div>
      <div class="card-buttons">
        <a href="ngwe.php?location=bandula" class="button-visit">အသေးစိတ်ကြည့်ရှုရန်</a>
        <a target="_blank" href="https://www.google.com/maps/search/?api=1&query=Ngwe+Saung+Beach+Myanmar" class="button-map">Google Mapတွင်ကြည့်မည်</a>
      </div>
    </div>

    <!-- Card 2 -->
    <div>
      <div class="card">
        <img src="chaun1.jpg" alt="ချောင်းသာကမ်းခြေ">
        <h3>ချောင်းသာကမ်းခြေ</h3>
      </div>
      <div class="card-buttons">
        <a href="chaung.php?location=bandula" class="button-visit">အသေးစိတ်ကြည့်ရှုရန်</a>
        <a target="_blank" href="https://www.google.com/maps/search/?api=1&query=Chaung+Tha+Beach+Myanmar" class="button-map"> Google Mapတွင်ကြည့်မည်</a>
      </div>
    </div>

    <!-- Card 3 -->
    <div>
      <div class="card">
        <img src="gaw1.jpg" alt="ဂေါ်ရန်ဂျီကျွန်း">
        <h3>ဂေါ်ရန်ဂျီကျွန်း</h3>
      </div>
      <div class="card-buttons">
        <a href="gaw.php?location=bandula" class="button-visit">အသေးစိတ်ကြည့်ရှုရန်</a>
        <a target="_blank" href="https://www.google.com/maps/search/?api=1&query=Gaw+Yin+Gyi+Island+Myanmar" class="button-map"> Google Mapတွင်ကြည့်မည်</a>
      </div>
    </div>

  </div>
</div>

<!-- Back Button -->
<a href="javascript:history.back()" class="back-btn">← နောက်သို့</a>

</body>
</html>