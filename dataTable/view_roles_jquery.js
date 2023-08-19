$(document).ready(function () {
    var dataTable = $('#rolesTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/JapaneseOnlineTicketingSystem/dataTable/roles_view.php'
        },
        'columns': [
            {data: 'roleId'},
            {data: 'roleTitle'},
            {
                render: function (data, type, row, meta) {
                    //Encryption
                    let encryptedResult = JSON.parse(encryptData(row.roleId));
                    let encryptedRoleId = encryptedResult.encryptedRoleId;
                    
                    var html = `
                                    <a class="btn btn-primary btn-floating" title="Edit" href="edit_role.php?roleId=${encryptedRoleId}" role="button">
                                        <i class="fas fa fa-pen"></i>
                                    </a>`;
                    return html;
                },
                orderable: false
            }
        ]
    });

//pass data & generate csv file
    $('#csv').on('click', function () {
        //get the datatable value
        var tableData = $('#rolesTable').DataTable().data().toArray();

        // Create an XML document
        var doc = document.implementation.createDocument(null, 'roles', null);

        // Loop through the table data and add it to the XML document
        tableData.forEach(function (rowData) {
            var roleElem = doc.createElement('role');
            var idElem = doc.createElement('id');
            var idValue = doc.createTextNode(rowData.roleId);
            idElem.appendChild(idValue);
            roleElem.appendChild(idElem);

            var titleElem = doc.createElement('title');
            var titleValue = doc.createTextNode(rowData.roleTitle);
            titleElem.appendChild(titleValue);
            roleElem.appendChild(titleElem);

            doc.documentElement.appendChild(roleElem);
        });

        // Serialize the XML document to a string
        var xmlString = new XMLSerializer().serializeToString(doc);
        console.log(xmlString);

        // Send the XML data to the server to generate the XML file
        $.ajax({
            type: "POST",
            url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_role_xml.php",
            data: {
                xmlData: xmlString,
                type : 'csv'
            },
            success: function (response) {
                // Update the href attribute of the a tag with the file name
                $('#csv').attr('href', '/JapaneseOnlineTicketingSystem/xmlGenerators/' + response);
            }
        });
    });
    
    //pass data & generate pdf file
    $('#pdf').on('click', function () {
        var tableData = $('#rolesTable').DataTable().data().toArray();

        // Create an XML document
        var doc = document.implementation.createDocument(null, 'roles', null);

        // Loop through the table data and add it to the XML document
        tableData.forEach(function (rowData) {
            var roleElem = doc.createElement('role');
            var idElem = doc.createElement('id');
            var idValue = doc.createTextNode(rowData.roleId);
            idElem.appendChild(idValue);
            roleElem.appendChild(idElem);

            var titleElem = doc.createElement('title');
            var titleValue = doc.createTextNode(rowData.roleTitle);
            titleElem.appendChild(titleValue);
            roleElem.appendChild(titleElem);

            doc.documentElement.appendChild(roleElem);
        });

        // Serialize the XML document to a string
        var xmlString = new XMLSerializer().serializeToString(doc);
        console.log(xmlString);

        //Send the XML data to the server to generate the XML file
        $.ajax({
            type: "POST",
            url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_role_xml.php",
            data: {
                xmlData: xmlString,
                type : 'pdf'
            },
            success: function (response) {
                //Update the href attribute of the a tag with the file name
                $('#pdf').attr('href', '/JapaneseOnlineTicketingSystem/xmlGenerators/' + response);
                //alert(response);
            }
        });
    });
});

function encryptData(data) {
    let result = '';
    $.ajax({
        url: "../../AdminSide/Role/roleEncryption.php",
        type: "POST",
        data: {
            'roleId': data
        },
        cache: false,
        async: false,
        success: function (response) {
            result = response;
        }
    });
    return result;
}
