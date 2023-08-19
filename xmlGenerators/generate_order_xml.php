<?php
include_once'../vendor/autoload.php';
include_once './globalPath.php';

// Get the XML data from the POST request
$xmlData = $_POST['xmlData'];
$fileType = $_POST['type'];

// Load the XML string into a SimpleXMLElement object
$xml = new SimpleXMLElement($xmlData);
$xmlFileName = 'orders.xml';

// Create a new XML document
$newXml = new SimpleXMLElement('<Orders/>');

// Loop through each role element in the original XML and add it to the new XML
foreach ($xml->order as $order) {
    //add the outer parent tag
    $newOrder = $newXml->addChild('order');

    //access  and get the  child tag inside the <role> tag from the xml string & 
    //add a child tag under role child tag with value 
    $newOrder->addChild('id', (string) $order->id);
    $newOrder->addChild('event', (string) $order->event);
    $newOrder->addChild('quantity', (string) $order->quantity);
    $newOrder->addChild('price', (string) $order->price);
    $newOrder->addChild('user', (string) $order->user);
    $newOrder->addChild('date', (string) $order->date);
    $newOrder->addChild('card', (string) $order->card);
}

// Save the new XML document to a file
$newXml->asXML($xmlFilePath . $xmlFileName);

//if the reqeust file type is csv
if ($fileType == 'csv') {
// Send a response indicating that the new XML file was generated successfully echo 'New XML file generated successfully!';
//load the newly created xml file
    $csvXml = simplexml_load_file($xmlFilePath . $xmlFileName);

// Generate a unique file name
    $csvFilename = 'order.csv';

    $csvFile = fopen($csvFilePath . $csvFilename, 'w');
// Write the headers to the CSV file
    fputcsv($csvFile, array('Id', 'Event', 'Quantity', 'Total Price', 'User', 'Ordered Date', 'Card'));

    //the role here refer to the role tag in the xml string
    foreach ($csvXml->order as $order) {
        $id = (string) $order->id;
        $event = (string) $order->event;
        $quanity = (string) $order->quantity;
        $price = (string) $order->price;
        $user = (string) $order->user;
        $date = (string) $order->date;
        $card = (string) $order->card;

        fputcsv($csvFile, array($id, $event, $quanity, $price, $user, $date, $card));
    }


    fclose($csvFile);

    echo $csvFilePath . $csvFilename;
    exit();
}


//if the request file type is pdf
if ($fileType == 'pdf') {
    try {
        // Load XML file
        $pdfXml = new DOMDocument();
        $pdfXml->load($xmlFilePath . $xmlFileName);

        // Load XSL file
        $pdfXsl = new DOMDocument();
        $xslFileName = ('order.xsl');
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
        $pdfFileName = 'order.pdf';

        // Save the PDF file
        $pdf->Output($pdfFilePath . $pdfFileName, 'F');

        echo $pdfFilePath . $pdfFileName;
    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo 'Error generating PDF: ' . $e->getMessage();
    }
}