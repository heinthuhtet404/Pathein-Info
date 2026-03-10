<!DOCTYPE html>
<html lang="my">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>လုပ်ငန်းများ</title>

<style>

body{
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg,#6a11cb,#2575fc);
    margin:0;
    padding:40px;
}

.container{
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

.card{
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 15px rgba(0,0,0,0.2);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-10px);
}

.card img{
    width:100%;
    height:180px;
    object-fit:cover;
}

.card-content{
    padding:15px;
}

.card h3{
    margin:0 0 10px;
    color:#333;
}

.card p{
    font-size:14px;
    color:#666;
}

.btn{
    display:inline-block;
    margin-top:10px;
    padding:8px 15px;
    background:#2575fc;
    color:white;
    text-decoration:none;
    border-radius:6px;
}

.btn:hover{
    background:#0f4bd6;
}body{
    font-family: Arial, sans-serif;
    /* background: linear-gradient(135deg,#fff8f5,#fff1ea); */
    background:#FFFDF1;
    margin:0;
    padding:40px;

}
</style>
</head>

<body>

<h2 style="text-align:center;color:black;margin-bottom:30px;">
ပုသိမ်မြို့ရှိစက်ရုံလုပ်ငန်းများ
</h2>

<div class="container">

<!-- Card 1 -->
<div class="card">
<img src="clothing.jpg">
<div class="card-content">
<h3>အထည်ချုပ်လုပ်ငန်း</h3>
<a href="clothing.php" class="btn">ပိုမိုသိရှိရန်</a>
</div>
</div>

<!-- Card 2 -->
<div class="card">
<img src="aHtatThar.jpg">
<div class="card-content">
<h3>အထပ်သားလုပ်ငန်း</h3>
<a href="real.html" class="btn">ပိုမိုသိရှိရန်</a>
</div>
</div>

<!-- Card 3 -->
<div class="card">
<img src="mirror.jpg">
<div class="card-content">
<h3>မှန်စက်ရုံလုပ်ငန်း</h3>
<a href="mirror.php" class="btn">ပိုမိုသိရှိရန်</a>
</div>
</div>

<!-- Card 4 -->
<div class="card">
<img src="sanset.jpg">
<div class="card-content">
<h3>ဆီစက်လုပ်ငန်း</h3>
<a href="wm2.html" class="btn">ပိုမိုသိရှိရန်</a>
</div>
</div>



</div>

</body>
</html>