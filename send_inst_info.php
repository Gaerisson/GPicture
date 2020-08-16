<?php

    // THIS METHOD IS REALLY BAD BUT, INSTAGRAM DON4T GIVE ME CHOICE ..
    // their api is not working on my server but it is working on my local machine so
    // my computer is sending every 5 min infos to the API (get_inst_info.php)

    require_once('class/funcs.php');

    /////////////////////////////////////// INSTAGRAM API ///////////////////////////////////////
    $instagram_api_req=@file_get_contents("https://www.instagram.com/".$instagram_uid."/?__a=1");
    $instagram_api_json=json_decode($instagram_api_req,true);
    $instagram_api_json=$instagram_api_json['graphql'];
    ////////////////////////////////////////////////////////////////////////////////////////////////

    if(!isset($instagram_api_req) or empty($instagram_api_req)){
        print('Error, Instagram API not responding');
        exit;
    }

    // $inst_u_ext_url=$instagram_api_json['user']['external_url'];
    // $inst_u_ppic=$instagram_api_json['user']['profile_pic_url_hd'];
    // $inst_u_photos_count=$instagram_api_json['user']['edge_owner_to_timeline_media']['count'];
    $inst_u_photos=$instagram_api_json['user']['edge_owner_to_timeline_media']['edges'];

    $instagram_photos_arr=array();
    foreach($inst_u_photos as $key => $val){
        $inst_p_id=$val['node']['shortcode'];
        $inst_p_ref_url="https://www.instagram.com/p/".$inst_p_id."/";
        // $inst_p_url=$val['node']['display_url'];
        $inst_p_desc=$val['node']['edge_media_to_caption']['edges'][0]['node']['text'];
        preg_match('/GPicID:\s(\d+\/\d+\/\d+\s\d+:\d+:\d+)G(\w+)\.\w+/', $inst_p_desc, $GPic_ID);

        if($GPic_ID and !empty($GPic_ID)){
            $Hid=hash('sha1',strtotime($GPic_ID[1]).$GPic_ID[2]);
            $instagram_photos_arr[$Hid]=array('url'=>$inst_p_ref_url,'desc'=>$inst_p_desc);
        }
        
    }

    $inst_rep_json=array('data'=>$instagram_photos_arr);

    $ch = curl_init();

    $data = $instagram_photos_arr;

    curl_setopt($ch, CURLOPT_URL, 'http://URLTOYORWEBAPI/get_inst_info.php');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // requis à partir de PHP 5.6.0 
    curl_setopt($ch, CURLOPT_POSTFIELDS, build_post_fields($data));

    curl_exec($ch);


?>