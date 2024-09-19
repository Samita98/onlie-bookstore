@extends('admin.common.main')
@section('contents')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Menu Items in {{$menu->name}} <a class="btn btn-primary" href="{{route('admin.menu.new', $menu->id)}}">Add Item</a>
                </h2>
            </div>
            <div class="body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sort</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="List_Sortable" class="ui-sortable" data-url="{{route('admin.menu.ajax')}}">
                        @if(count($menus)>0)
                        @php($i = 0)
                        @foreach($menus as $menu)
                        @php($i++)
                        <tr>
                            <th scope="row">{{$i}}<span class="main_id" style="display: none;">{{$menu->id}}</span></th>
                            <td><span class="handle material-icons">swap_vert</span></td>
                            <td>{{$menu->menu_title}}</td>
                            <td>
                                <a class="btn waves-effect waves-light btn-sm btn-success" href="{{route('admin.menu.edit', $menu->id)}}">Edit Menu</a>

                                <form action="{{route('admin.menu.destroy', $menu->id)}}" method="post" onsubmit="return confirm('Are you sure want to delete this item Permanently ?');" style="display: inline-block;" class="m-l-10">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $menu->id }}">
                                    <button type="submit" class="btn waves-effect waves-light btn-sm btn-danger">Delete Permanently</button>
                                </form>
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
        </div>
    </div>
</div>
@stop