@extends('layout.app',['pageTitle' => __('Role Management')])
@section('content')

@component('layout.inc.breadcrumb')
@slot('title')
{{ __('messages.roles') }}
@endslot
@endcomponent
@include('elements.alert')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('messages.role_list')}}</h4>
                <h6 class="card-subtitle">{{ __('messages.all_role') }}</h6>
                <hr class="hr-borderd">
                <div class="table-responsive">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="80">{{ __('messages.sl')}}</th>
                                <th>{{ __('messages.name')}}</th>
                                <th>{{ __('messages.slug')}}</th>
                                <th>{{ __('messages.created_at')}}</th>
                                <th width='150'>{{ __('messages.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0;?>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{sprintf("%02s",++$i) }}</td>
                                <td>{{$role->name}}</td>
                                <td>{{$role->slug}}</td>
                                <td><?php echo Pharma::globalDateTime($role->created_at)?></td>
                                <td style="display: flex; justify-content: space-evenly;">
                                    <a href="#" data-id="{{$role->id}}" class="btn waves-effect waves-light btn-xs btn-info permissions" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i></a>
                                    <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('users/role/'.$role->id.'/edit')}}"><i class="fa fa-edit"></i></a>
                                    @if(Pharma::countUserinRole($role->id) == 0 )
                                    <form action="{{url('users/role/'.$role->id.'/delete')}}" method="post"  style="margin-top:-2px" id="deleteButton{{$role->id}}">
                                        @csrf
                                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-danger" onclick="sweetalertDelete({{$role->id}})"><i class="fa fa-trash-o"></i></button>
                                    </form>
                                    @else
                                    <button disabled class="btn waves-effect waves-light btn-xs btn-danger" title="Some user is already assign"><i class="fa fa-trash-o"></i></button>
                                    @endif
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
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="role_name"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="parmission_body"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
            $('.permissions').click(function (e) {
                e.preventDefault();
                const id = $(this).data("id");
                $.ajax({
                type: "GET",
                url: "/users/role/"+id+"/show",
                data: "data",
                dataType: "json",
                success: function (parmissions) {
                    console.log(parmissions.role_name);
                        $('#parmission_body').html(parmissions.permission);
                        $('#role_name').text(parmissions.role_name);

                    }
                });
            });
</script>
@endpush
@endsection
