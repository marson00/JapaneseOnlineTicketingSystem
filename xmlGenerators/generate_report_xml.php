<?php

include_once './globalPath.php';
include_once '../vendor/autoload.php';

$selected = $_POST['report'];

//top 5 most profit event
if ($selected == 1) {
    //for this part we get the total revenue and store it into a sales file
    $eventXml = simplexml_load_file($xmlFilePath . 'events.xml');

    //DONE GENERATING THE TOP SALES XML FILE 
    //LOAD XSL File
    $pdfXsl = new DOMDocument();
    $xslFileName = ("top_sales.xsl");
    $pdfXsl->load($xslFilePath . $xslFileName);

    //create XSLT PROCESSOR AND IMPORT THE STYLESHEET
    $processor = new XSLTProcessor();
    $processor->importStylesheet($pdfXsl);

    //transform the xml document 
    $html = $processor->transformToXml($eventXml);

    // Create a new PDF document
    $pdf = new \Mpdf\Mpdf();

    // Add a new page to the PDF
    $pdf->AddPage();

    // Output the HTML as a PDF
    $pdf->WriteHTML($html);

    // Generate a unique file name
    $pdfFileName = 'Top 5 Highest Revenue Event.pdf';

    // Save the PDF file
    $pdf->Output($pdfFilePath . $pdfFileName, 'F');

    echo $pdfFilePath . $pdfFileName;
}

//top 5 potential user
if ($selected == 2) {
    // Load orders and users XML files
    $orders = simplexml_load_file($xmlFilePath . 'orders.xml');
    
    //load xsl file
    $pdfXsl = new DOMDocument();
    $xslFileName = ("potential_user.xsl");
    $pdfXsl->load($xslFilePath . $xslFileName);

    //create processor and import the stylesheet
    $processor = new XSLTProcessor();
    $processor->importStylesheet($pdfXsl);

    //transform the xml document 
    $html = $processor->transformToXml($orders);

    // Create a new PDF document
    $pdf = new \Mpdf\Mpdf();

    // Add a new page to the PDF
    $pdf->AddPage();

    // Output the HTML as a PDF
    $pdf->WriteHTML($html);

    // Generate a unique file name
    $pdfFileName = 'Top 5 most potential user.pdf';

    // Save the PDF file
    $pdf->Output($pdfFilePath . $pdfFileName, 'F');

    echo $pdfFilePath . $pdfFileName;
}

//most profit category
if ($selected == 3) {
    $xml = simplexml_load_file($xmlFilePath . 'events.xml');

    //load xsl file
    $pdfXsl = new DOMDocument();
    $xslFileName = ("popular_category.xsl");
    $pdfXsl->load($xslFilePath . $xslFileName);

    //create processor and import the stylesheet
    $processor = new XSLTProcessor();
    $processor->importStylesheet($pdfXsl);

    //transform the xml document 
    $html = $processor->transformToXml($xml);

    // Create a new PDF document
    $pdf = new \Mpdf\Mpdf();

    // Add a new page to the PDF
    $pdf->AddPage();

    // Output the HTML as a PDF
    $pdf->WriteHTML($html);

    // Generate a unique file name
    $pdfFileName = 'Top 5 most profit category.pdf';

    // Save the PDF file
    $pdf->Output($pdfFilePath . $pdfFileName, 'F');

    echo $pdfFilePath . $pdfFileName;
}
