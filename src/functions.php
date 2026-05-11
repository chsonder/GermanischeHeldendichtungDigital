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
    $default = 'templates/home.php';
    $whitelist = require_once __DIR__ . '/whitelist.php';

    $page = strtolower($_GET['page']) ?? null;

    if (
        $page === null
        || !preg_match('/^[a-z0-9\-]+$/', $page)
        || !array_key_exists($page, $whitelist)
        || !is_file($whitelist[$page])
    ) {
        return $default;
    }

    return $whitelist[$page];
}

function formatBiblId(string $id): string
{
    $id = str_replace('_', ' ', $id);

    return mb_strtoupper(mb_substr($id, 0, 1, 'UTF-8'), 'UTF-8')
        . mb_substr($id, 1, null, 'UTF-8');
}

function transformXmlToPhp(
    string $xmlPath,
    string $xslPath,
    string $outputPath
): void {
    $xml = new DOMDocument();
    $xml->load($xmlPath);

    $xsl = new DOMDocument();
    $xsl->load($xslPath);

    $processor = new XSLTProcessor();
    $processor->registerPHPFunctions();
    $processor->importStylesheet($xsl);

    $result = $processor->transformToXML($xml);

    if ($result === false) {
        throw new RuntimeException(
            sprintf(
                'XSLT-Transformation fehlgeschlagen: %s',
                $xmlPath
            )
        );
    }

    $dir = dirname($outputPath);

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    file_put_contents($outputPath, $result);
}
