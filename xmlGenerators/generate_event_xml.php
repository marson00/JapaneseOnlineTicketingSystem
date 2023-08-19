<?php
include_once './globalPath.php';
include_once '../vendor/autoload.php';

// Get the XML data from the POST request
$xmlData = $_POST['xmlData'];
$fileType = $_POST['type'];

// Load the XML string into a SimpleXMLElement object
$xml = new SimpleXMLElement($xmlData);
$xmlFileName = 'events.xml';

// Create a new XML document
$newXml = new SimpleXMLElement('<Event/>');

// Loop through each event element in the original XML and add it to the new XML
foreach ($xml->event as $event) {
    $newEvent = $newXml->addChild('event');
    
    //access the child tag inside the <event> tag from the xml string
    $newEvent->addChild('id', (string) $event->id);
    $newEvent->addChild('name', (string) $event->name);
    $newEvent->addChild('image', (string) $event->image);
    $newEvent->addChild('capacity', (string) $event->capacity);
    $newEvent->addChild('quantityLeft', (string) $event->quantityLeft);
    $newEvent->addChild('price', (string) $event->price);
    $newEvent->addChild('startDate', (string) $event->startDate);
    $newEvent->addChild('endDate', (string) $event->endDate);
    $newEvent->addChild('category', (string) htmlentities($event->category));
    $newEvent->addChild('status', (string) $event->status);
}

// Save the new XML document to a file
$newXml->asXML($xmlFilePath . $xmlFileName);

if ($fileType == 'csv') {
// Send a response indicating that the new XML file was generated successfully echo 'New XML file generated successfully!';
//load the newly created xml file
    $csvXml = simplexml_load_file($xmlFilePath . $xmlFileName);

// Generate a unique file name
    $csvFilename = 'event.csv';

    $csvFile = fopen($csvFilePath . $csvFilename, 'w');
// Write the headers to the CSV file
    fputcsv($csvFile, array('Id', 'Event Name', 'Image', 'Capacity', 
        'Quantity Left', 'Price', 'Start Date', 'End Date', 'Category', 'Status'));

    //the role here refer to the role tag in the xml string
    foreach ($csvXml->event as $event) {
        $id = (string) $event->id;
        $name = (string) $event->name;
        $image = (string) $event->image;
        $capacity = (string) $event->capacity;
        $qtyLeft = (string) $event->quantityLeft;
        $price = (string) $event->price;
        $strtDate = (string) $event->startDate;
        $endDate = (string) $event->endDate;
        $category = (string) $event->category;
        $status = (string) $event->status;

        fputcsv($csvFile, array($id, $name, $image, $capacity, $qtyLeft, 
            $price, $strtDate, $endDate, $category, $status));
    }


    fclose($csvFile);

    echo $csvFilePath . $csvFilename;
    exit();
}

//if the file type is pdf
if ($fileType == 'pdf') {
    try {
        // Load XML file
        $pdfXml = new DOMDocument();
        $pdfXml->load($xmlFilePath . $xmlFileName);

        // Load XSL file
        $pdfXsl = new DOMDocument();
        $xslFileName = ('event.xsl');
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
        $pdfFileName = 'event.pdf';

        // Save the PDF file
        $pdf->Output($pdfFilePath . $pdfFileName, 'F');

        echo $pdfFilePath . $pdfFileName;
    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo 'Error generating PDF: ' . $e->getMessage();
    }
}