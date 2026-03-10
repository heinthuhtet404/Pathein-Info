<?php
session_start();

// Logout လုပ်တော့မယ်ဆိုတဲ့ သတိပေးချက်နဲ့အတူ ပြသချင်ရင် ဒီဗားရှင်းကိုသုံးပါ
$show_confirm = isset($_GET['confirm']) ? $_GET['confirm'] : false;

if (!$show_confirm) {
    // confirmation page ကိုပြသမယ်
    ?>
    <!DOCTYPE html>
    <html lang="my">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ထွက်ခွာရန် - အတည်ပြုခြင်း</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
            
            body {
                background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                            url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=1920');
                background-size: cover;
                background-position: center;
                font-family: 'Pyidaungsu', sans-serif;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .logout-card {
                background: rgba(255,255,255,0.95);
                backdrop-filter: blur(10px);
                border-radius: 30px;
                padding: 40px;
                box-shadow: 0 20px 50px rgba(0,0,0,0.3);
                max-width: 450px;
                text-align: center;
            }
            
            .btn-confirm {
                background: #dc3545;
                color: white;
                border-radius: 50px;
                padding: 12px 30px;
                font-weight: bold;
                border: none;
                transition: 0.3s;
                text-decoration: none;
                display: inline-block;
                margin: 10px;
            }
            
            .btn-cancel {
                background: #6c757d;
                color: white;
                border-radius: 50px;
                padding: 12px 30px;
                font-weight: bold;
                border: none;
                transition: 0.3s;
                text-decoration: none;
                display: inline-block;
                margin: 10px;
            }
            
            .btn-confirm:hover, .btn-cancel:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            }
        </style>
    </head>
    <body>
        <div class="logout-card">
            <i class="fas fa-sign-out-alt fa-4x text-danger mb-4"></i>
            <h3 class="fw-bold mb-3">ထွက်ခွာရန် အတည်ပြုပါ</h3>
            <p class="text-muted mb-4">သင်သည် အကောင့်မှ ထွက်ခွာတော့မည် ဖြစ်ပါသည်။ ဆက်လက်ဆောင်ရွက်လိုပါသလား။</p>
            
            <div>
                <a href="buslogout.php?confirm=yes&redirect=<?php echo isset($_GET['redirect']) ? urlencode($_GET['redirect']) : 'bus_list.php?type=0'; ?>" class="btn-confirm">
                    <i class="fas fa-check-circle me-2"></i>အတည်ပြုမည်
                </a>
                <a href="<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : 'bus_list.php?type=0'; ?>" class="btn-cancel">
                    <i class="fas fa-times-circle me-2"></i>မလုပ်တော့ပါ
                </a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
} else {
    // Logout confirmation ရပြီဆိုရင် session ကိုဖျက်မယ်
    
    // အားလုံးသော session variable တွေကို ရှင်းလင်းခြင်း
    $_SESSION = array();
    
    // session cookie ကိုဖျက်ခြင်း
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // session ကိုဖျက်ခြင်း
    session_destroy();
    
    // Logout အောင်မြင်ကြောင်း သတင်းစကားပြီးမှ ပြန်ညွှန်းခြင်း
    ?>
    <!DOCTYPE html>
    <html lang="my">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ထွက်ခွာပြီးပါပြီ</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
            
            body {
                background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                            url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=1920');
                background-size: cover;
                background-position: center;
                font-family: 'Pyidaungsu', sans-serif;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .success-card {
                background: rgba(255,255,255,0.95);
                backdrop-filter: blur(10px);
                border-radius: 30px;
                padding: 40px;
                box-shadow: 0 20px 50px rgba(0,0,0,0.3);
                max-width: 450px;
                text-align: center;
            }
        </style>
        <meta http-equiv="refresh" content="2;url=<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : 'bus_list.php?type=0'; ?>">
    </head>
    <body>
        <div class="success-card">
            <i class="fas fa-check-circle fa-4x text-success mb-4"></i>
            <h3 class="fw-bold mb-3">အကောင့်မှ ထွက်ခွာပြီးပါပြီ</h3>
            <p class="text-muted">စက္ကန့်အနည်းငယ်အတွင်း ပင်မစာမျက်နှာသို့ ပြန်လည်ပို့ဆောင်ပေးပါမည်...</p>
        </div>
    </body>
    </html>
    <?php
    exit();
}
?>