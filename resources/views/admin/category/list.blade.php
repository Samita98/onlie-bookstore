@extends('admin.common.main')
@section('contents')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0 p-2 font-weight-bolder">
            Category List <a class="btn waves-effect waves-light btn-primary ml-3" href="{{route('admin.category.create')}}">Add Category</a>
            <?php if(!isset($_GET['trashed'])){ ?>
                <a class="btn btn-warning waves-effect waves-light pull-right" href="{{route('admin.category.index')}}?trashed">Show Trashed</a>
            <?php }else{ ?>
                <a class="btn btn-warning waves-effect waves-light pull-right" href="{{route('admin.category.index')}}">Show Active</a>
            <?php } ?>
        </h4>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 0)
                @if(count($categories))
                @foreach($categories as $category)
                @php($i++)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{$category->title}}</td>
                    <td>
                        @if(!isset($_GET['trashed']))
                        <a class="btn waves-effect waves-light btn-sm btn-success m-r-10 m-l-10" href="{{route('admin.category.edit', $category->id)}}">Edit</a>
                        @endif
                        @if(isset($_GET['trashed']))
                        <form action="{{route('admin.category.restore', $category->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $category->id }}">
                            <button type="submit" class="btn waves-effect waves-light btn-sm btn-success">Restore</button>
                        </form>
                        @endif
                        <form action="{{route('admin.category.destroy', $category->id)}}" method="post" style="display: inline-block;" class="ml-3 mb-0">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="id" value="{{ $category->id }}">
                            <button type="submit" class="btn waves-effect waves-light btn-sm btn-danger">
                                <?php if(isset($_GET['trashed'])){ ?>
                            Delete Permanently<?php }else{ echo 'Trash'; } ?></button>
                        </form>
                        
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="8">
                        <center>No Category Found</center>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="footer text-center">

    </div>
</div>
@stop