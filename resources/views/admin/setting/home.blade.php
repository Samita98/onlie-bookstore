@extends('admin.common.main')
@section('contents')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Site Configuration</h2>
            </div>
            <div class="body table-responsive">
                <form method="POST" action="{{route('admin.setting.home_store')}}">
                    {{csrf_field()}}
                    <table class="table table-bordered table-striped">
                        <tbody>
                            @php($i = 0)
                            @php($configurations = array(
                                    'meta_title'=>'Meta Title'
                                )
                            )
                            @foreach($configurations as $configname => $configtitle)
                            @php($i++)
                            <tr>
                                <th scope="row">{{$i}}</th>
                                <td><label for="{{$configname}}">{{$configtitle}}</label></td>
                                <td>
                                    <input value="{{config('setting.'.$configname)}}" type="text" name="{{$configname}}" id="{{$configname}}" class="form-control">
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <th scope="row">{{++$i}}</th>
                                <td><label for="meta_description">Meta Description</label></td>
                                <td>
                                    <textarea name="meta_description" id="meta_description" class="form-control">{{config('setting.meta_description')}}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">{{++$i}}</th>
                                <td><label for="meta_keyword">Meta Keyword</label></td>
                                <td>
                                    <textarea name="meta_keyword" id="meta_keyword" class="form-control">{{config('setting.meta_keyword')}}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">{{++$i}}</th>
                                <td><label for="home_welcome">Home Welcome</label></td>
                                <td>
                                    <textarea name="home_welcome" id="home_welcome" class="form-control WYSWIYG">{{config('setting.home_welcome')}}</textarea>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <button class="btn btn-sm btn-primary waves-effect waves-dark" type="submit">Submit</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@stop