<!DOCTYPE html>
<html>
<head>
<?php
    foreach($scripts as $file => $sc) : 
        if($file == 'angular'):
?>
    <script src="<?= $sc;?>"></script>
<?php
        endif;
    endforeach;
?>


</head>
<body>


<div ng-app="myApp">
 

    <ng-view></ng-view>

</div>

<?php
    foreach($scripts as $file => $sc) : 
        if($file !== 'angular'):
?>
    <script src="<?= $sc;?>"></script>
<?php
        endif;
    endforeach;
?>


</body>
</html>