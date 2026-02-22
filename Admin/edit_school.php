 <?php include('adminHeader.php');?>

 <body>
     <?php include('SideBarUpd.php');?>



     <!-- Beginning Content -->

     <?php
include 'db.php';


// if (!isset($_SESSION['email'])) {
//     header("Location: AdminDashboardUp.php");
//     exit;
// }
 
$name=$_SESSION['schoolName'];
echo $name;

// 1️⃣ Old Data Fetch
$result = mysqli_query($db, "SELECT * FROM schools WHERE name='$name'");
$row = mysqli_fetch_assoc($result);

// 2️⃣ Update Process
if (isset($_POST['update'])) {

    $name  = mysqli_real_escape_string($db, $_POST['name']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);

    $address = $_POST['address'];

$total_teachers = $_POST['total_teachers'];
$description = $_POST['description'];

    $update = mysqli_query($db,
        "UPDATE schools SET phone='$phone',address='$address', description='$description',total_teachers='$total_teachers'  WHERE name='$name'" );



    if ($update) {
        $_SESSION['name'] = $name; // session update
        $success = "Profile updated successfully!";
    } else {
        $error = "Update failed!";
    }
}
?>

     <body>

         <div class="container mt-5">
             <h3>Update School</h3>
             <hr>

             <?php if (!empty($success)) { ?>
             <div class="alert alert-success"><?= $success ?></div>
             <?php } ?>

             <?php if (!empty($error)) { ?>
             <div class="alert alert-danger"><?= $error ?></div>
             <?php } ?>

             <form method="post">

                 <div class="mb-3">
                     <label>Name</label>
                     <input type="text" name="name" value="<?= htmlspecialchars($row['name']); ?>" class="form-control"
                         required>
                 </div>

                 <div class="mb-3">
                     <label>Address</label>
                     <textarea name="address" class="form-control"></textarea>
                 </div>

                 <div class="mb-3">
                     <label>Phone</label>
                     <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']); ?>"
                         class="form-control">
                 </div>
                 <div class="col-md-6 mb-3">
                     <label>Total Teachers</label>
                     <input type="number" name="total_teachers" class="form-control" value="0">
                 </div>
                 <div class="mb-3">
                     <label>Description</label>
                     <textarea name="description" class="form-control"></textarea>
                 </div>
                 <button type="submit" name="update" class="btn btn-primary">
                     Update
                 </button>

                 <a href="dashboard.php" class="btn btn-secondary">
                     Back
                 </a>

             </form>
         </div>



         <!-- End Content -->
         </div>

         </div>

         <!-- Bootstrap JS -->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

         <script>
         function toggleSidebar() {
             document.getElementById('sidebar').classList.toggle('collapsed');
         }
         </script>

     </body>

     </html>