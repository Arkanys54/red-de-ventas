<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class ConvertMdToDocx extends Command
{
    protected $signature = 'convert:md-to-docx';
    protected $description = 'Convierte INFORME_TECNICO_PLAN_DE_TRABAJO.md a DOCX';

    public function handle()
    {
        $this->info('Convirtiendo Markdown a DOCX...');

        try {
            $mdPath = base_path('Documentación/INFORME_TECNICO_PLAN_DE_TRABAJO.md');
            $docxPath = base_path('Documentación/INFORME_TECNICO_PLAN_DE_TRABAJO.docx');

            if (!file_exists($mdPath)) {
                $this->error('No se encontró el archivo MD');
                return Command::FAILURE;
            }

            $mdContent = file_get_contents($mdPath);
            $phpWord = new PhpWord();

            // Estilos
            $phpWord->addFontStyle('title', ['bold' => true, 'size' => 20]);
            $phpWord->addFontStyle('h1', ['bold' => true, 'size' => 16, 'color' => '00008B']);
            $phpWord->addFontStyle('h2', ['bold' => true, 'size' => 14, 'color' => '003366']);
            $phpWord->addFontStyle('bold', ['bold' => true]);
            $phpWord->addFontStyle('italic', ['italic' => true]);

            $phpWord->addParagraphStyle('center', ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 200]);
            $phpWord->addParagraphStyle('normal', ['spaceAfter' => 200]);

            $section = $phpWord->addSection();
            $lines = explode("\n", $mdContent);

            foreach ($lines as $line) {
                $line = trim($line);
                
                if (empty($line)) continue;
                
                if (preg_match('/^# (.+)$/', $line, $m)) {
                    $section->addText($m[1], 'title', 'center');
                }
                elseif (preg_match('/^## (.+)$/', $line, $m)) {
                    $section->addTextBreak(1);
                    $section->addText($m[1], 'h1');
                    $section->addTextBreak(1);
                }
                elseif (preg_match('/^### (.+)$/', $line, $m)) {
                    $section->addText($m[1], 'h2');
                    $section->addTextBreak(1);
                }
                elseif ($line === '---') {
                    $section->addTextBreak(1);
                }
                elseif (preg_match('/^[\-\*] (.+)$/', $line, $m)) {
                    $section->addListItem($m[1]);
                }
                elseif (preg_match('/^\d+\. (.+)$/', $line, $m)) {
                    $section->addListItem($m[1], 0, null, null, \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER);
                }
                elseif (preg_match('/^\*\*(.+?):\*\* (.+)$/', $line, $m)) {
                    $textRun = $section->addTextRun('normal');
                    $textRun->addText($m[1] . ': ', 'bold');
                    $textRun->addText($m[2]);
                }
                elseif (preg_match('/^\*\*(.+?)\*\*$/', $line, $m)) {
                    $section->addText($m[1], 'bold');
                }
                elseif (preg_match('/^\*(.+?)\*$/', $line, $m)) {
                    $section->addText($m[1], 'italic', 'center');
                }
                else {
                    if (strpos($line, '**') !== false) {
                        $parts = preg_split('/(\*\*[^*]+\*\*)/', $line, -1, PREG_SPLIT_DELIM_CAPTURE);
                        $textRun = $section->addTextRun('normal');
                        foreach ($parts as $part) {
                            if (preg_match('/^\*\*(.+?)\*\*$/', $part, $pm)) {
                                $textRun->addText($pm[1], 'bold');
                            } elseif (!empty($part)) {
                                $textRun->addText($part);
                            }
                        }
                    } else {
                        $section->addText($line, null, 'normal');
                    }
                }
            }

            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($docxPath);

            $this->info('✅ Documento generado: Documentación/INFORME_TECNICO_PLAN_DE_TRABAJO.docx');
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
