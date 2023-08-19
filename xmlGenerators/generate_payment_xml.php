<?php
include_once '../vendor/autoload.php';
include_once './globalPath.php';

// Get the XML data from the POST request
$xmlData = $_POST['xmlData'];
$fileType = $_POST['type'];

// Load the XML string into a SimpleXMLElement object
$xml = new SimpleXMLElement($xmlData);
$xmlFileName = 'payment.xml';

// Create a new XML document
$newXml = new SimpleXMLElement('<Payment/>');

// Loop through each role element in the original XML and add it to the new XML
foreach ($xml->payment as $payment) {
    //add the outer parent tag
    $newPayment = $newXml->addChild('payment');

    //access  and get the  child tag inside the <role> tag from the xml string & 
    //add a child tag under role child tag with value 
    $newPayment->addChild('id', (string) $payment->id);
    $newPayment->addChild('date', (string) $payment->date);
    $newPayment->addChild('user', (string) $payment->user);
    $newPayment->addChild('card', (string) $payment->card);
}

// Save the new XML document to a file
$newXml->asXML($xmlFilePath . $xmlFileName);

//if the reqeust file type is csv
if ($fileType == 'csv') {
// Send a response indicating that the new XML file was generated successfully echo 'New XML file generated successfully!';
//load the newly created xml file
    $csvXml = simplexml_load_file($xmlFilePath . $xmlFileName);

// Generate a unique file name
    $csvFilename = 'payment.csv';

    $csvFile = fopen($csvFilePath . $csvFilename, 'w');
// Write the headers to the CSV file
    fputcsv($csvFile, array('Id', 'Payment Date', 'User', 'Card'));

    //the role here refer to the role tag in the xml string
    foreach ($csvXml->payment as $payment) {
        $id = (string) $payment->id;
        $date = (string) $payment->date;
        $user = (string) $payment->user;
        $card = (string) $payment->card;

        fputcsv($csvFile, array($id, $date, $user, $card));
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
        $xslFileName = ('payment.xsl');
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
        $pdfFileName = 'payment.pdf';

        // Save the PDF file
        $pdf->Output($pdfFilePath . $pdfFileName, 'F');

        echo $pdfFilePath . $pdfFileName;
    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo 'Error generating PDF: ' . $e->getMessage();
    }
}