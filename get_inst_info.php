<?php

// file_put_contents('instagram_data.json',json_encode($_POST));

if(isset($_POST)){
    $instagram_photos_arr_base = json_decode(file_get_contents("instagram_data.json"),true);
    $instagram_photos_arr_new=$_POST;

    $instagram_photos_arr=array_merge($instagram_photos_arr_base, $instagram_photos_arr_new);
    file_put_contents('instagram_data.json',json_encode($instagram_photos_arr));
    print("OK");
}

?>