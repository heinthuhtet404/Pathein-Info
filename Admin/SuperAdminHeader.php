<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pathein Info Website</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
    body {
        overflow-x: hidden;
    }

    .sidebar {
        width: 280 px;
        min-height: 100vh;
        background: linear-gradient(180deg, #01060a, #484b4f);
        transition: all 0.3s;
    }

    .sidebar.collapsed {
        margin-left: -260px;
    }

    .sidebar .nav-link {
        color: #fff;
        border-radius: 10px;
        margin: 5px 10px;
    }

    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
    }

    .sidebar .nav-link.active {
        background: #fff;
        color: #17191b !important;
        font-weight: 600;
    }

    .sidebar .nav-link i {
        width: 20px;
    }

    .content {
        flex: 1;
        padding: 20px;
    }

    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            z-index: 1000;
        }

        /* Tablet */
        @media (min-width: 768px) and (max-width: 1023px) {
            .sidebar {
                position: relative;
            }
        }

        /* Desktop */
        @media (min-width: 1024px) {
            .sidebar {
                position: relative;
            }
        }


    }
    </style>
</head>