@extends('layout.app',['pageTitle' => __('Permission Management')])
@section('content')

@component('layout.inc.breadcrumb')
    @slot('title')
        {{ __('messages.permissions') }}
    @endslot
@endcomponent
{{--   --}}
@include('elements.alert')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('messages.permission_list') }}</h4>
                    <h6 class="card-subtitle">{{ __('messages.all_permission') }}..</h6>
                    <hr class="hr-borderd">
                    <div class="col-lg-12">
                    <div class="Content">
                            <table class="table table-bordered table-hover Content" id="myTable">
                                <thead>
                                <tr class="themeThead">
                                    <th width="50">{{__('SL')}}</th>
                                    <th style="width: 25%" >{{__('Name')}}</th>
                                    <th>{{__('Description')}}</th>
                                    <th>{{__('Slug')}}</th>
                                    <th width="80">{{__('Action')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 0;?>
                                @foreach($data as $key)
                                    <tr>
                                        <td>{{sprintf('%02d',++$i)}}</td>
                                        <td>
                                            @if($key->parent_id!=0)
                                                |_
                                            @endif
                                            {{ $key->name }}
                                        </td>
                                        <td>{{ $key->description}}</td>
                                        <td>{{ $key->slug}}</td>
                                            <td style="display: flex; justify-content: space-evenly;">
                                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                                <a class="btn waves-effect waves-light text-light btn-xs btn-warning" href="{{url('users/permission/'.$key->id.'/edit')}}"><i class="fa fa-edit"></i></a>
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
