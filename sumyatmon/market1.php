<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pathein Markets Showcase</title>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');

  body {
    margin: 0;
    font-family: 'Pyidaungsu', sans-serif;
    background-color: #cbe0f6;
    color: #4a566c;
    padding: 40px 20px;
  }

  .title {
    text-align: center;
    font-size: 34px;
    margin-bottom: 50px;
    color: #1a365d;
    font-weight: 700;
  }

  .container {
    max-width: 1200px;
    margin: auto;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
    margin-bottom: 70px; /* Back button နဲ့ safe distance */
  }

  .card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: 0.3s;
    border: 1px solid rgba(255,255,255,0.8);
    width: 350px;
    display: flex;
    flex-direction: column;
  }

  .card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
  }

  .img-box {
    width: 100%;
    height: 220px;
  }

  .img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .card-content {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .card-content h2 {
    margin: 0 0 15px;
    color: #2c5282;
    font-size: 26px;
    text-align: center;
  }

  .info-group {
    display: flex;
    flex-direction: column;
    gap: 15px;
    flex-grow: 1;
  }

  .info-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }

  .tag {
    display: inline-block;
    width: fit-content;
    background: linear-gradient(135deg, #ebf8ff 0%, #bee3f8 100%);
    color: #2b6cb0;
    padding: 2px 12px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
  }

  .description-list {
    margin: 0;
    padding-left: 20px;
    font-size: 14px;
    line-height: 1.6;
    color: #4a5568;
  }

  .description-list li {
    margin-bottom: 5px;
  }

  .map-btn {
    display: block;
    text-align: center;
    background: #4285F4;
    color: white !important;
    text-decoration: none;
    padding: 12px;
    border-radius: 10px;
    margin-top: 20px;
    font-weight: 700;
    transition: 0.3s;
  }

  .map-btn:hover {
    background: #3367d6;
  }

  /* Back Button */
  .back-btn {
    position: fixed;
    bottom: 30px;  /* နည်းနည်းနီးအောင် */
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

  @media (max-width: 768px) {
    .container {
      flex-direction: column;
      align-items: center;
      margin-bottom: 90px; /* mobile မှာ spacing */
    }
  }

</style>
</head>

<body>

<h1 class="title">ပုသိမ်မြို့ပြဈေးများ</h1>

<div class="container">

  <div class="card">
    <div class="img-box"><img src="market1.jpg" alt="Main Market"></div>
    <div class="card-content">
      <h2>ဈေးကြီး</h2>
      <div class="info-group">
        <div class="info-item">
          <span class="tag">အချက်အလက်များ</span>
          <ul class="description-list">
            <li>အိမ်သုံးကုန်ပစ္စည်းနှင့် အဝတ်အထည်များ စုံလင်စွာရရှိနိုင်ခြင်း</li>
            <li>နံနက်ခင်းနှင့် ညနေပိုင်းတွင် အလွန်စည်ကားခြင်း</li>
            <li>ဒေသခံများ၏ နေ့စဉ်စားဝတ်နေရေးအတွက် အဓိကအားထားရခြင်း</li>
          </ul>
        </div>
      </div>
      <a href="https://www.google.com/maps/search/Pathein+Central+Market" target="_blank" class="map-btn"> Google Map တွင်ကြည့်မည်</a>
    </div>
  </div>

  <div class="card">
    <div class="img-box"><img src="market3.jpg" alt="Small Market"></div>
    <div class="card-content">
      <h2>ဈေးလေး</h2>
      <div class="info-group">
        <div class="info-item">
          <span class="tag">အချက်အလက်များ</span>
          <ul class="description-list">
            <li>လတ်ဆတ်သော မြစ်ငါးနှင့် ပုစွန်များကို အများဆုံးရရှိနိုင်ခြင်း</li>
            <li>ပုသိမ်မုန့်ဟင်းခါးနှင့် အကြော်စုံများ အရသာရှိစွာရရှိနိုင်ခြင်း</li>
            <li>လူနေရပ်ကွက်များနှင့်နီး၍ နံနက်ခင်းတွင် အမြဲစည်ကားခြင်း</li>
          </ul>
        </div>
      </div>
      <a href="https://www.google.com/maps/search/Pathein+Zay+Lay" target="_blank" class="map-btn">Google Map တွင်ကြည့်မည်</a>
    </div>
  </div>

  <div class="card">
    <div class="img-box"><img src="market2.jpg" alt="Station Market"></div>
    <div class="card-content">
      <h2>ဘူတာဈေး</h2>
      <div class="info-group">
        <div class="info-item">
          <span class="tag">အချက်အလက်များ</span>
          <ul class="description-list">
            <li>လတ်ဆတ်တဲ့ ငါး၊ ပုစွန်များကို ဈေးနှုန်းချိုသာစွာ ဝယ်ယူနိုင်ခြင်း</li>
            <li>ပုသိမ်ဟလာဝါနှင့် ဒေသထွက်မုန့်ပဲသရေစာများ စုံလင်ခြင်း</li>
            <li>နံနက် ၆ နာရီမှ ၉ နာရီအတွင်း အစည်ကားဆုံးဖြစ်ခြင်း</li>
            <li>ဘူတာကြီးအနီးတွင်ရှိ၍ သွားလာရလွယ်ကူခြင်း</li>
          </ul>
        </div>
      </div>
      <a href="https://www.google.com/maps/search/Pathein+Railway+Station+Market" target="_blank" class="map-btn"> Google Map တွင်ကြည့်မည်</a>
    </div>
  </div>

</div>

<!-- Back Button -->
<a href="javascript:history.back()" class="back-btn">← နောက်သို့</a>

</body>
</html>