<?php
include_once './globalPath.php';
include_once '../vendor/autoload.php';

// Get the XML data from the POST request
$xmlData = $_POST['xmlData'];
$fileType = $_POST['type'];

// Load the XML string into a SimpleXMLElement object
$xml = new SimpleXMLElement($xmlData);
$xmlFileName = 'card.xml';

// Create a new XML document
$newXml = new SimpleXMLElement('<Cards/>');

// Loop through each role element in the original XML and add it to the new XML
foreach ($xml->card as $card) {
    //add the outer parent tag
    $newCard = $newXml->addChild('card');

    //access  and get the  child tag inside the <role> tag from the xml string & 
    //add a child tag under role child tag with value 
    $newCard->addChild('id', (string) $card->id);
    $newCard->addChild('holder', (string) $card->holder);
    $newCard->addChild('cardNum', (string) $card->cardNum);
    $newCard->addChild('month',  $card->months);
    $newCard->addChild('year', (string) $card->years);
    $newCard->addChild('cvv', (string) $card->cvv);
    $newCard->addChild('type', (string) $card->type);
}

// Save the new XML document to a file
$newXml->asXML($xmlFilePath . $xmlFileName);

//if the reqeust file type is csv
if ($fileType == 'csv') {
//load the created xml file
    $csvXml = simplexml_load_file($xmlFilePath . $xmlFileName);

// Generate a unique file name
    $csvFilename = 'card.csv';

    $csvFile = fopen($csvFilePath . $csvFilename, 'w');
// Write the headers to the CSV file
    fputcsv($csvFile, array('Id', 'Card Holder', 'Card Number', 'Expired Month',
        'Expired Year', 'CVV Number', 'Card Type'));

    //the role here refer to the role tag in the xml string
    foreach ($csvXml->card as $card) {
        $id = (string) $card->id;
        $holder = (string) $card->holder;
        $cardNum = (string) $card->cardNum;
        $expMonth = (string) $card->month;
        $expYear = (string) $card->year;
        $cvv = (string) $card->cvv;
        $type = (string) $card->type;

        fputcsv($csvFile, array($id, $holder, $cardNum, $expMonth, $expYear, $cvv, $type));
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
        $xslFileName = ('card.xsl');
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
        $pdfFileName = 'card.pdf';

        // Save the PDF file
        $pdf->Output($pdfFilePath . $pdfFileName, 'F');

        echo $pdfFilePath . $pdfFileName;
    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo 'Error generating PDF: ' . $e->getMessage();
    }
}