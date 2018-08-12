<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'/third_party/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 * Class phpspreadsheet
 */
class Phpspreadsheet {
    public $_rang = array(
        1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E',
        6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J',
        11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O',
        16 => 'P', 17 => 'Q',18 => 'R',19 => 'S',20 => 'T',
        21 => 'U',22 => 'V',24 => 'W',24 => 'X',25 => 'Y',
        26 => 'Z',
    );
    public function __construct()
    {

    }

    public function createXlSX($filename, $dataArray = array(), $title= 'Data', $printTitle = "Confidential Data"){
        $firstCol = 1;
        $lastCol  = 1;
        if(isset($dataArray[0])) {
            $lastCol = count($dataArray[0]);
        }
        $startCell = $this->_rang[$firstCol];
        $endCell = $this->_rang[$lastCol];
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("JKMCA")
            ->setTitle($printTitle);
        $spreadsheet->getActiveSheet()->setTitle($title);

        $spreadsheet->getActiveSheet()->getHeaderFooter()
            ->setOddHeader('&C&HJKM & ASSOCIATES CHARTERED ACCOUNTANTS');
        $spreadsheet->getActiveSheet()->getHeaderFooter()
            ->setOddFooter('&L&B' . $spreadsheet->getProperties()->getTitle() . '&RPage &P of &N');

        $styleArray = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ),
            'borders' => array(
                'top' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '7c7c7c'),
                ),
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '7c7c7c'),
                ),
            ),
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => array(
                    'argb' => 'FFA0A0A0',
                ),
                'endColor' => array(
                    'argb' => 'FFFFFFFF',
                ),
            )
        );

        foreach (range($startCell, $endCell) as $col) {
            $spreadsheet->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }

        $rowNumber = 1;
        $pCellCoordinate = $startCell.$rowNumber.':'.$endCell.$rowNumber;
        $spreadsheet->getActiveSheet()->getStyle($pCellCoordinate)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle($pCellCoordinate)
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle($pCellCoordinate)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(25);

        //For Print
        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray( $dataArray, NULL, $startCell.'1' );
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        try{
            $writer->save('php://output'); // download file
            //$this->saveViaTempFile($writer);
        } catch(Exception $e) {
            //echo $e->__toString();
        }
        die;
    }

    function saveViaTempFile($objWriter){
        $filePath = '' . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
        $fileFullPath = realpath(UPLOAD_ROOT_DIR) . DIRECTORY_SEPARATOR .$filePath;
        //echo $fileFullPath;die;
        $objWriter->save($fileFullPath);
        readfile($fileFullPath);
        unlink($fileFullPath);
        exit;
    }
}