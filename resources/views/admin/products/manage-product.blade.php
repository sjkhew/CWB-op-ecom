@extends('layouts.admin')

@section('styles')
<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet" >
@endsection

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.manage_product') }}
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row pb-2 pr-1">
                        <div class="col-lg-12 text-right">
                            <a href="{{route("admin.create.product")}}" class="btn btn-primary">{{ trans('global.add_product') }}</a>
                        </div>
                    </div>

                    <table id="my-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('global.product_name') }}</th>
                                <th>{{ trans('global.is_enabled') }}</th>
                                <th>{{ trans('global.actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(function() {
        $('#my-table').DataTable({
            processing: true,
            serverSide: true,
            pagingType: 'simple_numbers',
            language: {
                paginate: {
                    previous: '<i class="fas fa-chevron-left"></i>',
                    next: '<i class="fas fa-chevron-right"></i>'
                }
            },
            ajax: '{{route("admin.manage.product")}}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'is_active', name: 'is_active', render: function (data) {
                        if(data == 1){
                            var icon = '<span class="text-success"><i class="fa-solid fa-circle-check fa-lg"></i></span>';
                        }else{
                            var icon = '<span class="text-danger"><i class="fa-solid fa-circle-xmark fa-lg"></i></span>';
                        }
                        return icon;
                    }
                },
                { data: 'id', name: 'id', render: function (data) {
                    var routeUrl1 = "{{ route('admin.edit.product', ':zzz') }}";
                    var routeUrl2 = "{{ route('admin.manage.product.details', ':zzz') }}";
                    routeUrl1 = routeUrl1.replace(':zzz', data);
                    routeUrl2 = routeUrl2.replace(':zzz', data);
                    return '<a href="'+routeUrl1+'" class="px-1"><span class="text-primary"><i class="fa-solid fa-pen-to-square fa-lg"></i></a><a href="'+routeUrl2+'" class="px-1"><span class="text-primary"><i class="fa-solid fa-sitemap fa-lg"></i></a>';
                } }
            ],
            columnDefs: [
                { targets: [2], searchable: false},
                { targets: [2], orderable: false}
            ],
        });
    });
</script>
@endsection
