$(document).ready(function () {
    $('#eventsTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/JapaneseOnlineTicketingSystem/dataTable/events_view.php'
        },
        'columns': [
            {data: 'eventId'},
            {data: 'eventName'},
            {
                data: 'image',
                render: function (data, type, row, meta) {
                    return '<a href="http://localhost/JapaneseOnlineTicketingSystem/pictures/' + data + ' ">' + data + '</a>';
                }
            },
            {data: 'capacity',
                render: function (data, type, row, meta) {
                    return '<a href="http://localhost/JapaneseOnlineTicketingSystem/AdminSide/Ticket/view_all_ticket.php?eventId=' + row.eventId + '" >' + data + '</a>';
                }
            },
            {data: 'quantityLeft'},
            {data: 'price'},
            {render: function (data, type, row) {
                    return `From ${row.startDate} to ${row.endDate}`;
                }
            },
            {data: 'categoryTitle'},
            {data: 'statusTitle'},
            {
                render: function (data, type, row) {
                    //Encryption
                    let encryptedResult = JSON.parse(encryptData(row.eventId));
                    let encryptedEventId = encryptedResult.encryptedEventId;
                    console.log(encryptedResult);
                    console.log(encryptedEventId);
                    let buttonsHtml =
                            `
                            <a class="btn btn-primary btn-floating mr-1 ml-1" title="Edit" href="edit_event.php?eventId=${encryptedEventId}" role="button">
                                <i class="fas fa fa-pen"></i>
                            </a>
                            <button class="btn btn-danger btn-floating ml-1" value="${encryptedEventId}">
                                <i class="fas fa fa-trash"></i>
                            </button>`;
                    if (row.statusTitle === 'Deactive') {
                        buttonsHtml =
                                `<button class="btn btn-success btn-floating ml-1" value="${encryptedEventId}">
                            <i class="fas fa fa-arrows-rotate"></i>
                        </button>`;
                    }
                    return buttonsHtml;
                },

                orderable: false
            }
        ]
    });

    //Delete 
    $('#eventsTable').on('click', '.btn-danger', function () {
        const eventId = $(this).val();
        performOperation(eventId, 'delete', 'delete');
    });

    //Recovers
    $('#eventsTable').on('click', '.btn-success', function () {
        const eventId = $(this).val();
        performOperation(eventId, 'recover', 'recover');
    });


});

function performOperation(eventId, actionText, action) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary ml-2',
            cancelButton: 'btn btn-danger mr-2'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: `Confirm to ${actionText} this event?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: `Yes, ${actionText} it!`,
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = `delete_recover_event.php?action=${action}&eventId=${eventId}`;
            window.location.href = url;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Successful cancel operation!',
                    'success'
                    );
        }
    });
}

$('#csv').on('click', function () {
    // Get the datatable value
    var tableData = $('#eventsTable').DataTable().data().toArray();

    // Create an XML document
    var doc = document.implementation.createDocument(null, 'events', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var eventElem = doc.createElement('event');
        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.eventId);
        idElem.appendChild(idValue);
        eventElem.appendChild(idElem);

        var nameElem = doc.createElement('name');
        var nameValue = doc.createTextNode(rowData.eventName);
        nameElem.appendChild(nameValue);
        eventElem.appendChild(nameElem);

        var imageElem = doc.createElement('image');
        var imageValue = doc.createTextNode(rowData.image);
        imageElem.appendChild(imageValue);
        eventElem.appendChild(imageElem);

        var capacityElem = doc.createElement('capacity');
        var capacityValue = doc.createTextNode(rowData.capacity);
        capacityElem.appendChild(capacityValue);
        eventElem.appendChild(capacityElem);

        var quantityLeftElem = doc.createElement('quantityLeft');
        var quantityLeftValue = doc.createTextNode(rowData.quantityLeft);
        quantityLeftElem.appendChild(quantityLeftValue);
        eventElem.appendChild(quantityLeftElem);

        var priceElem = doc.createElement('price');
        var priceValue = doc.createTextNode(rowData.price);
        priceElem.appendChild(priceValue);
        eventElem.appendChild(priceElem);

        var startDateElem = doc.createElement('startDate');
        var startDateValue = doc.createTextNode(rowData.startDate);
        startDateElem.appendChild(startDateValue);
        eventElem.appendChild(startDateElem);

        var endDateElem = doc.createElement('endDate');
        var endDateValue = doc.createTextNode(rowData.endDate);
        endDateElem.appendChild(endDateValue);
        eventElem.appendChild(endDateElem);

        var categoryElem = doc.createElement('category');
        var categoryValue = doc.createTextNode(rowData.categoryTitle);
        categoryElem.appendChild(categoryValue);
        eventElem.appendChild(categoryElem);

        var statusElem = doc.createElement('status');
        var statusValue = doc.createTextNode(rowData.statusTitle);
        statusElem.appendChild(statusValue);
        eventElem.appendChild(statusElem);

        doc.documentElement.appendChild(eventElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    // Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_event_xml.php",
        data: {
            xmlData: xmlString,
            type: 'csv'
        },
        success: function (response) {
            alert(response);
            // Update the href attribute of the a tag with the file name
            $('#csv').attr('href', '/JapaneseOnlineTicketingSystem/xmlGenerators/' + response);
        }
    });
});


$('#pdf').on('click', function () {
    // Get the datatable value
    var tableData = $('#eventsTable').DataTable().data().toArray();

    // Create an XML document
    var doc = document.implementation.createDocument(null, 'events', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var eventElem = doc.createElement('event');
        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.eventId);
        idElem.appendChild(idValue);
        eventElem.appendChild(idElem);

        var nameElem = doc.createElement('name');
        var nameValue = doc.createTextNode(rowData.eventName);
        nameElem.appendChild(nameValue);
        eventElem.appendChild(nameElem);

        var imageElem = doc.createElement('image');
        var imageValue = doc.createTextNode(rowData.image);
        imageElem.appendChild(imageValue);
        eventElem.appendChild(imageElem);

        var capacityElem = doc.createElement('capacity');
        var capacityValue = doc.createTextNode(rowData.capacity);
        capacityElem.appendChild(capacityValue);
        eventElem.appendChild(capacityElem);

        var quantityLeftElem = doc.createElement('quantityLeft');
        var quantityLeftValue = doc.createTextNode(rowData.quantityLeft);
        quantityLeftElem.appendChild(quantityLeftValue);
        eventElem.appendChild(quantityLeftElem);

        var priceElem = doc.createElement('price');
        var priceValue = doc.createTextNode(rowData.price);
        priceElem.appendChild(priceValue);
        eventElem.appendChild(priceElem);

        var startDateElem = doc.createElement('startDate');
        var startDateValue = doc.createTextNode(rowData.startDate);
        startDateElem.appendChild(startDateValue);
        eventElem.appendChild(startDateElem);

        var endDateElem = doc.createElement('endDate');
        var endDateValue = doc.createTextNode(rowData.endDate);
        endDateElem.appendChild(endDateValue);
        eventElem.appendChild(endDateElem);

        var categoryElem = doc.createElement('category');
        var categoryValue = doc.createTextNode(rowData.categoryTitle);
        categoryElem.appendChild(categoryValue);
        eventElem.appendChild(categoryElem);

        var statusElem = doc.createElement('status');
        var statusValue = doc.createTextNode(rowData.statusTitle);
        statusElem.appendChild(statusValue);
        eventElem.appendChild(statusElem);

        doc.documentElement.appendChild(eventElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    // Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_event_xml.php",
        data: {
            xmlData: xmlString,
            type: 'pdf'
        },
        success: function (response) {
            //alert(response);
            // Update the href attribute of the a tag with the file name
            $('#pdf').attr('href', '/JapaneseOnlineTicketingSystem/xmlGenerators/' + response);
        }
    });
});

function encryptData(data) {
    let result = '';
    $.ajax({
        url: "../../AdminSide/Event/eventEncryption.php",
        type: "POST",
        data: {
            'eventId': data
        },
        cache: false,
        async: false,
        success: function (response) {
            result = response;
        }
    });
    return result;
}
