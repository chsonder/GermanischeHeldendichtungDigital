<?php
require_once "constants.php";
require_once "functions.php";

clearDir(DIST);

copyDir(SRC . '/assets', DIST . '/assets');
copyDir(SRC . '/templates', DIST . '/templates');
copy(SRC . '/constants.php', DIST . '/constants.php');
copy(SRC . '/functions.php', DIST . '/functions.php');
copy(SRC . '/index.php', DIST . '/index.php');
