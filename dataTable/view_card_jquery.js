$(document).ready(function () {
    $('#cardsTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/JapaneseOnlineTicketingSystem/dataTable/cards_view.php'
        },
        'columns': [
            {data: 'cardId'},
            {data: 'holderName'},
            {data: 'cardNum'},
            {data: 'expMonth'},
            {data: 'expYear'},
            {data: 'cvv'},
            {data: 'cardType'}
        ]
    });
});


$("#csv").on('click', function () {
    var tableData = $('#cardsTable').DataTable().data().toArray();

    // Create an XML document
    //the ticket here is the root tag of the string xml
    var doc = document.implementation.createDocument(null, 'Card', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var cardElem = doc.createElement('card');

        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.cardId);
        idElem.appendChild(idValue);
        cardElem.appendChild(idElem);

        var holderElem = doc.createElement('holder');
        var holderValue = doc.createTextNode(rowData.holderName);
        holderElem.appendChild(holderValue);
        cardElem.appendChild(holderElem);

        var numElem = doc.createElement("cardNum");
        var numValue = doc.createTextNode(rowData.cardNum);
        numElem.appendChild(numValue);
        cardElem.appendChild(numElem);

        var monthElem = doc.createElement("months");
        var monthValue = doc.createTextNode(rowData.expMonth);
        monthElem.appendChild(monthValue);
        cardElem.appendChild(monthElem);
        
        var yearElem = doc.createElement("years");
        var yearValue = doc.createTextNode(rowData.expYear);
        yearElem.appendChild(yearValue);
        cardElem.appendChild(yearElem);
        
        var cvvElem = doc.createElement("cvv");
        var cvvValue = doc.createTextNode(rowData.cvv);
        cvvElem.appendChild(cvvValue);
        cardElem.appendChild(cvvElem);
        
        var typeElem = doc.createElement("type");
        var typeValue = doc.createTextNode(rowData.cardType);
        typeElem.appendChild(typeValue);
        cardElem.appendChild(typeElem);

        doc.documentElement.appendChild(cardElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    //Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_card_xml.php",
        data: {
            xmlData: xmlString,
            type: 'csv'
        },
        success: function (response) {
            //Update the href attribute of the a tag with the file name
            $('#csv').attr('href', '/JapaneseOnlineTicketingSystem/xmlGenerators/' + response);
//            alert(response);
        }
    });
});

$("#pdf").on('click', function () {
    var tableData = $('#cardsTable').DataTable().data().toArray();

    // Create an XML document
    //the ticket here is the root tag of the string xml
    var doc = document.implementation.createDocument(null, 'Card', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var cardElem = doc.createElement('card');

        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.cardId);
        idElem.appendChild(idValue);
        cardElem.appendChild(idElem);

        var holderElem = doc.createElement('holder');
        var holderValue = doc.createTextNode(rowData.holderName);
        holderElem.appendChild(holderValue);
        cardElem.appendChild(holderElem);

        var numElem = doc.createElement("cardNum");
        var numValue = doc.createTextNode(rowData.cardNum);
        numElem.appendChild(numValue);
        cardElem.appendChild(numElem);

        var monthElem = doc.createElement("months");
        var monthValue = doc.createTextNode(rowData.expMonth);
        monthElem.appendChild(monthValue);
        cardElem.appendChild(monthElem);
        
        var yearElem = doc.createElement("years");
        var yearValue = doc.createTextNode(rowData.expYear);
        yearElem.appendChild(yearValue);
        cardElem.appendChild(yearElem);
        
        var cvvElem = doc.createElement("cvv");
        var cvvValue = doc.createTextNode(rowData.cvv);
        cvvElem.appendChild(cvvValue);
        cardElem.appendChild(cvvElem);
        
        var typeElem = doc.createElement("type");
        var typeValue = doc.createTextNode(rowData.cardType);
        typeElem.appendChild(typeValue);
        cardElem.appendChild(typeElem);

        doc.documentElement.appendChild(cardElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    //Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_card_xml.php",
        data: {
            xmlData: xmlString,
            type: 'pdf'
        },
        success: function (response) {
            //Update the href attribute of the a tag with the file name
            $('#pdf').attr('href', '/JapaneseOnlineTicketingSystem/xmlGenerators/' + response);
//            alert(response);
        }
    });
});
