$(document).ready(function () {
    $('#ordersDetailsTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/JapaneseOnlineTicketingSystem/dataTable/orders_details_view.php'
        },
        'columns': [
            {data: 'orderDetailId'},
            {data: 'orderId'},
            {data: 'ticketCode'},
        ]
    });
});


//pass data & generate csv file
$('#csv').on('click', function () {
    //get the datatable value
    var tableData = $('#ordersDetailsTable').DataTable().data().toArray();

    // Create an XML document
    var doc = document.implementation.createDocument(null, 'orderDetails', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var orderDetailElem = doc.createElement('orderDetail');
        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.orderDetailId);
        idElem.appendChild(idValue);
        orderDetailElem.appendChild(idElem);

        var orderElem = doc.createElement('order');
        var orderValue = doc.createTextNode(rowData.orderId);
        orderElem.appendChild(orderValue);
        orderDetailElem.appendChild(orderElem);

        var codeElem = doc.createElement('code');
        var codeValue = doc.createTextNode(rowData.ticketCode);
        codeElem.appendChild(codeValue);
        orderDetailElem.appendChild(codeElem);

        doc.documentElement.appendChild(orderDetailElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    // Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_order_details_xml.php",
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
    var tableData = $('#ordersDetailsTable').DataTable().data().toArray();

    // Create an XML document
    var doc = document.implementation.createDocument(null, 'orderDetails', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var orderDetailElem = doc.createElement('orderDetail');
        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.orderDetailId);
        idElem.appendChild(idValue);
        orderDetailElem.appendChild(idElem);

        var orderElem = doc.createElement('order');
        var orderValue = doc.createTextNode(rowData.orderId);
        orderElem.appendChild(orderValue);
        orderDetailElem.appendChild(orderElem);

        var codeElem = doc.createElement('code');
        var codeValue = doc.createTextNode(rowData.ticketCode);
        codeElem.appendChild(codeValue);
        orderDetailElem.appendChild(codeElem);

        doc.documentElement.appendChild(orderDetailElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    // Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_order_details_xml.php",
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