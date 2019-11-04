<!DOCTYPE html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo Config::CSS_PATH; ?>main.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo Config::CSS_PATH; ?>forms.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo Config::CSS_PATH; ?>profile.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo Config::CSS_PATH; ?>chat.css?<?php echo time(); ?>">

    <title><?php echo $output->get_head_title(); ?> | Purrfect Partner</title>
  </head>
  <body class="d-flex flex-column h-100">

    <?php require_once('V_navigation.php') ?>

    <div class="container-fluid" id="<?php echo $output->get_page_name(); ?>">
