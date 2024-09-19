@extends('admin.common.main')
@section('contents')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Entries in {{$form->name}} <a class="btn btn-primary m-l-15" href="{{route('admin.form.index')}}">Back to List</a></h2>
            </div>
            <div class="body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            @if(@unserialize(@$form->setup))
                            @foreach(@unserialize(@$form->setup) as $setup)
                            <th>{{ucwords($setup)}}</th>
                            @endforeach
                            @endif
                            <th>Submitted URL</th>
                            <th>Client IP</th>
                            <th>Added Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = ($entries->currentPage()-1)*$entries->perPage())
                        @if($entries->count()>0)
                        @foreach($entries as $entry)
                        @php($i++)
                        <tr>
                            <th scope="row">{{$i}}</th>
                            @if(@unserialize(@$form->setup))
                            @foreach(@unserialize(@$form->setup) as $setup)
                            <td>{{@$entry->fields->where('field_name', $setup)->first()->field_value}}</td>
                            @endforeach
                            @endif
                            <td>{{$entry->submitted_url}}</td>
                            <td>{{$entry->client_ip}}</td>
                            <td>{{$entry->created_at}}</td>
                            <td>
                                <a class="btn waves-effect waves-light btn-sm btn-primary m-l-5" href="{{route('admin.form.entries', $entry->id)}}">View Entries</a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                            <tr><td colspan="8"><center>No Entries Found</center></td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="footer text-center">
                {{$entries->render()}}
            </div>
        </div>
    </div>
</div>
@stop