<?php
require_once "constants.php";
require_once "functions.php";

clearDir(DIST);

copyDir(SRC . '/assets', DIST . '/assets');
copyDir(SRC . '/templates', DIST . '/templates');
copy(SRC . '/constants.php', DIST . '/constants.php');
copy(SRC . '/functions.php', DIST . '/functions.php');
copy(SRC . '/index.php', DIST . '/index.php');
copy(SRC . '/whitelist.php', DIST . '/whitelist.php');

transformXmlToPhp(
    DATA . '/werke.xml',
    SRC . '/xslt/werke.xsl',
    DIST . '/data/werke.php');
transformXmlToPhp(
    DATA . '/quellen.xml',
    SRC . '/xslt/quellen.xsl',
    DIST . '/data/quellen.php');
transformXmlToPhp(
    DATA . '/bibliographie.xml',
    SRC . '/xslt/bibliographie.xsl',
    DIST . '/data/bibliographie.php');
transformXmlToPhp(
    DATA . '/werke/hildebrandslied.xml',
    SRC . '/xslt/werk.xsl',
    DIST . '/data/werke/hildebrandslied.php');
