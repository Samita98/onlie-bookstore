@extends('admin.common.main')
@section('contents')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Entries Detail Information  <a class="btn btn-primary m-l-15" href="{{route('admin.form.index')}}">Back to List</a>
                </h2>
            </div>
            <div class="body table-responsive">
                <table class="table table-bordered table-striped">
                    <tbody>
                        @foreach($entries as $entrie)
                            <tr>
                                <th scope="row">{{$entrie->field_name}}</th>
                                <td>{{$entrie->field_value}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop