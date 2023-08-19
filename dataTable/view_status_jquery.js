$(document).ready(function () {
    $('#statusTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/JapaneseOnlineTicketingSystem/dataTable/status_view.php'
        },
        'columns': [
            {data: 'statusId'},
            {data: 'statusTitle'},
            {
                render: function (data, type, row, meta) {
                    //Encryption
                    let encryptedResult = JSON.parse(encryptData(row.statusId));
                    let encryptedStatusId = encryptedResult.encryptedStatusId;
                    
                    var html = `
                                    <a class="btn btn-primary btn-floating" title="Edit" href="edit_status.php?statusId=${encryptedStatusId}" role="button">
                                        <i class="fas fa fa-pen"></i>
                                    </a>
                                    `;
                    return html;
                },
                orderable: false
            }
        ]
    });

    $('#csv').on('click', function () {
        //get the datatable value
        var tableData = $('#statusTable').DataTable().data().toArray();

        // Create an XML document
        var doc = document.implementation.createDocument(null, 'status', null);

        // Loop through the table data and add it to the XML document
        tableData.forEach(function (rowData) {
            //create the role & id element (tag)
            var statusElem = doc.createElement('status');
            var idElem = doc.createElement('id');
            //get the value of the id from the data
            var idValue = doc.createTextNode(rowData.statusId);

            //append the id value to the id element, than append id element to role element
            idElem.appendChild(idValue);
            statusElem.appendChild(idElem);

            var titleElem = doc.createElement('title');
            var titleValue = doc.createTextNode(rowData.statusTitle);
            titleElem.appendChild(titleValue);
            statusElem.appendChild(titleElem);

            doc.documentElement.appendChild(statusElem);
        });

        // Serialize the XML document to a string
        var xmlString = new XMLSerializer().serializeToString(doc);
        console.log(xmlString);

        // Send the XML data to the server to generate the XML file
        $.ajax({
            type: "POST",
            url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_status_xml.php",
            data: {
                xmlData: xmlString,
                type: 'csv'
            },
            success: function (response) {
                $('#csv').attr('href', '/JapaneseOnlineTicketingSystem/xmlGenerators/' + response);
                // alert(response);
                // Update the href attribute of the a tag with the file name
            }
        });
    });

    $('#pdf').on('click', function () {
        //get the datatable value
        var tableData = $('#statusTable').DataTable().data().toArray();

        // Create an XML document
        var doc = document.implementation.createDocument(null, 'status', null);

        // Loop through the table data and add it to the XML document
        tableData.forEach(function (rowData) {
            //create the role & id element (tag)
            var statusElem = doc.createElement('status');
            var idElem = doc.createElement('id');
            //get the value of the id from the data
            var idValue = doc.createTextNode(rowData.statusId);

            //append the id value to the id element, than append id element to role element
            idElem.appendChild(idValue);
            statusElem.appendChild(idElem);

            var titleElem = doc.createElement('title');
            var titleValue = doc.createTextNode(rowData.statusTitle);
            titleElem.appendChild(titleValue);
            statusElem.appendChild(titleElem);

            doc.documentElement.appendChild(statusElem);
        });

        // Serialize the XML document to a string
        var xmlString = new XMLSerializer().serializeToString(doc);
        console.log(xmlString);

        // Send the XML data to the server to generate the XML file
        $.ajax({
            type: "POST",
            url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_status_xml.php",
            data: {
                xmlData: xmlString,
                type: 'pdf'
            },
            success: function (response) {
                $('#pdf').attr('href', '/JapaneseOnlineTicketingSystem/xmlGenerators/' + response);
                // alert(response);
                // Update the href attribute of the a tag with the file name
            }
        });
    });
});

function encryptData(data) {
    let result = '';
    $.ajax({
        url: "../../AdminSide/Status/statusEncryption.php",
        type: "POST",
        data: {
            'statusId': data
        },
        cache: false,
        async: false,
        success: function (response) {
            result = response;
        }
    });
    return result;
}
