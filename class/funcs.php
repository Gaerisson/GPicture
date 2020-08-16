<?php

include_once("secret_auth_flickr.php");
include_once('settings.php');

function Flickr_get($meth,$param){
        global $flickr_API;

        if(is_array($param)){
            $param_str="&";
            $i=0;
            foreach($param as $key => $val){
                $i++;
                $param_str.=$key."=".$val;
                if($i<count($param)){
                    $param_str.="&";
                }
            }
        }else{
            $param_str="";
        }

        return 'https://api.flickr.com/services/rest/?method='.$meth.'&api_key='.$flickr_API.'&format=json&nojsoncallback=1&text=cats&extras=url_o'.$param_str;
}

function GetPicInf($pid){

    $flickr_api_p_req=@file_get_contents(Flickr_get('flickr.photos.getInfo',array('photo_id' => $pid)));
    $flickr_api_p_json=json_decode($flickr_api_p_req,true);
    $flickr_api_p_json=$flickr_api_p_json['photo'];

    $p_date=array("date_posted"=>$flickr_api_p_json['dates']['posted'],"date_taken"=>strtotime($flickr_api_p_json['dates']['taken']));
    $p_owner=array("username"=>$flickr_api_p_json['owner']['username'],"realname"=>$flickr_api_p_json['owner']['realname'],"location"=>$flickr_api_p_json['owner']['location'],"path_alias"=>$flickr_api_p_json['owner']['path_alias']);
    $p_views=$flickr_api_p_json['views'];
    $p_tags=$p_views=$flickr_api_p_json['tags']['tag'];

    $result=array(
        'date'=>$p_date,
        'owner'=>$p_owner,
        'views'=>$p_views,
        'tags'=>$p_tags,
    );

    return $result;

}

function GetExif($pid){

    $flickr_api_p_req=@file_get_contents(Flickr_get('flickr.photos.getExif',array('photo_id' => $pid)));
    $flickr_api_p_json=json_decode($flickr_api_p_req,true);
    $flickr_api_p_json=$flickr_api_p_json['photo'];
    
    $exif_arr=array();
    foreach($flickr_api_p_json['exif'] as $key => $val){
        foreach($val as $key2 => $val2){
            if($key2 == "label"){
                $exif_arr[$val2]=$val['raw']['_content'];
            }
            
        }
    }

    return array(
        'camera' => $flickr_api_p_json['camera'],
        'exif' => $exif_arr,
    );

}

function build_post_fields( $data,$existingKeys='',&$returnArray=[]){
    if(($data instanceof CURLFile) or !(is_array($data) or is_object($data))){
        $returnArray[$existingKeys]=$data;
        return $returnArray;
    }
    else{
        foreach ($data as $key => $item) {
            build_post_fields($item,$existingKeys?$existingKeys."[$key]":$key,$returnArray);
        }
        return $returnArray;
    }
}

function ReturnError($code){
    // header('HTTP/1.1 '.$code.' Not Found');
    // $_GET['e'] = $code;
    include 'res/error/'.$code.'.php';
    exit();    
}

?>