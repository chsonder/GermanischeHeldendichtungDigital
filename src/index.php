<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Germanische Heldendichtung Digital</title>
    <base target="_self"/>
    <meta charset="UTF-8"/>
    <meta name="author" content="Christian Sonder"/>
    <meta name="description" content="Germanische Heldendichtung Digital"/>
    
    <!-- Icon in Browser-Tabs -->
    <link rel="icon" href="assets/svg/logo_farbe.svg" title="Verlagslogo Trilog-Verlag"/>

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="assets/css/0_general.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/1_small.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/2_medium.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/3_large.css"/>
</head>
<body id="seite">
<?php include_once 'templates/header.php';?>
<?php include_once 'templates/navigation.php';?>
<?php include_once 'templates/sidenavigation.php';?>

<main id="main" tabindex="-1">
<?php
include_once "templates/home.php";
#$seite = validatePage();
#include_once $seite;
?>
</main>

<?php include_once 'templates/aside.php';?>
<?php include_once 'templates/footer.php'; ?>

</body>
</html>
