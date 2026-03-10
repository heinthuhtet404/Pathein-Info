<?php
$conn = new mysqli("localhost", "root", "", "pazza");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {

    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $size = $_POST['size'];
    
    if(isset($_POST['toppings'])){
        $toppings = implode(", ", $_POST['toppings']);
    } else {
        $toppings = "";
    }

    if ($first==""  $last==""  $address==""  $phone==""  $size=="") {
        echo "<script>alert('Required field');</script>";
    } else {

        $sql = "INSERT INTO orders(first_name,last_name,address,phone,size,toppings)
                VALUES('$first','$last','$address','$phone','$size','$toppings')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Insert Successful');</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>