<?php
//include_once '../plugins/fpdf185/fpdf.php';
include_once './globalPath.php';
include_once '../vendor/autoload.php';

// Get the XML data from the POST request
$xmlData = $_POST['xmlData'];
$fileType = $_POST['type'];

// Load the XML string into a SimpleXMLElement object
$xml = new SimpleXMLElement($xmlData);
$xmlFileName = 'roles.xml';

// Create a new XML document
$newXml = new SimpleXMLElement('<Roles/>');

// Loop through each role element in the original XML and add it to the new XML
foreach ($xml->role as $role) {
    //add the outer parent tag
    $newRole = $newXml->addChild('role');

    //access  and get the  child tag inside the <role> tag from the xml string & 
    //add a child tag under role child tag with value 
    $newRole->addChild('id', (string) $role->id);
    $newRole->addChild('title', (string) $role->title);
}

// Save the new XML document to a file
$newXml->asXML($xmlFilePath . $xmlFileName);

////XPath
$pathXml = simplexml_load_file($xmlFilePath . $xmlFileName);
$awXml = new SimpleXMLElement("<roles/>");

$filename = "path" . 'xml';

//use x path to get values in certain range /
//use x path to get a value with certain elements /

$path = $pathXml->xpath("//role[id >= 1 and id <= 5]");
//$path = $pathXml->xpath("//role[title = 'Admin']");
//$path = $pathXml->xpath("//role[id = 5]");

foreach ($path as $p) {
    $pp = $awXml->addChild('role');

    $pp->addChild('id', (string) $p->id);
    $pp->addChild('title', (string) $p->title);
}

$awXml->asXML('path.xml');

//if the reqeust file type is csv
if ($fileType == 'csv') {
// Send a response indicating that the new XML file was generated successfully echo 'New XML file generated successfully!';
//load the newly created xml file
    $csvXml = simplexml_load_file($xmlFilePath . $xmlFileName);

// Generate a unique file name
    $csvFilename = 'roles.csv';

    $csvFile = fopen($csvFilePath . $csvFilename, 'w');
// Write the headers to the CSV file
    fputcsv($csvFile, array('Id', 'Title'));

    //the role here refer to the role tag in the xml string
    foreach ($csvXml->role as $role) {
        //based on the xml file child value
        $id = (string) $role->id;
        $title = (string) $role->title;

        fputcsv($csvFile, array($id, $title));
    }


    fclose($csvFile);

    echo $csvFilePath . $csvFilename;
    exit();
}

//if the request file type is pdf
//if ($fileType == 'pdf') {
//    $pdf = new FPDF();
//    $pdfXml = simplexml_load_file('../Files/Xml/' . $xmlFileName);
//
//    // Define the header data
//    $pdf->Header();
//    $pdf->AddPage();
//
//    // Set font to bold and background color
//    $pdf->SetFont('Arial', 'B', 12);
//
//    //set the heading text
//    $pdf->Cell(0, 10, 'Roles', 0);
//    $pdf->Ln();
//
//    //set the header column
//    $pdf->Cell(30, 10, 'Role ID', 1, 0, 'C');
//    $pdf->Cell(30, 10, 'Role Title', 1, 0, 'C');
//    $pdf->Ln();
//
//// Set the style of the cell value to normal
//    $pdf->SetFont('Arial', '', 12);
//
//    foreach ($pdfXml->role as $role) {
//        //based on xml file child value
//        $id = (string) $role->id;
//        $title = (string) $role->title;
//
//        //set the width, height, value & enable the border
//        //0 is the border style, 'C' is the alignment
//        $pdf->Cell(30, 10, $id, 1, 0, 'C');
//        $pdf->Cell(30, 10, $title, 1, 0, 'C');
//
//        //move to the new line
//        $pdf->Ln();
//    }
//
//    $pdfFileName = 'roles.pdf';
//
//    $pdf->Output($pdfFilePath . $pdfFileName, 'F');
//
//    echo $pdfFilePath . $pdfFileName;
//}

//if the requested file type is pdf
if ($fileType == 'pdf') {
    try {
        // Load XML file
        $pdfXml = new DOMDocument();
        $pdfXml->load($xmlFilePath . $xmlFileName);

        // Load XSL file
        $pdfXsl = new DOMDocument();
        $xslFileName = ('role.xsl');
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
        $pdfFileName = 'roles.pdf';

        // Save the PDF file
        $pdf->Output($pdfFilePath . $pdfFileName, 'F');

        echo $pdfFilePath . $pdfFileName;
    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo 'Error generating PDF: ' . $e->getMessage();
    }
}