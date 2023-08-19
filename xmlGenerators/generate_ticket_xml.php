<?php
include_once '../vendor/autoload.php';
include_once './globalPath.php';


$xmlData = $_POST['xmlData'];
$fileType = $_POST['type'];


$xml = new SimpleXMLElement($xmlData);
$xmlFileName = 'tickets.xml';


$ticketXml = new SimpleXMLElement("<Tickets/>");

foreach($xml->ticket as $ticket){
    $newTicket = $ticketXml->addChild('ticket');
    
    $newTicket->addChild('id', $ticket->id);
    $newTicket->addChild('code', $ticket->code);
    $newTicket->addChild('name', $ticket->name);
    $newTicket->addChild('status', $ticket->status);
}


$ticketXml->asXML($xmlFilePath . $xmlFileName);

if ($fileType == 'csv') {
// Send a response indicating that the new XML file was generated successfully echo 'New XML file generated successfully!';
//load the newly created xml file
    $csvXml = simplexml_load_file($xmlFilePath . $xmlFileName);

// Generate a unique file name
    $csvFilename = 'tickets.csv';

    $csvFile = fopen($csvFilePath . $csvFilename, 'w');
// Write the headers to the CSV file
    fputcsv($csvFile, array('Id', 'Ticket Code', 'Event Name', 'Status'));

    //the role here refer to the role tag in the xml string
    foreach ($csvXml->ticket as $ticket) {
        $id = (string) $ticket->id;
        $code = (string) $ticket->code;
        $name = (string) $ticket->name;
        $status = (string) $ticket->status;

        fputcsv($csvFile, array($id, $code, $name, $status));
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
        $xslFileName = ('ticket.xsl');
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
        $pdfFileName = 'ticket.pdf';

        // Save the PDF file
        $pdf->Output($pdfFilePath . $pdfFileName, 'F');

        echo $pdfFilePath . $pdfFileName;
    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo 'Error generating PDF: ' . $e->getMessage();
    }
}