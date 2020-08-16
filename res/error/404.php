<?php
    require_once('class/funcs.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="57x57" href="res/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="res/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="res/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="res/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="res/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="res/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="res/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="res/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="res/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="res/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="res/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="res/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="res/favicon/favicon-16x16.png">
	<meta name="msapplication-TileImage" content="res/favicon/ms-icon-144x144.png">
	<link rel="shortcut icon" href="res/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/album.css" >
    <link rel="stylesheet" type="text/css" href="css/main.css">

    
    <script src="js/jquery-3.5.1.min.js" ></script>
    <script src="js/bootstrap.min.js" ></script>

    <title>GPicture - Error 404</title>  
    
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
</head>

<body style="background-color: rgb(100, 100, 100);">
    <div class="blur"></div>

    <?php require_once('res/top.php'); ?>

    <main role="main">

        <section style="margin-top: -100px;top: 50%;position: absolute;width: 100%;background-color:rgba(170, 29, 29, 0.77);" class="jumbotron text-center gpic_subbanner">
            <div class="container">
                <h1><span class="label label-important">ERROR 404</span></h1>
                <h3>An error occured, the picture was not found or the API is not responding !</h3>
            </div>
        </section>

    </main>

    <?php require_once('res/bottom.php'); ?>

</body>
</html>