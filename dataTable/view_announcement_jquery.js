$(document).ready(function () {
    $('#announcementsTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/JapaneseOnlineTicketingSystem/dataTable/announcements_view.php'
        },
        'columns': [
            {data: 'announcementId'},
            {data: 'image'},
            {data: 'hyperlink'},
            {data: 'creationDate'},
            {
                render: function (data, type, row, meta) {
                    var html = `
                                    <a class="btn btn-primary btn-floating mr-1" title="Edit" href="edit_announcement.php?announcementId=${row.announcement_id}" role="button">
                                        <i class="fas fa fa-pen"></i>
                                    </a>
                                    <a class="btn btn-danger btn-floating ml-1" title="Delete" href="delete_role.php?announcementId=${row.announcement_id}" role="button">
                                        <i class="fas fa fa-trash"></i>
                                    </a>`;
                    return html;
                },
                orderable: false
            }
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
