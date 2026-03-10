<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Wave Design Example</title>
<style>
body {
  margin: 0;
  font-family: Arial, sans-serif;
  background: #f0f4f8;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.content {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 2rem;
  color: #333;
}

/* Wave container */
.wave-container {
  position: relative;
  width: 100%;
  height: 100px; /* Height of wave */
  overflow: hidden;
  line-height: 0;
}

/* Wave animation using SVG path */
.wave-container svg {
  position: absolute;
  bottom: 0;
  width: 200%;
  height: 100%;
  animation: wave 6s linear infinite;
  transform: translate3d(0,0,0);
}

@keyframes wave {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
</style>
</head>
<body>

<div class="content">Myanmar Pagodas Gallery</div>

<!-- Wave design -->
<div class="wave-container">
  <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
    <path d="M0,30 C150,80 350,0 600,30 C850,60 1050,20 1200,30 L1200,100 L0,100 Z" fill="#c7902e"></path>
  </svg>
</div>

</body>
</html>
