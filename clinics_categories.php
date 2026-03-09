<?php 
session_start();
$db = mysqli_connect("localhost", "root", "", "patheininfodb");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Post တင်ခြင်း Logic
if (isset($_POST['btn_post']) && isset($_SESSION['patient_name'])) {
    $user = mysqli_real_escape_string($db, $_SESSION['patient_name']);
    $content = mysqli_real_escape_string($db, $_POST['content']);
    if(!empty($user) && !empty($content)) {
        mysqli_query($db, "INSERT INTO posts (user_name, content) VALUES ('$user', '$content')");
        header("Location: clinics_categories.php"); exit();
    }
}

// Like ပေးခြင်း Logic
if (isset($_GET['like_id'])) {
    $p_id = (int)$_GET['like_id'];
    mysqli_query($db, "INSERT INTO post_likes (post_id) VALUES ('$p_id')");
    header("Location: clinics_categories.php"); exit();
}

// Comment ပေးခြင်း Logic
if (isset($_POST['btn_comment']) && isset($_SESSION['patient_name'])) {
    $p_id = (int)$_POST['post_id'];
    $c_user = mysqli_real_escape_string($db, $_SESSION['patient_name']);
    $c_text = mysqli_real_escape_string($db, $_POST['c_text']);
    if(!empty($c_user) && !empty($c_text)) {
        mysqli_query($db, "INSERT INTO post_comments (post_id, user_name, comment_text) VALUES ('$p_id', '$c_user', '$c_text')");
        header("Location: clinics_categories.php"); exit();
    }
}

