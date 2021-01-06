<?php


function generate_file($components, $name = false, $extension = "js"){
    $filename = ($name) ? $name : md5(rand(15361, 54486468));
    
    $output   = "";
    $component_file = FCPATH."/scripts/$filename.$extension";
    $public_url     = base_url("/scripts/$filename.$extension");
    
    if(!is_array($components)){
        $output = file_get_contents($components);
    }else{

        foreach($components as $c):
            $output .= file_get_contents($c)."\n";
        endforeach;
    }

        file_put_contents($component_file, $output);
    return $public_url;
}

function createRouterFile($routes){
    $data = "";
    ob_start();
        ?>

app.config(function($routeProvider) {
  $routeProvider
  <?php foreach($routes as $r):?>
  .when("<?= $r['path'];?>", {
    template : "<?= $r['template'];?>"
  })
  <?php endforeach;?>
});


        <?php

        $data = ob_get_contents();
    ob_end_clean();

    file_put_contents(ROOTPATH."stigniter/system/scripts/routes.js", $data);
    return ROOTPATH."stigniter/system/scripts/routes.js";
}