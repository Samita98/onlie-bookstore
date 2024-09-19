@extends('admin.common.main')
@section('contents')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                Review List
                <?php if(!isset($_GET['trashed'])){ ?>
                        <a class="btn btn-warning waves-effect waves-light pull-right" href="{{route('admin.review.index')}}?trashed">Show Trashed</a>
                    <?php }else{ ?>
                        <a class="btn btn-warning waves-effect waves-light pull-right" href="{{route('admin.review.index')}}">Show Active</a>
                    <?php } ?>
                </h2>
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
                        @if(!$reviews->isEmpty())
                        @php($i = ($reviews->currentPage()-1)*$reviews->perPage())
                        @foreach($reviews as $review)
                        @php($i++)
                        <tr>
                            <th scope="row">{{$i}}</th>
                            <td>{{$review->user->name}}</td>
                            <td>
                            @if(isset($_GET['trashed']))
                                <form action="{{route('admin.review.restore', $review->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $review->id }}">
                                    <button type="submit" class="btn waves-effect waves-light btn-sm btn-success">Restore</button>
                                </form>
                                 @endif
                                <form action="{{route('admin.review.destroy', $review->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $review->id }}">
                                    <button type="submit" class="btn waves-effect waves-light btn-sm btn-danger">
                                        <?php if(isset($_GET['trashed'])){ ?>
                                    Delete Permanently<?php }else{ echo 'Trash'; } ?></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8" class="text-center">No review found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="footer text-center">
                {{$reviews->render()}}
            </div>
        </div>
    </div>
</div>
@stop