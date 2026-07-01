<?php

require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;

// Leer el archivo Markdown
$mdContent = file_get_contents('Documentación/INFORME_TECNICO_PLAN_DE_TRABAJO.md');

// Crear documento
$phpWord = new PhpWord();

// Configurar estilos
$phpWord->addFontStyle('titleStyle', ['bold' => true, 'size' => 20]);
$phpWord->addFontStyle('h1Style', ['bold' => true, 'size' => 16, 'color' => '00008B']);
$phpWord->addFontStyle('h2Style', ['bold' => true, 'size' => 14, 'color' => '003366']);
$phpWord->addFontStyle('h3Style', ['bold' => true, 'size' => 12]);
$phpWord->addFontStyle('boldStyle', ['bold' => true]);
$phpWord->addFontStyle('italicStyle', ['italic' => true]);

$phpWord->addParagraphStyle('centerPara', ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 200]);
$phpWord->addParagraphStyle('normalPara', ['spaceAfter' => 200]);

$section = $phpWord->addSection();

// Procesar el markdown línea por línea
$lines = explode("\n", $mdContent);
$inList = false;

foreach ($lines as $line) {
    $line = trim($line);
    
    if (empty($line)) {
        continue;
    }
    
    // Título principal (# )
    if (preg_match('/^# (.+)$/', $line, $matches)) {
        $section->addText($matches[1], 'titleStyle', 'centerPara');
    }
    // Heading 2 (## )
    elseif (preg_match('/^## (.+)$/', $line, $matches)) {
        $section->addTextBreak(1);
        $section->addText($matches[1], 'h1Style');
        $section->addTextBreak(1);
    }
    // Heading 3 (### )
    elseif (preg_match('/^### (.+)$/', $line, $matches)) {
        $section->addText($matches[1], 'h2Style');
        $section->addTextBreak(1);
    }
    // Línea horizontal (---)
    elseif ($line === '---') {
        $section->addTextBreak(1);
    }
    // Lista con viñetas (- )
    elseif (preg_match('/^[\-\*] (.+)$/', $line, $matches)) {
        $section->addListItem($matches[1]);
        $inList = true;
    }
    // Lista numerada
    elseif (preg_match('/^\d+\. (.+)$/', $line, $matches)) {
        $section->addListItem($matches[1], 0, null, null, \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER);
        $inList = true;
    }
    // Texto en negrita con : (**texto:**)
    elseif (preg_match('/^\*\*(.+?):\*\* (.+)$/', $line, $matches)) {
        if ($inList) {
            $section->addTextBreak(1);
            $inList = false;
        }
        $textRun = $section->addTextRun('normalPara');
        $textRun->addText($matches[1] . ': ', 'boldStyle');
        $textRun->addText($matches[2]);
    }
    // Texto en negrita (**texto**)
    elseif (preg_match('/^\*\*(.+?)\*\*$/', $line, $matches)) {
        if ($inList) {
            $section->addTextBreak(1);
            $inList = false;
        }
        $section->addText($matches[1], 'boldStyle');
    }
    // Texto en itálica (*texto*)
    elseif (preg_match('/^\*(.+?)\*$/', $line, $matches)) {
        $section->addText($matches[1], 'italicStyle', 'centerPara');
    }
    // Texto normal
    else {
        if ($inList) {
            $section->addTextBreak(1);
            $inList = false;
        }
        
        // Procesar negritas inline
        if (strpos($line, '**') !== false) {
            $parts = preg_split('/(\*\*[^*]+\*\*)/', $line, -1, PREG_SPLIT_DELIM_CAPTURE);
            $textRun = $section->addTextRun('normalPara');
            foreach ($parts as $part) {
                if (preg_match('/^\*\*(.+?)\*\*$/', $part, $m)) {
                    $textRun->addText($m[1], 'boldStyle');
                } else {
                    $textRun->addText($part);
                }
            }
        } else {
            $section->addText($line, null, 'normalPara');
        }
    }
}

// Guardar el documento
$outputPath = 'Documentación/INFORME_TECNICO_PLAN_DE_TRABAJO.docx';
$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($outputPath);

echo "✅ Documento convertido exitosamente: {$outputPath}\n";
