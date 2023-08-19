<?php
include_once './globalPath.php';
include_once '../vendor/autoload.php';

// Get the XML data from the POST request
$xmlData = $_POST['xmlData'];
$fileType = $_POST['type'];

// Load the XML string into a SimpleXMLElement object
$xml = new SimpleXMLElement($xmlData);
$xmlFileName = 'user.xml';

// Create a new XML document
$newXml = new SimpleXMLElement('<Users/>');

// Loop through each role element in the original XML and add it to the new XML
foreach ($xml->user as $user) {
    //add the outer parent tag
    $newUser = $newXml->addChild('user');

    //access  and get the  child tag inside the <role> tag from the xml string & 
    //add a child tag under role child tag with value 
    $newUser->addChild('id', (string) $user->id);
    $newUser->addChild('name', (string) $user->name);
    $newUser->addChild('email', (string) $user->email);
    $newUser->addChild('phone', (string) $user->phone);
    $newUser->addChild('status', (string) $user->status);
    $newUser->addChild('role', (string) $user->role);
    $newUser->addChild('create', (string) $user->create);
    $newUser->addChild('update', (string) $user->update);
}

// Save the new XML document to a file
$newXml->asXML($xmlFilePath . $xmlFileName);

//if the reqeust file type is csv
if ($fileType == 'csv') {
// Send a response indicating that the new XML file was generated successfully echo 'New XML file generated successfully!';
//load the newly created xml file
    $csvXml = simplexml_load_file($xmlFilePath . $xmlFileName);

// Generate a unique file name
    $csvFilename = 'user.csv';

    $csvFile = fopen($csvFilePath . $csvFilename, 'w');
// Write the headers to the CSV file
    fputcsv($csvFile, array('Id', 'Username', 'Email', 'Phone',
        'Status', 'Role', 'Created By', 'Updated by'));

    //the role here refer to the role tag in the xml string
    foreach ($csvXml->user as $user) {
        //based on the xml file child value
        $id = (string) $user->id;
        $name = (string) $user->name;
        $email = (string) $user->email;
        $phone = (string) $user->phone;
        $status = (string) $user->status;
        $role = (string) $user->role;
        $create = (string) $user->create;
        $update = (string) $user->update;

        fputcsv($csvFile, array($id, $name, $email, $phone,
            $status, $role, $create, $update));
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
        $xslFileName = ('user.xsl');
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
        $pdfFileName = 'user.pdf';

        // Save the PDF file
        $pdf->Output($pdfFilePath . $pdfFileName, 'F');

        echo $pdfFilePath . $pdfFileName;
    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo 'Error generating PDF: ' . $e->getMessage();
    }
}
