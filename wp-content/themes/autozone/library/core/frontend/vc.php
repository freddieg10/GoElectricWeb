<?php

function autozone_vc_map($params,$cssAnimation = array(),$icons = false){
    $baseParams = $params['params'];
    if (!$icons){
        if (empty($cssAnimation)){
            $vcParams = $baseParams;
        }else{
            $vcParams = array_merge($baseParams,array($cssAnimation));
        }
    }else{
        $vcParams = array_merge($baseParams,$icons,array($cssAnimation));
    }
    $params['params'] = $vcParams;
    vc_map($params);
}

?>