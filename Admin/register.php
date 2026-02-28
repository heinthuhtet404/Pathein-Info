<?php
include("db.php");

if (isset($_POST['submit'])) {

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $address  = trim($_POST['address']);
    $idCard   = trim($_POST['idCard']);
    $business_name = trim($_POST['business_name']);

    $role_id = 1;
    $password = "Password12345@";
    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : NULL;

    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($idCard) || empty($business_name)) {
        echo "<script>alert('အချက်အလက်များကိုဖြည့်သွင်းပါ။');</script>";
    }

    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    }

    else if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/', $password)) {
        echo "<script>alert('Password must be strong (8 chars, upper, lower, number)');</script>";
    }

    else {

        $email = mysqli_real_escape_string($db, $email);
        $business_name = mysqli_real_escape_string($db, $business_name);

        $check = mysqli_query($db, "SELECT user_id FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            echo "<script>alert('Email already exists');</script>";
        }
        else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $category_value = ($category_id === NULL) ? "NULL" : $category_id;

            $uploadDir = "uploads/";
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $photoName = "";
            if (!empty($_FILES['photo']['name'])) {
                $photoName = time() . "_" . $_FILES['photo']['name'];
                move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $photoName);
            }

            $licenceName = "";
            if (!empty($_FILES['Licence']['name'])) {
                $licenceName = time() . "_lic_" . $_FILES['Licence']['name'];
                move_uploaded_file($_FILES['Licence']['tmp_name'], $uploadDir . $licenceName);
            }

            $query = "INSERT INTO users 
            (name, email, photo, phone, address, idCard, licence, business_name, password, role_id, category_id, status, is_registered, created_at)
            VALUES 
            ('$name', '$email', '$photoName', '$phone', '$address', '$idCard', '$licenceName', '$business_name',
             '$hashedPassword', $role_id, $category_value, 'Pending', 0, NOW())";

            if (mysqli_query($db, $query)) {
                echo "<script>
                        alert('အောင်မြင်ပါသည်။');
                        window.location.href='login.php';
                      </script>";
            } else {
                echo "<script>alert('မအောင်မြင်ပါ။');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Registration</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    
                    <div class="card-header text-center fw-bold text-primary">
                        <h3>မှတ်ပုံတင်ရန်</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label class="form-label">အမည် *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ဓါတ်ပုံ *</label>
                                <input type="file" name="photo" class="form-control" required>
                            </div>

                            <div class="mb-3">
    <label class="form-label">ဖုန်းနံပါတ် *</label>
    <input type="text" name="phone" class="form-control" required>
</div>

                            <div class="mb-3">
                                <label class="form-label">လိပ်စာ</label>
                                <input type="text" name="address" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">မှတ်ပုံတင်နံပါတ်</label>
                                <input type="text" name="idCard" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">လုပ်ငန်းအမည် *</label>
                                <input type="text" name="business_name" class="form-control" required>
                            </div>

                            <!-- Category Dropdown -->
                            <div class="mb-3">
                                <label class="form-label">လုပ်ငန်းအမျိုးအစား *</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- လုပ်ငန်းအမျိုးအစား --</option>
                                    <option value="1">ကျောင်း</option>
                                    <option value="2">ဆေးရုံ</option>
                                    <option value="3">ကားလိုင်း</option>
                                    <option value="4">ဟိုတယ်</option>
                                    <option value="5">ထုတ်ကုန်</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">လိုင်စင်အထောက်အထားပုံ *</label>
                                <input type="file" name="Licence" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    စာရင်းသွင်းရန်
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
</html>