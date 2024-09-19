@extends('admin.common.main')
@section('contents')
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">
        <div class="header">
            <h2>Form Entries</h2>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-hover dashboard-task-infos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Form Title</th>
                            <th>Entries Count</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
            @php($fcount=0)
            @foreach($forms as $form)
            @php($fcount++)
                <tr>
                    <td>{{$fcount}}</td>
                    <td>{{$form->name}}</td>
                    <td>{{$form->entries->count()}}</td>
                    <td><a class="btn waves-effect waves-light btn-sm btn-primary m-l-5" href="{{route('admin.form.show', $form->id)}}">View Entries</a></td>
                </tr>
            @endforeach
            </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="card">
        <div class="header">
            <h2>Latest Reviews</h2>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-hover dashboard-task-infos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Review By</th>
                            <th>Posted On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($rcount=0)
                        @foreach($reviews as $review)
                        @php($rcount++)
                            <tr>
                                <td>{{$rcount}}</td>
                                <td>{{$review->user->name}}</td>
                                <td>{{$review->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection