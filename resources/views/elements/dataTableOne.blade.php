@push('js')
<!-- This is data table -->
<script src="{{ asset('material') }}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<!-- start - This is for export functionality only -->
<script src="{{ asset('js') }}/dataTables.buttons.min.js"></script>
<script src="{{ asset('js') }}/buttons.flash.min.js"></script>
<script src="{{ asset('js') }}/jszip.min.js"></script>
<script src="{{ asset('js') }}/pdfmake.min.js"></script>
<script src="{{ asset('js') }}/vfs_fonts.js"></script>
<script src="{{ asset('js') }}/buttons.html5.min.js"></script>
<script src="{{ asset('js') }}/buttons.print.min.js"></script>
<script>
$(document).ready(function() {
    $('#myTable').DataTable();
    $('#myTable2').DataTable();
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
        // Order by the grouping
        $('#example tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
    });
});
$('#example23').DataTable({
    dom: 'Bfrtip',
    "lengthMenu": [[25, 50, -1], [25, 50, "All"]],
    buttons: [
        'csv', 'excel', 'print'
    ]
});
$('#example22').DataTable({
    dom: 'Bfrtip',
    "lengthMenu": [[25, 50, -1], [25, 50, "All"]],
    buttons: [
        'csv', 'excel', 'print'
    ]
});
$('#dataTableNoPaging').DataTable({
    dom: 'Bfrtip',
    "lengthMenu": [[25, 50, -1], [25, 50, "All"]],
    paging: false,
    // buttons: [
    //     'excel', 'csv', 'pdf'
    // ]
    buttons: [
            // { extend: 'copyHtml5', footer: true },
            // { extend: 'excelHtml5', footer: true },
            // { extend: 'csvHtml5', footer: true },
            // { extend: 'pdfHtml5', footer: true }
        ]
});
$('#dataTableNoPagingDesc').DataTable({
    dom: 'Bfrtip',
    "lengthMenu": [[25, 50, -1], [25, 50, "All"]],
    paging: false,
    buttons: [
        'excel', 'csv', 'pdf'
    ],
    "ordering": false
});
</script> 
@endpush