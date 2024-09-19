@extends('admin.common.main')
@section('contents')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Forms List</h2>
            </div>
            <div class="body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = ($forms->currentPage()-1)*$forms->perPage())
                        @foreach($forms as $form)
                        @php($i++)
                        <tr>
                            <th scope="row">{{$i}}</th>
                            <td>{{$form->name}}</td>
                            <td>
                                <a class="btn waves-effect waves-light btn-sm btn-primary m-l-5" href="{{route('admin.form.show', $form->id)}}">View Entries  <span class="badge">{{$form->entries->count()}}</span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="footer text-center">
                {{$forms->render()}}
            </div>
        </div>
    </div>
</div>
@stop