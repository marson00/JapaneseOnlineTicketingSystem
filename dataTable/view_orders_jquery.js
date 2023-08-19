$(document).ready(function () {
    $('#ordersTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/JapaneseOnlineTicketingSystem/dataTable/orders_view.php'
        },
        'columns': [
            {data: 'orderId'},
            {data: 'orderedEvent'},
            {data: 'orderedQty',
                render: function(data) {
                    return data + " tickets";
                }
            },
            {data: 'orderedPrice'},
            {data: 'orderedBy'},
            {data: 'orderedDate'},
            {data: 'orderedCard'}
        ]
    });
});


//pass data & generate csv file
$('#csv').on('click', function () {
    //get the datatable value
    var tableData = $('#ordersTable').DataTable().data().toArray();

    // Create an XML document
    var doc = document.implementation.createDocument(null, 'orders', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var orderElem = doc.createElement('order');
        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.orderId);
        idElem.appendChild(idValue);
        orderElem.appendChild(idElem);

        var eventElem = doc.createElement('event');
        var eventValue = doc.createTextNode(rowData.orderedEvent);
        eventElem.appendChild(eventValue);
        orderElem.appendChild(eventElem);
        
        var qtyElem = doc.createElement('quantity');
        var qtyValue = doc.createTextNode(rowData.orderedQty);
        qtyElem.appendChild(qtyValue);
        orderElem.appendChild(qtyElem);
        
        var priceElem = doc.createElement('price');
        var priceValue = doc.createTextNode(rowData.orderedPrice);
        priceElem.appendChild(priceValue);
        orderElem.appendChild(priceElem);
        
        var userElem = doc.createElement('user');
        var userValue = doc.createTextNode(rowData.orderedBy);
        userElem.appendChild(userValue);
        orderElem.appendChild(userElem);
        
        var dateElem = doc.createElement('date');
        var dateValue = doc.createTextNode(rowData.orderedDate);
        dateElem.appendChild(dateValue);
        orderElem.appendChild(dateElem);
        
        var cardElem = doc.createElement('card');
        var cardValue = doc.createTextNode(rowData.orderedCard);
        cardElem.appendChild(cardValue);
        orderElem.appendChild(cardElem);

        doc.documentElement.appendChild(orderElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    // Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_order_xml.php",
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

//pass data & generate csv file
$('#pdf').on('click', function () {
    //get the datatable value
    var tableData = $('#ordersTable').DataTable().data().toArray();

    // Create an XML document
    var doc = document.implementation.createDocument(null, 'orders', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var orderElem = doc.createElement('order');
        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.orderId);
        idElem.appendChild(idValue);
        orderElem.appendChild(idElem);

        var eventElem = doc.createElement('event');
        var eventValue = doc.createTextNode(rowData.orderedEvent);
        eventElem.appendChild(eventValue);
        orderElem.appendChild(eventElem);
        
        var qtyElem = doc.createElement('quantity');
        var qtyValue = doc.createTextNode(rowData.orderedQty);
        qtyElem.appendChild(qtyValue);
        orderElem.appendChild(qtyElem);
        
        var priceElem = doc.createElement('price');
        var priceValue = doc.createTextNode(rowData.orderedPrice);
        priceElem.appendChild(priceValue);
        orderElem.appendChild(priceElem);
        
        var userElem = doc.createElement('user');
        var userValue = doc.createTextNode(rowData.orderedBy);
        userElem.appendChild(userValue);
        orderElem.appendChild(userElem);
        
        var dateElem = doc.createElement('date');
        var dateValue = doc.createTextNode(rowData.orderedDate);
        dateElem.appendChild(dateValue);
        orderElem.appendChild(dateElem);
        
        var cardElem = doc.createElement('card');
        var cardValue = doc.createTextNode(rowData.orderedCard);
        cardElem.appendChild(cardValue);
        orderElem.appendChild(cardElem);

        doc.documentElement.appendChild(orderElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    // Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_order_xml.php",
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