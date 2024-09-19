@extends('admin.common.main')
@section('contents')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0 p-2 font-weight-bolder">Media List
    @if(!isset($_GET['trashed']))
        <a class="btn btn-warning waves-effect waves-light float-right" href="{{route('admin.media.index')}}?trashed">Show Trashed</a>
    @else
        <a class="btn btn-warning waves-effect waves-light float-right" href="{{route('admin.media.index')}}">Show Active</a>
    @endif</h4>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php($i = ($medias->currentPage()-1)*$medias->perPage())
                @if($medias->count())
                @foreach($medias as $media)
                @php($i++)
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>
                        <div style="width: 75px;">{!!$media->get_attachment('thumb')!!}</div>
                    </td>
                    <td>{{$media->alt}}</td>
                    <td>
                        @if(isset($_GET['trashed']))
                        <form action="{{route('admin.media.restore', $media->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $media->id }}">
                            <button type="submit" class="btn waves-effect waves-light btn-sm btn-success">Restore</button>
                        </form>
                        @endif
                        <form action="{{route('admin.media.destroy', $media->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="id" value="{{ $media->id }}">
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
                        <center>No media Found</center>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="footer text-center">
        {{$medias->render()}}
    </div>
</div>

@stop