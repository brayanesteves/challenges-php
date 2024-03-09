<!DOCTYPE html>
<html ng-app lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if(isset($this->title)) echo $this->title; ?></title>   
    <?php if(isset($_layoutParams['libscssjs']) && count($_layoutParams['libscssjs'])): ?>
    <?php for($i = 0; $i < count($_layoutParams['libscssjs']); $i++): ?>
    <?php if(pathinfo($_layoutParams['libscssjs'][$i], PATHINFO_EXTENSION) == "css"): ?>
    <link href="<?php echo $_layoutParams['libscssjs'][$i]; ?>" rel="stylesheet" type="text/css" extension="<?php echo pathinfo($_layoutParams['libscssjs'][$i], PATHINFO_EXTENSION); ?>" />
    <?php endif; ?>
    <?php endfor; ?>
    <?php endif; ?>
    <link href="<?php echo $_layoutParams['root_css'] . 'dist/styles.css'; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $_layoutParams['root_css'] . 'styles.css'; ?>" rel="stylesheet" type="text/css" />
    <?php if(isset($_layoutParams['css']) && count($_layoutParams['css'])): ?>
    <?php for($i = 0; $i < count($_layoutParams['css']); $i++): ?>
    <link href="<?php echo $_layoutParams['css'][$i]; ?>" rel="stylesheet" type="text/css" />
    <?php endfor; ?>
    <?php endif; ?>
</head>
<body> 
    <noscript>No function JavaScript browser</noscript> 
	