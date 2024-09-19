@extends('admin.common.main')
@section('contents')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Menu List</h2>
            </div>
            <div class="body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$menus->isEmpty())
                        @php($i = ($menus->currentPage()-1)*$menus->perPage())
                        @foreach($menus as $menu)
                        @php($i++)
                        <tr>
                            <th scope="row">{{$i}}</th>
                            <td>{{$menu->name}}</td>
                            <td>
                                <a class="btn waves-effect waves-light btn-sm btn-success" href="{{route('admin.menu.show', $menu->id)}}">View Menus</a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8" class="text-center">No Menu found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="footer text-center">
                {{$menus->render()}}
            </div>
        </div>
    </div>
</div>
@stop