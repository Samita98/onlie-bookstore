@extends('admin.common.main')
@section('contents')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                User List
                <?php if(!isset($_GET['trashed'])){ ?>
                        <a class="btn btn-warning waves-effect waves-light pull-right" href="{{route('admin.user.index')}}?trashed">Show Trashed</a>
                    <?php }else{ ?>
                        <a class="btn btn-warning waves-effect waves-light pull-right" href="{{route('admin.user.index')}}">Show Active</a>
                    <?php } ?>
                </h2>
            </div>
            <div class="body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$users->isEmpty())
                        @php($i = ($users->currentPage()-1)*$users->perPage())
                        @foreach($users as $user)
                        @php($i++)
                        <tr>
                            <th scope="row">{{$i}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone_no}}</td>
                            <td>
                            @if(isset($_GET['trashed']))
                                <form action="{{route('admin.user.restore', $user->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button type="submit" class="btn waves-effect waves-light btn-sm btn-success">Restore</button>
                                </form>
                                 @endif
                                <form action="{{route('admin.user.destroy', $user->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button type="submit" class="btn waves-effect waves-light btn-sm btn-danger">
                                        <?php if(isset($_GET['trashed'])){ ?>
                                    Delete Permanently<?php }else{ echo 'Trash'; } ?></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8" class="text-center">No user found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="footer text-center">
                {{$users->render()}}
            </div>
        </div>
    </div>
</div>
@stop