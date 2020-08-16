<?php
    require_once('class/funcs.php');
   
    /////////////////////////////////////// FLICKR API ///////////////////////////////////////
    $flickr_api_req=@file_get_contents(Flickr_get('flickr.people.getPublicPhotos',array('user_id' => $flickr_uid,'per_page'=>500)));
    $flickr_api_json=json_decode($flickr_api_req,true);

    if(!isset($flickr_api_req) or empty($flickr_api_req)){
        print('Error, Flickr API not responding');
        exit();
    }

    $flickr_nb_photos=$flickr_api_json['photos']['total'];
    ////////////////////////////////////////////////////////////////////////////////////////////////
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

    <link rel="stylesheet" href="css/progressive-image.css">
    <link rel="stylesheet" href="css/animate.css">

    
    <script src="js/jquery-3.5.1.min.js" ></script>
    <script src="js/bootstrap.min.js" ></script>
    <script src="js/main.js" ></script>

    <script src="js/progressive-image.js"></script>

    <title>GPicture - Browse</title>  
    
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
    <div class="followme animate__animated animate__slideInDown animate__delay-2s animate__faster">
        <h2>Follow me </h2>
        <?php if($instagram_uid): ?>
        <a target="_blank" href="https://www.instagram.com/<?php print($instagram_uid); ?>/"><img src="res/1024px-Instagram_icon.png"/></a>
        <?php endif; ?>
        <a target="_blank" href="https://flickr.com/photos/<?php print($flickr_username); ?>/"><img src="res/1200px-Flickr.svg.png"/></a>
    </div>
    <?php require_once('res/top.php'); ?>

    <main role="main">

        <section class="jumbotron text-center gpic_subbanner">
            <div class="container">
                <h1><?php print(ucfirst($flickr_username)); ?> Picture - Gallery</h1>
                <h3><span class="badge badge-primary"><span class="badge badge-light"><?php print($flickr_nb_photos); ?></span> pictures</span></h3>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <center>
                <div style="padding: 10px;margin: 0px 3%;">
                    <div class="row d-flex justify-content-center">
                        <?php
                            $i=0;
                            foreach($flickr_api_json['photos']['photo'] as $data){
                                $i++;
                                $linked_inst="";
                                $p_id=$data['id'];
                                $p_title=$data['title'];
                                preg_match('/(.*)\.[^.]+$|(?!\s)(.*)/', $p_title, $p_title_wh_ext);
                                if(isset($p_title_wh_ext[2])){
                                    $p_title_wh_ext=$p_title_wh_ext[2];
                                }else{
                                    $p_title_wh_ext=$p_title_wh_ext[1];
                                }

                                $p_thumbnail=str_replace('_o.jpg','_b.jpg',$data['url_o']);
                                $p_tiny=str_replace('_o.jpg','_m.jpg',$data['url_o']);
                                if($i<=1){
                                    $p_url=$p_thumbnail;
                                }
                                
                                print('
                                    <a style="height: 100%;">
                                        <div  class="col-md-auto" style="height: 100%;cursor:pointer;">
                                            <div class="card mb-4 shadow-sm gpic_img animate__animated animate__fadeInDown animate__delay-2s">
                                                <a href="pic?id='.$p_id.'" data-href="'.$p_thumbnail.'" class="progressive replace">
                                                    <img src="'.$p_tiny.'" class="card-img-top preview" alt="'.$p_title.'" />
                                                </a>
                                                <div class="card-body">
                                                    <center><h5 class="card-title">'.$p_title_wh_ext.'</h5></center>
                                                </div>
                                                '.$linked_inst.'
                                            </div>
                                        </div>
                                    </a>
                                ');
                                // break;
                            }

                            print('
                                <style>
                                    .blur {
                                        background-image: url(\''.$p_url.'\');
                                        background-size: cover;
                                    }
                                </style>
                            ');

                        ?>
                    </div>
                </div>
            </center>
        </div>

    </main>

    <?php require_once('res/bottom.php'); ?>

    <?php
         print('
            <meta property="og:site_name" content="GPic - Browse" >
            <meta property="og:title" content="'.ucfirst($flickr_username).' Picture - Gallery" />
            <meta property="og:image" content="'.$host_url.'res/logo_gpic.png" />
            
            <meta name="theme-color" content="#F19615" />
        ');
    ?>

</body>
</html>