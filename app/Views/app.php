<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.2.1/angular-material.min.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    :root{
        --primary: #0277BD;
        --background: #e7ebf0;
    }
    body{
        font-family: 'Roboto', sans-serif;
        background-color: var(--background);
    }
</style>

<?php
    foreach($styles as $file => $sc) :
?>
    <link rel="stylesheet" href="<?= $sc;?>">
<?php
    endforeach;
?>

<?php
    foreach($scripts as $file => $sc) : 
        if($file == 'angular'):
?>
    <script src="<?= $sc;?>"></script>
<?php
        endif;
    endforeach;
?>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-aria.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-messages.min.js"></script>
    
    <!-- Angular Material Javascript now available via Google CDN; version 1.2.1 used here -->
    <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.2.1/angular-material.min.js"></script>


    <script>
        window.translations = <?= json_encode( $translations );?>
    </script>

</head>
<body>


<div ng-app="myApp" ng-cloak>
 

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