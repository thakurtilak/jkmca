<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//include_once APPPATH.'/third_party/mpdf/mpdf.php';
require_once APPPATH . '/libraries/vendor/autoload.php';

class Imspdf {
    public $param;
    public $pdf;
    public function __construct($param = "'c', 'A4-L'")
    {
        $this->param =$param;
        $mpdf = new \Mpdf\Mpdf(['tempDir' => APPPATH . '/cache/temp']);
        //$this->pdf = new mPDF($this->param);
        $this->pdf = $mpdf;
    }
}