<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'/third_party/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 * Class phpspreadsheet
 */
class Phpspreadsheet {
    public function __construct()
    {

    }

    public function createXlSX($filename, $dataArray = array(), $title= 'Data', $printTitle = "Confidential Data"){
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
        //$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        //$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(12);
        //debug(range('A', $spreadsheet->getActiveSheet()->getHighestDataColumn())); die;
        foreach (range('A', 'H') as $col) {
            $spreadsheet->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }


        $spreadsheet->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A1:H1')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('A1:H1')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);

        //For Print
        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray( $dataArray, NULL, 'A1' );
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