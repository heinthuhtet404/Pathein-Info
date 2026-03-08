<?php
session_start();
session_destroy(); // Session အားလုံးကို ဖျက်ဆီးပစ်မည်
header("Location: clinics_categories.php"); // မူလစာမျက်နှာသို့ ပြန်ပို့မည်
exit();
?>