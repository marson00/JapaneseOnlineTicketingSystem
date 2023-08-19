$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const eventId = urlParams.get('eventId');
    //console.log(eventId);

    // Check if eventId is present in the URL
    if (eventId) {
        // eventId parameter exists in the URL, pass it to another PHP file
        $('#ticketsTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '/JapaneseOnlineTicketingSystem/dataTable/particular_ticket_view.php',
                'data': {
                    'eventId': eventId
                }
            },
            'columns': [
                {data: 'ticketId'},
                {data: 'ticketCode'},
                {data: 'eventName'},
                {data: 'statusTitle'},
                {
                    data: 'holder',
                    render: function (data, type, row) {
                        return data ? data : '-';
                    }
                }
            ]
        });
    } else {
        // eventId parameter does not exist in the URL, pass it to tickets_view.php
        $('#ticketsTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '/JapaneseOnlineTicketingSystem/dataTable/tickets_view.php',
            },
            'columns': [
                {data: 'ticketId'},
                {data: 'ticketCode'},
                {data: 'eventName'},
                {data: 'statusTitle'},
                {
                    data: 'holder',
                    render: function (data, type, row) {
                        return data ? data : '-';
                    }
                }
            ]
        });
    }
});


$("#csv").on('click', function () {
    var tableData = $('#ticketsTable').DataTable().data().toArray();

    // Create an XML document
    //the ticket here is the root tag of the string xml
    var doc = document.implementation.createDocument(null, 'Ticket', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var ticketElem = doc.createElement('ticket');

        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.ticketId);
        idElem.appendChild(idValue);
        ticketElem.appendChild(idElem);

        var titleElem = doc.createElement('code');
        var titleValue = doc.createTextNode(rowData.ticketCode);
        titleElem.appendChild(titleValue);
        ticketElem.appendChild(titleElem);

        var nameElem = doc.createElement("name");
        var nameValue = doc.createTextNode(rowData.eventName);
        nameElem.appendChild(nameValue);
        ticketElem.appendChild(nameElem);

        var statusElem = doc.createElement("status");
        var statusValue = doc.createTextNode(rowData.statusTitle);
        statusElem.appendChild(statusValue);
        ticketElem.appendChild(statusElem);

        doc.documentElement.appendChild(ticketElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    //Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_ticket_xml.php",
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
    var tableData = $('#ticketsTable').DataTable().data().toArray();

    // Create an XML document
    //the ticket here is the root tag of the string xml
    var doc = document.implementation.createDocument(null, 'Ticket', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var ticketElem = doc.createElement('ticket');

        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.ticketId);
        idElem.appendChild(idValue);
        ticketElem.appendChild(idElem);

        var titleElem = doc.createElement('code');
        var titleValue = doc.createTextNode(rowData.ticketCode);
        titleElem.appendChild(titleValue);
        ticketElem.appendChild(titleElem);

        var nameElem = doc.createElement("name");
        var nameValue = doc.createTextNode(rowData.eventName);
        nameElem.appendChild(nameValue);
        ticketElem.appendChild(nameElem);

        var statusElem = doc.createElement("status");
        var statusValue = doc.createTextNode(rowData.statusTitle);
        statusElem.appendChild(statusValue);
        ticketElem.appendChild(statusElem);

        doc.documentElement.appendChild(ticketElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    //Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_ticket_xml.php",
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
