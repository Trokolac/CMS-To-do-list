<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To do list</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css" />
    <link rel="stylesheet" href="./CSS/style.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<body>

<?php include './navbar.inc.php'; ?>

<div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <?php require_once './Helper.class.php'; ?>

                <?php if(Helper::ifError()) { ?>
                <div class="alert alert-danger" style="text-align:center;">
                    <strong>Error!</strong> <?php echo Helper::getError(); ?>
                </div>
                <?php } ?>

                <?php if(Helper::ifMessage()) { ?>
                <div class="alert alert-success" style="text-align:center;">
                    <strong>Success!</strong> <?php echo Helper::getMessage(); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>