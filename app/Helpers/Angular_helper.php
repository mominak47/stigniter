<?php


function generate_js_file($components, $name = false, $extension = "js"){
    $filename = ($name) ? $name : md5(rand(15361, 54486468));
    
    $output   = "";
    $component_file = FCPATH."/scripts/$filename.$extension";
    $public_url     = base_url("/scripts/$filename.$extension");
    
    if(!is_array($components)){
        $output = file_get_contents($components);
    }else{

        foreach($components as $c):
            $output .= file_get_contents($c);
        endforeach;

    }


    file_put_contents($component_file, $output);
    return $public_url;
}