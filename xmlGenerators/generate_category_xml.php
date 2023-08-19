<?php
include_once './globalPath.php';
include_once '../vendor/autoload.php';

// Get the XML data from the POST request
$xmlData = $_POST['xmlData'];
$fileType = $_POST['type'];

// Load the XML string into a SimpleXMLElement object
$xml = new SimpleXMLElement($xmlData);
$xmlFileName = 'category.xml';

// Create a new XML document
$newXml = new SimpleXMLElement('<Category/>');

// Loop through each role element in the original XML and add it to the new XML
foreach ($xml->category as $category) {
    //add the child tag
    $newCategory = $newXml->addChild('category'); 
    
    
    $newCategory->addChild('id', (string) $category->id);
    $newCategory->addChild('title', (string) htmlentities($category->title));
}

// Save the new XML document to a file
$newXml->asXML($xmlFilePath . $xmlFileName);


//if the reqeust file type is csv
if ($fileType == 'csv') {
// Send a response indicating that the new XML file was generated successfully echo 'New XML file generated successfully!';
//load the newly created xml file
    $csvXml = simplexml_load_file($xmlFilePath . $xmlFileName);

// Generate a unique file name
    $csvFilename = 'category.csv';

    $csvFile = fopen($csvFilePath . $csvFilename, 'w');
// Write the headers to the CSV file
    fputcsv($csvFile, array('Id', 'Title'));

    foreach ($csvXml->category as $category) {
        $id = (string) $category->id;
        $title = (string) $category->title;

        fputcsv($csvFile, array($id, $title));
    }


    fclose($csvFile);

    echo $csvFilePath . $csvFilename;
    exit();
}


if ($fileType == 'pdf') {
    try {
        // Load XML file
        $pdfXml = new DOMDocument();
        $pdfXml->load($xmlFilePath . $xmlFileName);

        // Load XSL file
        $pdfXsl = new DOMDocument();
        $xslFileName = ('category.xsl');
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
        $pdfFileName = 'category.pdf';

        // Save the PDF file
        $pdf->Output($pdfFilePath . $pdfFileName, 'F');

        echo $pdfFilePath . $pdfFileName;
    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo 'Error generating PDF: ' . $e->getMessage();
    }
}