$(document).ready(function () {
    $('#categoriesTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/JapaneseOnlineTicketingSystem/dataTable/categories_view.php'
        },
        'columns': [
            {data: 'categoryId'},
            {data: 'categoryTitle'},
            {
                render: function (data, type, row, meta) {
                    //Encryption
                    let encryptedResult = JSON.parse(encryptData(row.categoryId));
                    let encryptedCategoryId = encryptedResult.encryptedCategoryId;
                    
                    var html = `
                                    <a class="btn btn-primary btn-floating" title="Edit" href="edit_category.php?categoryId=${encryptedCategoryId}" role="button">
                                        <i class="fas fa fa-pen"></i>
                                    </a>
                                    `;
                    return html;
                },
                orderable: false
            }
        ]
    });

    //pass data & generate csv file
    $('#csv').on('click', function () {
        //get the datatable value
        var tableData = $('#categoriesTable').DataTable().data().toArray();

        // Create an XML document
        var doc = document.implementation.createDocument(null, 'category', null);

        // Loop through the table data and add it to the XML document
        tableData.forEach(function (rowData) {
            var categoryElem = doc.createElement('category');
            var idElem = doc.createElement('id');
            var idValue = doc.createTextNode(rowData.categoryId);
            idElem.appendChild(idValue);
            categoryElem.appendChild(idElem);

            var titleElem = doc.createElement('title');
            var titleValue = doc.createTextNode(rowData.categoryTitle);
            titleElem.appendChild(titleValue);
            categoryElem.appendChild(titleElem);

            doc.documentElement.appendChild(categoryElem);
        });

        // Serialize the XML document to a string
        var xmlString = new XMLSerializer().serializeToString(doc);
        console.log(xmlString);

        // Send the XML data to the server to generate the XML file
        $.ajax({
            type: "POST",
            url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_category_xml.php",
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
        var tableData = $('#categoriesTable').DataTable().data().toArray();

        // Create an XML document
        var doc = document.implementation.createDocument(null, 'categories', null);

        // Loop through the table data and add it to the XML document
        tableData.forEach(function (rowData) {
            var categoryElem = doc.createElement('category');
            var idElem = doc.createElement('id');
            var idValue = doc.createTextNode(rowData.categoryId);
            idElem.appendChild(idValue);
            categoryElem.appendChild(idElem);

            var titleElem = doc.createElement('title');
            var titleValue = doc.createTextNode(rowData.categoryTitle);
            titleElem.appendChild(titleValue);
            categoryElem.appendChild(titleElem);

            doc.documentElement.appendChild(categoryElem);
        });

        // Serialize the XML document to a string
        var xmlString = new XMLSerializer().serializeToString(doc);
        console.log(xmlString);

        // Send the XML data to the server to generate the XML file
        $.ajax({
            type: "POST",
            url: "/JapaneseOnlineTicketingSystem/xmlGenerators/generate_category_xml.php",
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
});

function encryptData(data) {
    let result = '';
    $.ajax({
        url: "../../AdminSide/Category/categoryEncryption.php",
        type: "POST",
        data: {
            'categoryId': data
        },
        cache: false,
        async: false,
        success: function (response) {
            result = response;
        }
    });
    return result;
}
