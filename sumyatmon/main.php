<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Image Cards</title>

<style>
body{
  margin:0;
  padding:40px;
  background:#e6e6e6;
  font-family: Arial, Helvetica, sans-serif;
  display:flex;
  justify-content:center;
}

.container{
  display:grid;
  grid-template-columns: repeat(3, 1fr);
  gap:30px;
}

/* remove link style */
.card-link{
  text-decoration:none;
}

/* Card */
.card{
  position:relative;
  width:300px;
  height:200px;
  border-radius:10px;
  overflow:hidden;
  perspective:1000px;
  box-shadow:0 0 0 5px #ffffff80;
  transition:0.6s;
  cursor:pointer;
}

.card img{
  width:100%;
  height:100%;
  object-fit:cover;
  transition:0.6s;
}

.card:hover{
  transform:scale(1.05);
}

.card__content{
  position:absolute;
  bottom:0;
  width:100%;
  background:rgba(0,0,0,0.7);
  color:white;
  padding:15px;
  transform:translateY(100%);
  transition:0.6s;
}

.card:hover .card__content{
  transform:translateY(0);
}

.card__title{
  margin:0;
  font-size:18px;
}

.card__description{
  margin:5px 0 0;
  font-size:14px;
}

/* Responsive */
@media(max-width:1000px){
  .container{
    grid-template-columns:repeat(2,1fr);
  }
}

@media(max-width:650px){
  .container{
    grid-template-columns:1fr;
  }
}
</style>
</head>

<body>

<div class="container">

  <a href="pagoda.php" class="card-link">
    <div class="card">
      <img src="pp1.jpg" alt="">
      <div class="card__content">
        <p class="card__title">ဘုရားသမိုင်းများ</p>
        <p class="card__description"></p>
      </div>
    </div>
  </a>

  <a href="rest.php" class="card-link">
    <div class="card">
      <img src="chaun4.jpg" alt="">
      <div class="card__content">
        <p class="card__title">ပင်လယ်ကမ်းခြေများ</p>
        <p class="card__description"></p>
      </div>
    </div>
  </a>

  <a href="market1.php" class="card-link">
    <div class="card">
      <img src="market1.jpg" alt="">
      <div class="card__content">
        <p class="card__title">မြို့ပြဈေးများ</p>
        <p class="card__description"></p>
      </div>
    </div>
  </a>

  <a href="rest1.php" class="card-link">
    <div class="card">
      <img src="hev.jpg" alt="">
      <div class="card__content">
        <p class="card__title">ပန်းခြံများ</p>
        <p class="card__description"></p>
      </div>
    </div>
  </a>

  <a href="cenima.php" class="card-link">
    <div class="card">
      <img src="cinema1.jpg" alt="">
      <div class="card__content">
        <p class="card__title">ရုပ်ရှင်ရုံများ</p>
        <p class="card__description"></p>
      </div>
    </div>
  </a>

  <a href="bridge.php" class="card-link">
    <div class="card">
      <img src="b2.jpg" alt="">
      <div class="card__content">
        <p class="card__title">တံတားများ</p>
        <p class="card__description"></p>
      </div>
    </div>
  </a>

  <a href="office.php" class="card-link">
    <div class="card">
      <img src="off2.jpg" alt="">
      <div class="card__content">
        <p class="card__title">ရုံးများ</p>
        <p class="card__description"></p>
      </div>
    </div>
  </a>

</div>

</body>
</html>
