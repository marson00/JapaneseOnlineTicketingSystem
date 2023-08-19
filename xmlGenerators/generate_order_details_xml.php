<?php
include_once '../vendor/autoload.php';
include_once './globalPath.php';

// Get the XML data from the POST request
$xmlData = $_POST['xmlData'];
$fileType = $_POST['type'];

// Load the XML string into a SimpleXMLElement object
$xml = new SimpleXMLElement($xmlData);
$xmlFileName = 'orderDetail.xml';

// Create a new XML document
$newXml = new SimpleXMLElement('<OrderDetails/>');

// Loop through each role element in the original XML and add it to the new XML
foreach ($xml->orderDetail as $orderDetail) {
    //add the outer parent tag
    $newOrderDetail = $newXml->addChild('orderDetail');

    //access  and get the  child tag inside the <role> tag from the xml string & 
    //add a child tag under role child tag with value 
    $newOrderDetail->addChild('id', (string) $orderDetail->id);
    $newOrderDetail->addChild('order', (string) $orderDetail->order);
    $newOrderDetail->addChild('code', (string) $orderDetail->code);
}

// Save the new XML document to a file
$newXml->asXML($xmlFilePath . $xmlFileName);

//if the reqeust file type is csv
if ($fileType == 'csv') {
//load the created xml file
    $csvXml = simplexml_load_file($xmlFilePath . $xmlFileName);

// Generate a unique file name
    $csvFilename = 'orderDetail.csv';

    $csvFile = fopen($csvFilePath . $csvFilename, 'w');
// Write the headers to the CSV file
    fputcsv($csvFile, array('Order Detail Id', 'Order Id', 'Ticket Code'));

    //the role here refer to the role tag in the xml string
    foreach ($csvXml->orderDetail as $orderDetail) {
        $id = (string) $orderDetail->id;
        $order = (string) $orderDetail->order;
        $code = (string) $orderDetail->code;

        fputcsv($csvFile, array($id, $order, $code));
    }


    fclose($csvFile);

    echo $csvFilePath . $csvFilename;
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
        $xslFileName = ('orderDetail.xsl');
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
        $pdfFileName = 'orderDetail.pdf';

        // Save the PDF file
        $pdf->Output($pdfFilePath . $pdfFileName, 'F');

        echo $pdfFilePath . $pdfFileName;
    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo 'Error generating PDF: ' . $e->getMessage();
    }
}