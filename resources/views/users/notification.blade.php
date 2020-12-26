@extends('layout.app',['pageTitle' => __('Notification')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.notificaton') }}
@endslot
@endcomponent
{{--   --}}
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('messages.notification_li') }}</h4>
                <h6 class="card-subtitle">{{ __('messages.all_activity')}}..</h6>
                <hr class="hr-borderd">
                <div class="col-lg-12">
                    <div class="Content">
                        <table class="table table-bordered table-hover Content" id="myTable">
                            <thead>
                                <tr class="themeThead">
                                    <th>{{__('SL')}}</th>
                                    <th>{{__('From')}}</th>
                                    {{-- <th>{{__('User')}}</th> --}}
                                    <th>{{__('Content')}}</th>
                                    <th>{{__('View Status')}}</th>
                                    <th width="80">{{__('Action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 0;?>
                                @foreach($notifications as $key)
                                <tr>
                                    <td>{{sprintf("%02s",++$i) }}</td>
                                    <td>{{Sentinel::findById($key->from)->name}}</td>
                                    {{-- <td>{{Sentinel::findById($key->user)->name}}</td> --}}
                                    {{-- <td>{{$key->user}}</td> --}}
                                    <td>{{$key->content}}</td>
                                    <td>
                                        @if ($key->is_read==0)
                                        <i class="fa fa-times"></i>
                                        @else
                                        <i class="fa fa-check"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{url('users/notification/'.$key->id.'/delete')}}" method="GET"
                                            id="deleteButton{{$key->id}}">
                                            <button class="btn btn-danger" name="archive" type="submit" onclick="sweetalertDelete({{$key->id}})"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="{{ asset('js') }}/sweetalert.min.js"></script>
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
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
    </script>
    @endpush

    @endsection
