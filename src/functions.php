<?php

function clearDir(string $dirPath): void
{
    if (!is_dir($dirPath)) {
        return;
    }

    $files = glob(rtrim($dirPath, '/') . '/*', GLOB_MARK) ?: [];

    foreach ($files as $file) {
        if (is_dir($file) && !is_link($file)) {
            clearDir($file);
            rmdir($file);
        } else {
            unlink($file);
        }
    }
}

function copyDir(string $source, string $destination): void
{
    if (!is_dir($source)) {
        throw new InvalidArgumentException("Source does not exist: $source");
    }

    if (!is_dir($destination)) {
        mkdir($destination, 0755, true);
    }

    $items = scandir($source);

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $srcPath = $source . '/' . $item;
        $destPath = $destination . '/' . $item;

        if (is_dir($srcPath)) {
            copyDir($srcPath, $destPath);
        } else {
            copy($srcPath, $destPath);
        }
    }
}

function validatePage(): string
{
    $base = 'data';
    $default = 'templates/home.php';

    if (!isset($_GET['page'])) {
        return $default;
    }

    $page = $_GET['page'];

    // harte Validierung: nur erlaubte Zeichen
    if (!preg_match('/^[a-z0-9\-]+$/', $page)) {
        return $default;
    }

    $file = $base . '/' . $page . '.php';

    // nur Existenz prüfen, kein realpath
    if (is_file($file)) {
        return $file;
    }

    return $default;
}

function formatBiblId(string $id): string
{
    $id = str_replace('_', ' ', $id);

    return mb_strtoupper(mb_substr($id, 0, 1, 'UTF-8'), 'UTF-8')
        . mb_substr($id, 1, null, 'UTF-8');
}

function transformBibliographie(): void
{
    $xmlPath  = DATA . '/bibliographie.xml';
    $xslPath  = SRC . '/xslt/bibliographie.xsl';
    $output   = DIST . '/data/bibliographie.php';

    $xml = new DOMDocument();
    $xml->load($xmlPath);

    $xsl = new DOMDocument();
    $xsl->load($xslPath);

    $processor = new XSLTProcessor();
    $processor->registerPHPFunctions(['formatBiblId']);
    $processor->importStylesheet($xsl);

    $result = $processor->transformToXML($xml);

    if ($result === false) {
        throw new RuntimeException('XSLT-Transformation fehlgeschlagen');
    }

    $dir = dirname($output);

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    file_put_contents($output, $result);
}

function transformWerke(): void
{
    $xmlPath  = DATA . '/werke.xml';
    $xslPath  = SRC . '/xslt/werke.xsl';
    $output   = DIST . '/data/werke.php';

    $xml = new DOMDocument();
    $xml->load($xmlPath);

    $xsl = new DOMDocument();
    $xsl->load($xslPath);

    $processor = new XSLTProcessor();
    #$processor->registerPHPFunctions(['formatBiblId']);
    $processor->importStylesheet($xsl);

    $result = $processor->transformToXML($xml);

    if ($result === false) {
        throw new RuntimeException('XSLT-Transformation fehlgeschlagen');
    }

    $dir = dirname($output);

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    file_put_contents($output, $result);
}
