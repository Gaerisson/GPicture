<?php
    require_once('class/funcs.php');

    if(!isset($_GET['id'])){
        print('No ID !');
        exit();
    }

    if(!empty($_GET['id'])){
        $p_id = $_GET['id'];
    }

    /////////////////////////////////////// FLICKR API ///////////////////////////////////////
    $flickr_api_req=@file_get_contents(Flickr_get('flickr.people.getPublicPhotos',array('user_id' => $flickr_uid,'per_page'=>500)));
    $flickr_api_json=json_decode($flickr_api_req,true);
    
    if(!isset($flickr_api_req) or empty($flickr_api_req)){
        print('Error, Flickr API not responding');
        exit;
    }
    
    $flickr_nb_photos=$flickr_api_json['photos']['total'];
    ////////////////////////////////////////////////////////////////////////////////////////////////

    // /////////////////////////////////////// INSTAGRAM API ///////////////////////////////////////
    // $instagram_api_req=@file_get_contents("https://www.instagram.com/".$instagram_uid."/?__a=1");
    // $instagram_api_json=json_decode($instagram_api_req,true);
    // $instagram_api_json=$instagram_api_json['graphql'];
    // ////////////////////////////////////////////////////////////////////////////////////////////////
    
    // if(!isset($instagram_api_req) or empty($instagram_api_req)){
    //     print('Error, Instagram API not responding');
    //     exit;
    // }

    // // $inst_u_ext_url=$instagram_api_json['user']['external_url'];
    // // $inst_u_ppic=$instagram_api_json['user']['profile_pic_url_hd'];
    // // $inst_u_photos_count=$instagram_api_json['user']['edge_owner_to_timeline_media']['count'];
    // $inst_u_photos=$instagram_api_json['user']['edge_owner_to_timeline_media']['edges'];

    // $instagram_photos_arr=array();
    // foreach($inst_u_photos as $key => $val){
    //     $inst_p_id=$val['node']['shortcode'];
    //     $inst_p_ref_url="https://www.instagram.com/p/".$inst_p_id."/";
    //     // $inst_p_url=$val['node']['display_url'];
    //     $inst_p_desc=$val['node']['edge_media_to_caption']['edges'][0]['node']['text'];
    //     preg_match('/GPicID:\s(\d+\/\d+\/\d+\s\d+:\d+:\d+)G(\w+)\.\w+/', $inst_p_desc, $GPic_ID);

    //     if($GPic_ID and !empty($GPic_ID)){
    //         $Hid=hash('sha1',strtotime($GPic_ID[1]).$GPic_ID[2]);
    //         $instagram_photos_arr[$Hid]=array('url'=>$inst_p_ref_url,'desc'=>$inst_p_desc);
    //     }
        
    // }
    
    if(file_exists('instagram_data.json')){
        $instagram_photos_arr=json_decode(file_get_contents('instagram_data.json'),true);
    }else{
        $instagram_photos_arr=array();
    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">

    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/album.css" >
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <link rel="stylesheet" href="css/image-zoom.css" />

    

    <link rel="stylesheet" href="css/animate.css">
    
    <script src="js/jquery-3.5.1.min.js" ></script>
    <script src="js/bootstrap.min.js" ></script>
    <script src="js/main.js" ></script>
    <script src="js/image-zoom.min.js"></script>

    <title>GPicture - View (<?php print($_GET['id']); ?>)</title>
    
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

        <!-- <div class="album py-5 bg-light">
            <div style="padding: 10px;margin: 0px 3%;">
                <div class="row"> -->
                    <?php
                        // print_r($flickr_api_json['photos']['photo']);
                        foreach($flickr_api_json['photos']['photo'] as $i => $data){
                            if($p_id==$data['id']){
                                $desc="";
                                $inst_url="";
                                $inst_url_t="";
                                $cust_size="";
                                $unknown_str="?";
                                $p_title=$data['title'];
                                preg_match('/(.*)\.[^.]+$|(?!\s)(.*)/', $p_title, $p_title_wh_ext);
                                if(isset($p_title_wh_ext[2])){
                                    $p_title_wh_ext=$p_title_wh_ext[2];
                                }else{
                                    $p_title_wh_ext=$p_title_wh_ext[1];
                                }

                                if(isset($flickr_api_json['photos']['photo'][$i-1])){
                                    $prev_img_uid=$flickr_api_json['photos']['photo'][$i-1];
                                    $prev_btn='
                                        <div class="prev_btn">
                                            <a href="pic?id='.$prev_img_uid['id'].'">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-left-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                                    <path fill-rule="evenodd" d="M10.205 12.456A.5.5 0 0 0 10.5 12V4a.5.5 0 0 0-.832-.374l-4.5 4a.5.5 0 0 0 0 .748l4.5 4a.5.5 0 0 0 .537.082z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    ';
                                }else{
                                    $prev_img_uid=-1;
                                    $prev_btn='';
                                }

                                if(isset($flickr_api_json['photos']['photo'][$i+1])){
                                    $next_img_uid=$flickr_api_json['photos']['photo'][$i+1];
                                    $next_btn='
                                        <div class="next_btn">
                                            <a href="pic?id='.$next_img_uid['id'].'">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-right-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                                    <path fill-rule="evenodd" d="M5.795 12.456A.5.5 0 0 1 5.5 12V4a.5.5 0 0 1 .832-.374l4.5 4a.5.5 0 0 1 0 .748l-4.5 4a.5.5 0 0 1-.537.082z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    ';
                                }else{
                                    $next_img_uid=-1;
                                    $next_btn='';
                                }

                                $p_url=$data['url_o'];
                                $p_url_back=str_replace('_o.jpg','_b.jpg',$p_url);

                                $p_width=$data['width_o'];
                                $p_height=$data['height_o'];
                                $p_size=$p_width."x".$p_height;

                                $Pic_Inf=(GetPicInf($p_id));
                                $Pic_Exif=(GetExif($p_id));

                                if(!isset($Pic_Exif['exif']['Flash'])){$Pic_Exif['exif']['Flash']=$unknown_str;}
                                if(!isset($Pic_Exif['exif']['Software'])){$Pic_Exif['exif']['Software']=$unknown_str;}
                                if(!isset($Pic_Exif['exif']['Exposure Program'])){$Pic_Exif['exif']['Exposure Program']=$unknown_str;}
                                if(!isset($Pic_Exif['exif']['Focal Length'])){$Pic_Exif['exif']['Focal Length']=$unknown_str;}
                                if(!isset($Pic_Exif['exif']['Aperture'])){$Pic_Exif['exif']['Aperture']=$unknown_str;}
                                if(!isset($Pic_Exif['exif']['ISO Speed'])){$Pic_Exif['exif']['ISO Speed']=$unknown_str;}
                                // if(!isset($Pic_Exif['exif']['Aperture'])){$Pic_Exif['exif']['Aperture']=$unknown_str;}

                                $Hid = hash('sha1',strtotime(date("d/m/Y H:i:s",$Pic_Inf['date']['date_taken'])).$p_title_wh_ext);
                                // print(date("d/m/Y H:i:s",$Pic_Inf['date']['date_taken']));
                                // print($Hid);
                                if(isset($instagram_photos_arr[$Hid])){
                                    $flickr_instagram_link=($instagram_photos_arr[$Hid]);
                                }else{
                                    $flickr_instagram_link=0;
                                }

                                if($flickr_instagram_link!==0){
                                    // print('Linked with Instagram <br>');
                                    // print_r($flickr_instagram_link);
                                    $desc="Description\n".$flickr_instagram_link['desc'];
                                    $inst_url_t="Insta: ".$flickr_instagram_link['url']."\n";
                                    $inst_url=$flickr_instagram_link['url'];
                                }
                               
                                if($Pic_Exif['exif']['Flash']=="Off, Did not fire"){
                                    $Flash="📷 Off";
                                }else{
                                    $Flash="📸 On";
                                }

                                if($p_height>2000 & $p_width<3300){
                                    $cust_size="width:26%;";
                                }

                                if($p_height<2000){
                                    $size_val_back="350%"; // pano h
                                }else{
                                    $size_val_back="cover";
                                }

                                $Soft=str_replace("Adobe Photoshop","",str_replace("(Windows)","",$Pic_Exif['exif']['Software']));
                                
                                //set Background
                                print('
                                <style>
                                    .blur{
                                        background-image: url(\''.$p_url_back.'\') !important;
                                        background-size: '.$size_val_back.';
                                    }
                                </style>
                                ');
                                
                                if($inst_url!=''){
                                    $Insta_Btn='<a target="_blank" href="'.$inst_url.'"><img src="res/1024px-Instagram_icon.png"/></a>';
                                }else{
                                    $Insta_Btn='';
                                }

                                print('
                                    <div class="main_img_view">
                                        
                                        <center style="display:inline-block;width: 100%;">
                                            '.$prev_btn.'
                                            <div class="img_view" style="'.$cust_size.'">
                                                <!--<img src="'.$p_url.'" width=100% height=100% alt="...">-->
                                                <img id="imageZoom" src="'.$p_url.'" />
                                            </div>
                                            '.$next_btn.'
                                        </center>
                                        

                                        <div class="exif_view animate__animated animate__fadeInRight animate__delay-1s animate__faster">
                                            <div class="exif_infos">
                                                <h2>- EXIF INFO -</h2>
                                                <p>
                                                <hr>
                                                <table border=0 style="width:100%;text-align:center;">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2">
                                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-camera2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M9 5C7.343 5 5 6.343 5 8a4 4 0 0 1 4-4v1z"/>
                                                                    <path fill-rule="evenodd" d="M14.333 3h-2.015A5.97 5.97 0 0 0 9 2a5.972 5.972 0 0 0-3.318 1H1.667C.747 3 0 3.746 0 4.667v6.666C0 12.253.746 13 1.667 13h4.015c.95.632 2.091 1 3.318 1a5.973 5.973 0 0 0 3.318-1h2.015c.92 0 1.667-.746 1.667-1.667V4.667C16 3.747 15.254 3 14.333 3zM1.5 5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zM9 13A5 5 0 1 0 9 3a5 5 0 0 0 0 10z"/>
                                                                    <path d="M2 3a1 1 0 0 1 1-1h1a1 1 0 0 1 0 2H3a1 1 0 0 1-1-1z"/>
                                                                </svg>
                                                                 '.$Pic_Exif['exif']['Model'].'
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                '.$Soft.'
                                                            </td>
                                                            <td>
                                                                '.$Pic_Exif['exif']['Exposure Program'].'
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                ⭕ ƒ/'.$Pic_Exif['exif']['Aperture'].'
                                                            </td>
                                                            <td>
                                                                👁 '.$Pic_Exif['exif']['Focal Length'].'
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                ⏱️ '.$Pic_Exif['exif']['Exposure'].'
                                                            </td>
                                                            <td>
                                                                ISO '.$Pic_Exif['exif']['ISO Speed'].'
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                '.$Flash.'
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <div class="open_link animate__animated animate__slideInDown animate__delay-2s animate__faster">
                                            <h3>Open on </h3>
                                            '.$Insta_Btn.'
                                            <a target="_blank" href="https://flickr.com/photos/'.$flickr_username.'/'.$p_id.'"><img src="res/1200px-Flickr.svg.png"/></a>
                                        </div>

                                        <center>
                                            <div class="pic_info_view">
                                                <div>
                                                    <h2>'.$p_title_wh_ext.'</h2>
                                                    <a target="_blank" href="https://flickr.com/photos/'.$flickr_username.'/'.$p_id.'">Open Flickr link</a>
                                                    <p>
                                                    <a target="_blank" href="'.$inst_url.'">Open Instagram link</a>
                                                    <p>
                                                    <hr>
                                                    Size: '.$p_size.'
                                                    <br>
                                                    '.nl2br($desc).'
                                                    
                                                </div>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                            </div>
                                        </center>
                                        
                                    </div>
                                ');
                            }
                        }
                    ?>
                <!-- </div>
            </div>
        </div> -->

    </main>

    <script>
        $(function(){
			$('#imageZoom').imageZoom({zoom : 200});
	    });
    </script>

    <?php require_once('res/bottom.php'); ?>

    <?php
        $str_content="📷 ".$Pic_Exif["exif"]["Model"]." (".$Soft.")\n &nbsp; ⭕ ƒ/".$Pic_Exif["exif"]["Aperture"]." - 👁 ".$Pic_Exif["exif"]["Focal Length"]."\n &nbsp; ⏱️ ".$Pic_Exif["exif"]["Exposure"]." - ISO ".$Pic_Exif["exif"]["ISO Speed"];

        print('
            <meta property="og:site_name" content="GPic - Viewer" >
            <meta property="og:title" content="'.$p_title_wh_ext.'" />
            <meta property="og:image" content="'.$p_url.'" />
            <meta property="og:description" content="'.$str_content."\n-----------------------------------------------\n".$desc.'" />
            
            <meta name="theme-color" content="#2572E5" />

            <!-- Include this to make the og:image larger -->
            <meta name="twitter:card" content="summary_large_image">

        ');

    ?>

</body>
</html>