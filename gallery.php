<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Gallery - ဆေးရုံဓာတ်ပုံခန်းမ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; }
        
        .gallery-title {
            text-align: center;
            margin: 40px 0;
            color: #2c3e50;
            font-weight: bold;
        }

        /* Grid System */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .gallery-item {
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: #fff;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-10px); /* Mouse တင်ရင် အပေါ်နည်းနည်းကြွတက်မည် */
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover; /* ပုံတွေ အရွယ်အစားတူအောင် ညှိပေးသည် */
            display: block;
        }

        .img-caption {
            padding: 15px;
            text-align: center;
            font-size: 1.1rem;
            color: #555;
            background: #fff;
        }
    </style>
</head>
<body>

<div class="con">
    <h2 class="gallery-title">🏥 ဆေးရုံဓာတ်ပုံမှတ်တမ်းများ (Hospital Gallery)</h2>

    <div class="gallery-grid">
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=2053&auto=format&fit=crop" alt="Reception">
            <div class="img-caption">ဧည့်ကြိုဌာန (Reception)</div>
        </div>

        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?q=80&w=2070&auto=format&fit=crop" alt="Operating Room">
            <div class="img-caption">ခေတ်မီခွဲစိတ်ခန်း (Operating Room)</div>
        </div>

        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1586773860418-d37222d8fce3?q=80&w=2073&auto=format&fit=crop" alt="Laboratory">
            <div class="img-caption">ဓာတ်ခွဲခန်း (Laboratory)</div>
        </div>

        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=2080&auto=format&fit=crop" alt="Patient Room">
            <div class="img-caption">လူနာဆောင်များ (Patient Ward)</div>
        </div>

        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1581594634754-57acf448f2a9?q=80&w=2070&auto=format&fit=crop" alt="Medical Equipment">
            <div class="img-caption">ဆေးဘက်ဆိုင်ရာစက်ကိရိယာများ</div>
        </div>

        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1505751172876-fa1923c5c528?q=80&w=2070&auto=format&fit=crop" alt="Doctors">
            <div class="img-caption">ကျွမ်းကျင်ဆရာဝန်ကြီးများ</div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>