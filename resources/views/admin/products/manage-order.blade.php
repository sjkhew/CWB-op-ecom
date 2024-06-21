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
                    {{ trans('global.manage_order') }}
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table id="my-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('global.order_id') }}</th>
                                <th>{{ trans('global.name') }}</th>
                                <th>{{ trans('global.intent_id') }}</th>
                                <th>{{ trans('global.amount') }}</th>
                                <th>{{ trans('global.payment_status_title') }}</th>
                                <th>{{ trans('global.transaction_date') }}</th>
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
            ajax: '{{route("admin.manage.order")}}',
            columns: [
                { data: 'order_id', name: 'order_id' },
                { data: 'name', name: 'name' },
                { data: 'payment_intent_id', name: 'payment_intent_id' },
                { data: 'total_amount', name: 'total_amount' },
                { data: 'is_paid', name: 'is_paid', render: function (data) {
                        if(data == 1){
                            var icon = '<span class="badge badge-success">{{ trans('global.payment_status_success') }}</span>';
                        }else if(data == 0){
                            var icon = '<span class="badge badge-warning">{{ trans('global.payment_status_pending') }}</span>';
                        }else{
                            var icon = '<span class="badge badge-danger">{{ trans('global.payment_status_failed') }}</span>';
                        }
                        return icon;
                    }
                },
                { data: 'created_at', name: 'created_at' },
                { data: 'id', name: 'id', render: function (data) {
                    var routeUrl1 = "{{ route('admin.manage.order.details', ':zzz') }}";
                    routeUrl1 = routeUrl1.replace(':zzz', data);
                    return '<a href="'+routeUrl1+'" class="px-1"><span class="text-primary"><i class="fa-solid fa-file-invoice fa-lg"></i></a>';
                } }
            ],
            columnDefs: [
                { targets: [3,4,6], searchable: false},
                { targets: [6], orderable: false}
            ],
            order: [
                [ 0, 'desc' ]
            ],
        });
    });
</script>
@endsection
