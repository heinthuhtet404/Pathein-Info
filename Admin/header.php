<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
    }

    .wrapper {
        display: flex;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar .nav-link {
        color: #ffffffcc;
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        transition: 0.3s;
    }

    .sidebar .nav-link i {
        width: 25px;
    }

    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
    }

    .sidebar .nav-link.active {
        background: #fff;
        color: #1971c2;
        font-weight: 600;
    }

    .menu-text {
        transition: 0.3s;
    }

    .sidebar.collapsed .menu-text {
        display: none;
    }

    .sub-link {
        padding-left: 40px !important;
    }

    .logout:hover {
        background: #ff4d4d !important;
    }


    .topbar {
        background: #fff;
    }


    .wrapper {
        display: flex;
    }

    /* Sidebar */
    .sidebar {
        width: 260px;
        height: 100vh;
        background: linear-gradient(180deg, #1c7ed6, #1971c2);
        position: fixed;
        left: 0;
        top: 0;
        transition: all 0.4s ease;
        z-index: 1000;
    }

    /* Hide Sidebar */
    .sidebar.hide {
        left: -260px;
    }

    #mainContent {
        max-width: 50px;
    }
    </style>

</head>

<body>