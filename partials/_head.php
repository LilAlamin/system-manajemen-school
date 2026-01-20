<?php
if (!isset($_SESSION)) {
    session_start();
}
// if (!isset($_SESSION['student_login']) || $_SESSION['student_login'] !== TRUE) {
//     if (!isset($_SESSION['teacher_login']) || $_SESSION['teacher_login'] !== TRUE) {
//         header('Location: index.php');
//         exit;
//     }
// }
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Google Fonts  -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">


    <!-- My Custom Files -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Sweet Alert  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">

    <!-- Google Ubuntu Font  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">

    <!-- Owl Files -->
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/owl.theme.green.css">
    <link rel="stylesheet" href="css/animate.css">

    <!-- Login CSS File  -->
    <link rel="stylesheet" href="css/login_style.css">

    <title><?= $title ?></title>
    
    <style>
        .main-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            text-align: center;
            background-color: #225470;
            color: white;
            width: 100vw
        }

        body {
            overflow-x: hidden;
        }

         /* Google Fonts */

        /* Google Font For heading */
        .my-heading {
            font-family: 'Baloo Paaji 2', cursive;
            font-family: 'Mulish', sans-serif;
            font-family: 'Roboto', sans-serif;
            text-align: center;
            font-size: 2rem;
            background: linear-gradient(45deg, #A0522D, #cf6c24);
            box-shadow: 3px 3px 6px #654321;

            color: #FFFFFF;
            padding: 10px;
            box-shadow: 2px 2px 5px #2F4F4F;
            transition: transform 0.3s ease-in-out;
        }

        .my-heading:hover {
            transform: scale(1.1);
            background-color: #0056b3;
        }


        @media (min-width: 768px) {

            body:not(.sidebar-mini-md) .content-wrapper,
            body:not(.sidebar-mini-md) .main-footer,
            body:not(.sidebar-mini-md) .main-header {
                transition: margin-left .3s ease-in-out;
                margin-left: 0px;
            }

            /* Style the table header */
            /* Add this CSS for borders on rows and columns */
            .my-table {
                /* border: 1px solid #dee2e6; */
                border-collapse: collapse;
                border-radius: 10px;
                width: 100%;
            }

            .my-table th,
            .my-table td {
                padding: 10px;
                text-align: center;
                border: 1px solid #dee2e6;
                /* Add borders to cells */
            }

            .my-table th {
                background-color: #225470;
                color: white;
                font-weight: bold;
            }

            /* Alternate Row Background Color */
            .my-table tbody tr:nth-child(odd) {
                background-color: #f2f2f2;
            }

            /* Hover Effect with Transition */
            .my-table tbody tr:hover {
                background-color: #dcdcdc;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            /* Optional: Style the table header cells */
            .my-table th {
                border-top: none;
            }

            /* Animation for hover effect on rows */
            .my-table tbody tr:hover td {
                transform: scale(1.05);
                transition: transform 0.2s ease;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
            }

            /* Add a transition for the box shadow */
            .my-table tbody tr td {
                transition: box-shadow 0.3s ease;
            }
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>