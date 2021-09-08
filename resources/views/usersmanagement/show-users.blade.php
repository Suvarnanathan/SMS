@extends('layouts.admin')

@section('template_title')
    {!! trans('usersmanagement.showing-all-users') !!}
@endsection

@section('template_linked_css')
    @if(config('usersmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <style type="text/css" media="screen">
        .users-table {
            border: 0;
        }
        .users-table tr td:first-child {
            padding-left: 15px;
        }
        .users-table tr td:last-child {
            padding-right: 15px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {!! trans('usersmanagement.showing-all-users') !!}
                            </span>

                            <div class="btn-group pull-right btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        {!! trans('usersmanagement.users-menu-alt') !!}
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="/users/create">
                                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                        {!! trans('usersmanagement.buttons.create-new') !!}
                                    </a>
                                    <a class="dropdown-item" href="/users/deleted">
                                        <i class="fa fa-fw fa-group" aria-hidden="true"></i>
                                        {!! trans('usersmanagement.show-deleted-users') !!}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                    <div class="form-group">
                    <input type="text" class="form-controller" id="search" name="search"></input>
                    </div>


                        <div class="table-responsive users-table">
                            <table class="table table-striped table-sm data-table" id="users">
                                <caption id="user_count">
                                    {{ trans_choice('usersmanagement.users-table.caption', 1, ['userscount' => $users->count()]) }}
                                </caption>
                                <thead class="thead">
                                    <tr>
                                        <th>{!! trans('usersmanagement.users-table.id') !!}</th>
                                        <th>{!! trans('usersmanagement.users-table.name') !!}</th>
                                        <th class="hidden-xs">{!! trans('usersmanagement.users-table.email') !!}</th>
                                        <th class="hidden-xs">{!! trans('usersmanagement.users-table.fname') !!}</th>
                                        <th class="hidden-xs">{!! trans('usersmanagement.users-table.lname') !!}</th>
                                        <th>{!! trans('usersmanagement.users-table.role') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md">{!! trans('usersmanagement.users-table.created') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md">{!! trans('usersmanagement.users-table.updated') !!}</th>
                                        <th>{!! trans('usersmanagement.users-table.actions') !!}</th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="users_table">
                                   
                                </tbody>
                                

                            </table>

                            @if(config('usersmanagement.enablePagination'))
                                {{ $users->links() }}
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
search();
function search(query ='')
{

    $.ajax({
        url:"{{route('search-users.search')}}",
        method:'GET',
        data:{query:query},
        dataType:'json',
        success:function(data)
        {
            $('tbody').html(data.table_data);
        }
    });
}
$(document).on('keyup','#search',function(){
    var query=$(this).val();
    search(query);
})
</script>
@include('modals.modal-delete')
@include('scripts.delete-modal-script')
@endsection

@section('footer_scripts')
    
    
@endsection
