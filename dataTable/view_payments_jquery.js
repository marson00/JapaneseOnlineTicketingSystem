$(document).ready(function () {
    $('#paymentsTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/JapaneseOnlineTicketingSystem/dataTable/payments_view.php'
        },
        'columns': [
            {data: 'paymentId'},
            {data: 'paymentDate'},
            {data: 'paymentUser'},
            {data: 'paymentCardNum'},
        ]
    });
});


//pass data & generate csv file
$('#csv').on('click', function () {
    //get the datatable value
    var tableData = $('#paymentsTable').DataTable().data().toArray();

    // Create an XML document
    var doc = document.implementation.createDocument(null, 'payments', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var paymentElem = doc.createElement('payment');
        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.paymentId);
        idElem.appendChild(idValue);
        paymentElem.appendChild(idElem);
        
        var dateElem = doc.createElement('date');
        var dateValue = doc.createTextNode(rowData.paymentDate);
        dateElem.appendChild(dateValue);
        paymentElem.appendChild(dateElem);
        
        var userElem = doc.createElement('user');
        var userValue = doc.createTextNode(rowData.paymentUser);
        userElem.appendChild(userValue);
        paymentElem.appendChild(userElem);
        
        var cardElem = doc.createElement('card');
        var cardValue = doc.createTextNode(rowData.paymentCardNum);
        cardElem.appendChild(cardValue);
        paymentElem.appendChild(cardElem);

        doc.documentElement.appendChild(paymentElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    // Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_payment_xml.php",
        data: {
            xmlData: xmlString,
            type: 'csv'
        },
        success: function (response) {
            // Update the href attribute of the a tag with the file name
            $('#csv').attr('href', '/JapaneseOnlineTicketingSystem/xmlGenerators/' + response);
        }
    });
});


$('#pdf').on('click', function () {
    //get the datatable value
    var tableData = $('#paymentsTable').DataTable().data().toArray();

    // Create an XML document
    var doc = document.implementation.createDocument(null, 'payments', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var paymentElem = doc.createElement('payment');
        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.paymentId);
        idElem.appendChild(idValue);
        paymentElem.appendChild(idElem);
        
        var dateElem = doc.createElement('date');
        var dateValue = doc.createTextNode(rowData.paymentDate);
        dateElem.appendChild(dateValue);
        paymentElem.appendChild(dateElem);
        
        var userElem = doc.createElement('user');
        var userValue = doc.createTextNode(rowData.paymentUser);
        userElem.appendChild(userValue);
        paymentElem.appendChild(userElem);
        
        var cardElem = doc.createElement('card');
        var cardValue = doc.createTextNode(rowData.paymentCardNum);
        cardElem.appendChild(cardValue);
        paymentElem.appendChild(cardElem);

        doc.documentElement.appendChild(paymentElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    // Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_payment_xml.php",
        data: {
            xmlData: xmlString,
            type: 'pdf'
        },
        success: function (response) {
            // Update the href attribute of the a tag with the file name
            $('#pdf').attr('href', '/JapaneseOnlineTicketingSystem/xmlGenerators/' + response);
        }
    });
});