// Post ဖျက်ခြင်း Logic
if (isset($_GET['delete_id'])) {
    $d_id = (int)$_GET['delete_id'];
    mysqli_query($db, "DELETE FROM posts WHERE id=$d_id");
    header("Location: clinics_categories.php"); exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare - Home & Community</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; font-family: 'Pyidaungsu', sans-serif; overflow-x: hidden; }
        
        /* Smooth Search Section with Gradient */
        .search-section { 
            background: linear-gradient(135deg, #0d6efd 0%, #004dc7 100%);
            padding: 80px 0 120px 0; color: white; 
            border-bottom-left-radius: 50px; border-bottom-right-radius: 50px;
        }

        /* Modern Category Card */
        .category-container {
            margin-top: -60px; background: white; padding: 40px;
            border-radius: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        }
        .category-card {
            border: 1px solid #f1f3f5; border-radius: 20px; background: white;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
            text-decoration: none; display: flex;
            flex-direction: column; align-items: center; justify-content: center;
            padding: 20px 10px; height: 130px; color: #444;
        }
        .category-card:hover { 
            transform: translateY(-10px); 
            border-color: #0d6efd; 
            box-shadow: 0 10px 20px rgba(13,110,253,0.1);
            color: #0d6efd; 
        }
        .category-card i { font-size: 2.2rem; margin-bottom: 12px; transition: 0.3s; }
        .category-card:hover i { transform: scale(1.1); }
        .category-name { font-weight: 600; font-size: 0.85rem; text-align: center; }

        /* Community & Post Styling */
        .community-section { max-width: 750px; margin: 40px auto; }
        .post-card { 
            border-radius: 20px; border: none; margin-bottom: 25px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); 
            transition: 0.3s;
        }
        .post-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        
        .avatar-circle { 
            width: 50px; height: 50px; background: linear-gradient(45deg, #0d6efd, #00d2ff); 
            color: white; border-radius: 50%; display: flex; 
            align-items: center; justify-content: center; font-weight: bold; font-size: 1.3rem; 
        }
        
        .comment-item { background: #f8f9fa; border-radius: 18px; padding: 12px 18px; margin-bottom: 10px; border: 1px solid #eee; }
        
        .btn-action { 
            color: #65676b; text-decoration: none; font-weight: 600; flex: 1; 
            text-align: center; padding: 10px; transition: 0.3s ease; border-radius: 10px;
        }
        .btn-action:hover { background: #f0f7ff; color: #0d6efd; }
        
        /* Custom Input */
        .rounded-pill-custom { border-radius: 25px !important; }
        .bg-light-custom { background-color: #f0f2f5 !important; }
    </style>
</head>
<body>

    <div class="search-section text-center">
        <div class="container" data-aos="fade-down">
            <h1 class="fw-bold mb-3">သင့်အတွက် အသင့်တော်ဆုံး</h1>
            <h4 class="mb-4 opacity-75">ဆေးခန်းနှင့် ကျန်းမာရေးဝန်ဆောင်မှုများ ရှာဖွေပါ</h4>
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <form action="searchbar_result.php" method="GET" class="d-flex bg-white p-2 rounded-pill shadow-lg">
                        <input type="text" name="search" class="form-control border-0 rounded-pill px-4" placeholder="အမည် သို့မဟုတ် မြို့နယ်ဖြင့် ရှာရန်...">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 ms-2 fw-bold">ရှာဖွေမည်</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="category-container mb-5" data-aos="zoom-in" data-aos-delay="200">
            <h5 class="text-center fw-bold mb-4">အမျိုးအစားအလိုက် ရှာဖွေရန်</h5>
            <div class="row g-4 justify-content-center">
                <?php
                $categories = [
                    ['id' => 'all', 'name' => 'အားလုံး', 'icon' => 'fas fa-th-large'],
                    ['id' => 'အထွေထွေ', 'name' => 'အထွေထွေရောဂါကု', 'icon' => 'fas fa-user-md'],
                    ['id' => 'သွားနှင့်ခံတွင်း', 'name' => 'သွားနှင့်ခံတွင်း', 'icon' => 'fas fa-tooth'],
                    ['id' => 'ကလေး', 'name' => 'ကလေးအထူးကု', 'icon' => 'fas fa-child'],
                    ['id' => 'အရေပြား', 'name' => 'အရေပြား', 'icon' => 'fas fa-hand-holding-medical'],
                    ['id' => 'မျက်စိ', 'name' => 'မျက်စိအထူးကု', 'icon' => 'fas fa-eye'],
                    ['id' => 'နှလုံး', 'name' => 'နှလုံးအထူးကု', 'icon' => 'fas fa-heartbeat'],
                    ['id' => 'အရိုး', 'name' => 'အရိုး၊ အကြော၊ အဆစ်', 'icon' => 'fas fa-bone']
                ];
                foreach ($categories as $index => $cat):
                ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2" data-aos="fade-up" data-aos-delay="<?php echo ($index * 50); ?>">
                    <a href="search_results.php?cat=<?php echo urlencode($cat['id']); ?>" class="category-card">
                        <i class="<?php echo $cat['icon']; ?>"></i>
                        <span class="category-name"><?php echo $cat['name']; ?></span>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="community-section">
            <h4 class="fw-bold mb-4" data-aos="fade-right"><i class="fas fa-users text-primary me-2"></i>ကျန်းမာရေး ဆွေးနွေးခန်း</h4>
            
            <div class="card post-card p-4 mb-4" data-aos="fade-up">
                <?php if(isset($_SESSION['patient_id'])): ?>
                    <form action="" method="POST">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary fw-bold">
                                <i class="fas fa-user-circle me-1"></i> <?php echo $_SESSION['patient_name']; ?> အဖြစ် ဆွေးနွေးပါ
                            </span>
                            <a href="patient_logout.php" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                <i class="fas fa-sign-out-alt"></i> ထွက်ရန်
                            </a>
                        </div>
                        <textarea name="content" class="form-control mb-3 border-0 bg-light-custom" rows="3" placeholder="ဘာများ ဆွေးနွေးချင်ပါသလဲ..." required style="border-radius: 20px;"></textarea>
                        <button type="submit" name="btn_post" class="btn btn-primary w-100 fw-bold rounded-pill py-2 shadow-sm">Post တင်မည်</button>
                    </form>
                <?php else: ?>
                    <div class="text-center py-3">
                        <div class="mb-3 text-muted"><i class="fas fa-lock fa-2x"></i></div>
                        <p class="fw-bold mb-3">ဆွေးနွေးမှုများ ပြုလုပ်ရန် အကောင့်ဝင်ပေးပါ</p>
                        <a href="patient_login.php" class="btn btn-primary px-5 rounded-pill fw-bold">
                           <i class="fas fa-sign-in-alt me-2"></i> Login ဝင်ပါ
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <?php
            $posts = mysqli_query($db, "SELECT * FROM posts ORDER BY id DESC");
            while($row = mysqli_fetch_assoc($posts)):
                $pid = $row['id'];
                $likes_res = mysqli_query($db, "SELECT COUNT(id) as total FROM post_likes WHERE post_id=$pid");
                $likes = mysqli_fetch_assoc($likes_res)['total'];
            ?>
            <div class="card post-card" data-aos="fade-up">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-circle me-3"><?php echo strtoupper(substr($row['user_name'], 0, 1)); ?></div>
                            <div>
                                <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($row['user_name']); ?></h6>
                                <small class="text-muted"><i class="far fa-clock me-1"></i><?php echo date('M j, Y - g:i A', strtotime($row['post_date'])); ?></small>
                            </div>
                        </div>
                        <a href="clinics_categories.php?delete_id=<?php echo $pid; ?>" class="btn btn-sm btn-light text-danger rounded-circle" onclick="return confirm('ဖျက်မှာ သေချာလား?')">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                    
                    <p class="card-text fs-6 px-1 mb-4" style="line-height: 1.6;"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    
                    <div class="d-flex justify-content-between text-muted small px-1 mb-2">
                        <span><i class="fas fa-heart text-danger"></i> <?php echo $likes; ?> Likes</span>
                        <span>
                            <i class="fas fa-comment-dots"></i> 
                            <?php 
                                $c_count = mysqli_query($db, "SELECT COUNT(id) as total FROM post_comments WHERE post_id=$pid");
                                echo mysqli_fetch_assoc($c_count)['total'];
                            ?> မှတ်ချက်များ
                        </span>
                    </div>
                    
                    <div class="border-top pt-2 d-flex">
                        <a href="clinics_categories.php?like_id=<?php echo $pid; ?>" class="btn-action"><i class="far fa-heart"></i> Like</a>
                        <div class="btn-action"><i class="far fa-comment-alt"></i> Comment</div>
                    </div>
                </div>

                <div class="bg-light p-4 border-top rounded-bottom">
                    <?php
                    $comments = mysqli_query($db, "SELECT * FROM post_comments WHERE post_id=$pid ORDER BY id ASC");
                    while($c_row = mysqli_fetch_assoc($comments)):
                    ?>
                        <div class="comment-item">
                            <b class="text-primary small d-block mb-1"><?php echo htmlspecialchars($c_row['user_name']); ?></b>
                            <span class="small text-dark"><?php echo htmlspecialchars($c_row['comment_text']); ?></span>
                        </div>
                    <?php endwhile; ?>

                    <?php if(isset($_SESSION['patient_id'])): ?>
                        <form action="" method="POST" class="mt-3 d-flex">
                            <input type="hidden" name="post_id" value="<?php echo $pid; ?>">
                            <input type="text" name="c_text" class="form-control rounded-pill px-3 border-0 bg-white shadow-sm" placeholder="မှတ်ချက်ပေးပါ..." required>
                            <button type="submit" name="btn_comment" class="btn btn-primary rounded-circle ms-2 px-3 shadow-sm"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    <?php else: ?>
                        <div class="text-center mt-2">
                            <a href="patient_login.php" class="text-primary small text-decoration-none fw-bold">မှတ်ချက်ပေးရန် Login ဝင်ပါ</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
<div style="position: fixed; bottom: 30px; left: 30px; z-index: 1000;">
        <a href="javascript:history.back()" class="btn btn-dark rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    </script>
</body>
</html>