@extends('layout.app',['pageTitle' => __('User Management')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.users') }}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('messages.user') }}</h4>
                <h6 class="card-subtitle">{{__('messages.user_list')}}</h6>
                <hr class="hr-borderd">
                <div class="table-responsive">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="80">{{ __('messages.sl') }}</th>
                                <th>{{ __('messages.name') }}</th>
                                <th>{{ __('messages.email') }}</th>
                                <th>{{ __('messages.last_login') }}</th>
                                <th width='150'>{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0;?>
                            @foreach($users as $user)
                            <tr>
                                <td>{{sprintf("%02s",++$i) }}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td><?php echo Pharma::globalDateTime($user->last_login)?></td>
                                <td style="display: flex; justify-content: space-evenly;">
                                    <button type="button" class="btn waves-effect waves-light btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('users/'.$user->id.'/edit')}}"><i class="fa fa-edit"></i></a>
                                    <form action="{{url('users/'.$user->id.'/delete')}}" method="post" style="margin-top:-2px" id="deleteButton{{$user->id}}">
                                        @csrf
                                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$user->id}})"><i class="fa fa-trash-o"></i></button>
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
