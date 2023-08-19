$(document).ready(function () {
    $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        serverMethod: 'post',
        ajax: {
            url: '/JapaneseOnlineTicketingSystem/dataTable/users_view.php'
        },
        columns: [
            {data: 'userId'},
            {data: 'username'},
            {data: 'email'},
            {data: 'phone', render: function (data, type, row) {
                    return data ? data : '-';
                }
            },
            {data: 'statusTitle'},
            {data: 'roleTitle'},
            {render: function (data, type, row) {
                    return `${row.createdBy} at ${row.creationDate}`;
                }
            },
            {render: function (data, type, row) {
                    return row.updatedBy && row.updatedDate ? `${row.updatedBy} at ${row.updatedDate}` : '-';
                }
            },
            {
                render: function (data, type, row) {
                    //Encryption
                    let encryptedResult = JSON.parse(encryptData(row.userId))
                    let encryptedUserId = encryptedResult.encryptedUserId;
//                    console.log(encryptedResult);
//                    console.log(encryptedUserId);

                    let buttonsHtml =
                            `
            <a class="btn btn-primary btn-floating mr-1 ml-1" title="Edit" href="edit_user.php?userId=${encryptedUserId}" role="button">
                <i class="fas fa fa-pen"></i>
            </a>
            <button class="btn btn-danger btn-floating ml-1" value="${encryptedUserId}">
                <i class="fas fa fa-trash"></i>
            </button>`;
                    if (row.statusTitle === 'Deactive') {
                        buttonsHtml =
                                `<button class="btn btn-success btn-floating ml-1" value="${encryptedUserId}">
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
    $('#usersTable').on('click', '.btn-danger', function () {
        const userId = $(this).val();
        performOperation(userId, 'delete', 'delete');
    });

    //Recovers
    $('#usersTable').on('click', '.btn-success', function () {
        const userId = $(this).val();
        performOperation(userId, 'recover', 'recover');
    });

});

function performOperation(userId, actionText, action) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary ml-2',
            cancelButton: 'btn btn-danger mr-2'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: `Confirm to ${actionText} this user account?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: `Yes, ${actionText} it!`,
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = `delete_recover_user.php?action=${action}&userId=${userId}`;
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

function encryptData(data) {
    let result = '';
    $.ajax({
        url: "../../AdminSide/Users/userEncryption.php",
        type: "POST",
        data: {
            'userId': data
        },
        cache: false,
        async: false,
        success: function (response) {
            result = response;
        }
    });
    return result;
}

//pass data & generate csv file
$('#csv').on('click', function () {
    //get the datatable value
    var tableData = $('#usersTable').DataTable().data().toArray();

    // Create an XML document
    var doc = document.implementation.createDocument(null, 'users', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var userElem = doc.createElement('user');
        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.userId);
        idElem.appendChild(idValue);
        userElem.appendChild(idElem);

        var nameElem = doc.createElement('name');
        var nameValue = doc.createTextNode(rowData.username);
        nameElem.appendChild(nameValue);
        userElem.appendChild(nameElem);

        var emailElem = doc.createElement('email');
        var emailValue = doc.createTextNode(rowData.email);
        emailElem.appendChild(emailValue);
        userElem.appendChild(emailElem);
        

        var phoneElem = doc.createElement('phone');
        var phoneValue = doc.createTextNode(rowData.phone);
        phoneElem.appendChild(phoneValue);
        userElem.appendChild(phoneElem);
        

        var statusElem = doc.createElement('status');
        var statusValue = doc.createTextNode(rowData.statusTitle);
        statusElem.appendChild(statusValue);
        userElem.appendChild(statusElem);
        

        var roleElem = doc.createElement('role');
        var roleValue = doc.createTextNode(rowData.roleTitle);
        roleElem.appendChild(roleValue);
        userElem.appendChild(roleElem);
        

        var createElem = doc.createElement('create');
        var createValue = doc.createTextNode(`${rowData.createdBy} at ${rowData.creationDate}`);
        createElem.appendChild(createValue);
        userElem.appendChild(createElem);
        

        var updateElem = doc.createElement('update');
        var updateValue = doc.createTextNode(`${rowData.updatedBy} at ${rowData.updatedDate}`);
        updateElem.appendChild(updateValue);
        userElem.appendChild(updateElem);
        
        doc.documentElement.appendChild(userElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    // Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_user_xml.php",
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


//pass data & generate pdf file
$('#pdf').on('click', function () {
    //get the datatable value
    var tableData = $('#usersTable').DataTable().data().toArray();

    // Create an XML document
    var doc = document.implementation.createDocument(null, 'users', null);

    // Loop through the table data and add it to the XML document
    tableData.forEach(function (rowData) {
        var userElem = doc.createElement('user');
        var idElem = doc.createElement('id');
        var idValue = doc.createTextNode(rowData.userId);
        idElem.appendChild(idValue);
        userElem.appendChild(idElem);

        var nameElem = doc.createElement('name');
        var nameValue = doc.createTextNode(rowData.username);
        nameElem.appendChild(nameValue);
        userElem.appendChild(nameElem);

        var emailElem = doc.createElement('email');
        var emailValue = doc.createTextNode(rowData.email);
        emailElem.appendChild(emailValue);
        userElem.appendChild(emailElem);
        

        var phoneElem = doc.createElement('phone');
        var phoneValue = doc.createTextNode(rowData.phone);
        phoneElem.appendChild(phoneValue);
        userElem.appendChild(phoneElem);
        

        var statusElem = doc.createElement('status');
        var statusValue = doc.createTextNode(rowData.statusTitle);
        statusElem.appendChild(statusValue);
        userElem.appendChild(statusElem);
        

        var roleElem = doc.createElement('role');
        var roleValue = doc.createTextNode(rowData.roleTitle);
        roleElem.appendChild(roleValue);
        userElem.appendChild(roleElem);
        

        var createElem = doc.createElement('create');
        var createValue = doc.createTextNode(`${rowData.createdBy} at ${rowData.creationDate}`);
        createElem.appendChild(createValue);
        userElem.appendChild(createElem);
        

        var updateElem = doc.createElement('update');
        var updateValue = doc.createTextNode(`${rowData.updatedBy} at ${rowData.updatedDate}`);
        updateElem.appendChild(updateValue);
        userElem.appendChild(updateElem);
        
        doc.documentElement.appendChild(userElem);
    });

    // Serialize the XML document to a string
    var xmlString = new XMLSerializer().serializeToString(doc);
    console.log(xmlString);

    // Send the XML data to the server to generate the XML file
    $.ajax({
        type: "POST",
        url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_user_xml.php",
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
