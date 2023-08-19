<?php
include_once '../vendor/autoload.php';
include_once './globalPath.php';

//XML
$xmlData = $_POST['xmlData'];
$fileType = $_POST['type'];

$xml = new SimpleXMLElement($xmlData);
$xmlFileName = "status.xml";

$newXml = new SimpleXMLElement('<Status/>');

foreach ($xml->status as $status){
    $newStatus = $newXml->addChild('status');
    
    $newStatus->addChild('id', (string) $status->id);
    $newStatus->addChild('title', (string) $status->title);
}

$newXml->asXML($xmlFilePath . $xmlFileName);

//CSV
if($fileType == 'csv'){
    $csvXml = simplexml_load_file($xmlFilePath . $xmlFileName);
    $csvFileName = "status.csv";
    
    $csvFile = fopen($csvFilePath . $csvFileName, 'w');
    
    fputcsv($csvFile, array('Id', 'Title'));
    
    foreach ($csvXml->status as $status){
        $id = (string) $status->id;
        $title = (string) $status->title;
        
        fputcsv($csvFile, array($id, $title));
    }
    
    fclose($csvFile);
    
    echo $csvFilePath . $csvFileName;
    exit();
}

//if the requested file type is pdf
if ($fileType == 'pdf') {
    try {
        // Load XML file
        $pdfXml = new DOMDocument();
        $pdfXml->load($xmlFilePath . $xmlFileName);

        // Load XSL file
        $pdfXsl = new DOMDocument();
        $xslFileName = ('status.xsl');
        $pdfXsl->load($xslFilePath . $xslFileName);

        // Create XSLT processor and import stylesheet
        $processor = new XSLTProcessor();
        $processor->importStylesheet($pdfXsl);

        // Transform XML document using XSLT
        $html = $processor->transformToXML($pdfXml);

        // Create a new PDF document
        $pdf = new \Mpdf\Mpdf();

        // Add a new page to the PDF
        $pdf->AddPage();

        // Output the HTML as a PDF
        $pdf->WriteHTML($html);

        // Generate a unique file name
        $pdfFileName = 'status.pdf';

        // Save the PDF file
        $pdf->Output($pdfFilePath . $pdfFileName, 'F');

        echo $pdfFilePath . $pdfFileName;
    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo 'Error generating PDF: ' . $e->getMessage();
    }
}