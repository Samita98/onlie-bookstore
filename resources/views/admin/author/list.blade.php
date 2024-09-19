@extends('admin.common.main')
@section('contents')

        <div class="card">
                <div class="card-header bg-white">
      <h4 class="mb-0 p-2 font-weight-bolder">Author Name List <a class="btn waves-effect waves-light btn-primary ml-4" href="{{route('admin.author.create')}}">Add Author Name</a>
                    <?php if(!isset($_GET['trashed'])){ ?>
                        <a class="btn btn-warning waves-effect waves-light pull-right" href="{{route('admin.author.index')}}?trashed">Show Trashed</a>
                    <?php }else{ ?>
                        <a class="btn btn-warning waves-effect waves-light pull-right" href="{{route('admin.author.index')}}">Show Active</a>
                    <?php } ?></h4>
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
                        @php($i = ($authors->currentPage()-1)*$authors->perPage())
                        @if($authors->count())
                        @foreach($authors as $author)
                        @php($i++)
                        <tr>
                            <th scope="row">{{$i}}</th>
                            <td>{{$author->title}}</td>
                            <td>
                                @if(!isset($_GET['trashed']))
                                <a target="_blank" class="btn waves-effect waves-light btn-sm btn-primary m-r-10" href="{{route('author.detail', $author->permalink)}}">View</a>
                                <a class="btn waves-effect waves-light btn-sm btn-success" href="{{route('admin.author.edit', $author->id)}}">Edit</a>
                                @endif
                                @if(isset($_GET['trashed']))
                                <form action="{{route('admin.author.restore', $author->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $author->id }}">
                                    <button type="submit" class="btn waves-effect waves-light btn-sm btn-success">Restore</button>
                                </form>
                                @endif
                                <form action="{{route('admin.author.destroy', $author->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $author->id }}">
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
                                <center>No author Found</center>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="footer text-center">
                {{$authors->render()}}
            </div>
        </div>
@stop