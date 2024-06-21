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
                    {{ trans('global.manage_product_details') }}
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row pb-2 pr-1">
                        <div class="col-lg-6">
                            <h4>{{ trans('global.product_name') }}: <span class="badge badge-primary">{{ $product->name }}</span></h4>
                        </div>
                        <div class="col-lg-6 text-right">
                            <a href="{{route("admin.manage.product")}}" class="btn btn-danger">{{ trans('global.back') }}</a>
                            <a href="{{route("admin.create.product.details",$pid)}}" class="btn btn-primary">{{ trans('global.add_product_details') }}</a>
                        </div>
                    </div>

                    <table id="my-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('global.product_name') }}</th>
                                <th>{{ trans('global.description') }}</th>
                                <th>{{ trans('global.quantity') }}</th>
                                <th>{{ trans('global.price_include_vat') }}</th>
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
            ajax: '{{url()->current()}}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'desc', name: 'desc' },
                { data: 'qty', name: 'qty' },
                { data: 'price', name: 'price' },
                { data: 'is_active', name: 'is_active', render: function (data) {
                        if(data == 1){
                            var icon = '<span class="text-success"><i class="fa-solid fa-circle-check"></i></span>';
                        }else{
                            var icon = '<span class="text-danger"><i class="fa-solid fa-circle-xmark"></i></span>';
                        }
                        return icon;
                    }
                },
                { data: 'id', name: 'id', render: function (data) {
                    var routeUrl = "{{ route('admin.edit.product.details', ':zzz') }}";
                    routeUrl = routeUrl.replace(':zzz', data);
                    return '<a href="'+routeUrl+'"><span class="text-primary"><i class="fa-solid fa-pen-to-square"></i></a>';
                } }
            ],
            columnDefs: [
                { targets: [0,1,2,3], searchable: false},
                { targets: [5], orderable: false}
            ],
        });
    });
</script>
@endsection
