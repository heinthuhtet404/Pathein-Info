<!DOCTYPE html>
<html lang="my">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>မြန်မာ့ဘုရားများ</title>

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:'Segoe UI',sans-serif;
background:linear-gradient(135deg,#e8e8e8 0%,#e5e5e6 100%);
min-height:100vh;
display:flex;
flex-direction:column;
align-items:center;
padding:40px 20px 100px;
}

/* Header */
.header{
text-align:center;
margin-bottom:40px;
}

.header h1{
color:#0552a4;
font-size:2.5rem;
font-weight:300;
letter-spacing:4px;
}

.header span{
display:block;
font-size:1rem;
color:#003bb0;
letter-spacing:6px;
margin-top:5px;
}

/* Back Button */
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
z-index:2000;
}

.back-btn:hover{
transform:translateY(-3px) scale(1.05);
}

/* Top Gallery (4 cards) */
.gallery{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:25px;
width:100%;
max-width:1200px;
margin-bottom:25px;
}

/* Bottom Gallery (3 cards center) */
.gallery-bottom{
display:flex;
justify-content:center;
gap:25px;
width:100%;
max-width:900px;
}

/* Card */
.card{
position:relative;
aspect-ratio:3/4;
border-radius:20px;
overflow:hidden;
text-decoration:none;
background:#000;
box-shadow:0 10px 20px rgba(0,0,0,0.4);
transition:.3s ease;
flex:1;
max-width:280px;
}

.card:hover{
transform:translateY(-8px);
box-shadow:0 15px 30px rgba(201,167,107,.3);
}

.card img{
width:100%;
height:100%;
object-fit:cover;
transition:.5s;
}

.card:hover img{
transform:scale(1.1);
}

/* Overlay */
.overlay{
position:absolute;
bottom:0;
left:0;
right:0;
padding:25px 20px 20px;
background:linear-gradient(to top,
rgba(0,0,0,.95),
rgba(0,0,0,.6),
transparent);
color:white;
text-align:center;
}

.burmese{
font-size:1.4rem;
font-weight:600;
}

/* Responsive */
@media(max-width:900px){
.gallery{
grid-template-columns:repeat(2,1fr);
}
.gallery-bottom{
flex-direction:column;
align-items:center;
}
}
</style>
</head>

<body>

<button class="back-btn" onclick="goBack()">⬅ နောက်သို့</button>

<div class="header">
<h1>
ပုသိမ်မြို့ရှိ အထင်ကရဘုရားများ
<span>PATHEIN PAGODAS</span>
</h1>
</div>

<!-- Top 4 Cards -->
<div class="gallery">

<a href="shwemote.php" class="card">
<img src="pp1.jpg">
<div class="overlay">
<div class="burmese">ရွှေမုဌောဘုရား</div>
</div>
</a>

<a href="shwesigon.php" class="card">
<img src="ss1.jpg">
<div class="overlay">
<div class="burmese">ရွှေစည်းခုံဘုရား</div>
</div>
</a>

<a href="nipagoda.php" class="card">
<img src="n3.jpg">
<div class="overlay">
<div class="burmese">နှီးဘုရား</div>
</div>
</a>

<a href="settawyar.php" class="card">
<img src="s1.jpg">
<div class="overlay">
<div class="burmese">စက်တော်ရာဘုရား</div>
</div>
</a>

</div>

<!-- Bottom 3 Cards (Center) -->
<div class="gallery-bottom">

<a href="takg.php" class="card">
<img src="t3.jpg">
<div class="overlay">
<div class="burmese">တဂေါင်းဘုရား</div>
</div>
</a>

<a href="yakyi.php" class="card">
<img src="y1.jpg">
<div class="overlay">
<div class="burmese">လေးကျွန်းရန်အောင်ဖောင်တော်ဦးစေတီတော်</div>
</div>
</a>

<a href="SMT.php" class="card">
<img src="smt1.jpg">
<div class="overlay">
<div class="burmese">ရွှေမြင်တင်ဘုရား</div>
</div>
</a>

</div>

<script>
function goBack(){
window.history.back();
}
</script>

</body>
</html>