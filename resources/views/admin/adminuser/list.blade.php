@extends('admin.common.main')
@section('contents')
<div class="card">
    <div class="card-header bg-white">
        <h4 class="mb-0 p-2 font-weight-bolder">Admin User</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <th>S.N.</th>
                    <th>Image</th>
                    <th>FullName</th>
                    <th>Email</th>
                    <th>Created at</th>
                    <th></th>
                </thead>
                <tbody>
                    @if($users->count())
                    @php($i=0)
                        @foreach($users as $user)
                        @php($i++)
                            <tr>
                                <td>{{$i}}</td>
                                <td width="50">@if($user->media)
                                    {!!$user->media->get_attachment('thumb')!!}
                                @endif</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td>
                                <td><a class="btn btn-success btn-sm" href="{{route('admin.admin.edit', $user->id)}}">Edit</a></td>
                            </tr>
                        @endforeach
                    @endif
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection