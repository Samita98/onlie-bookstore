@extends('admin.common.main')
@section('contents')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Site Configuration</h2>
            </div>
            <div class="body table-responsive">
                <form method="POST" action="{{route('admin.setting.store')}}">
                    {{csrf_field()}}
                    <table class="table table-bordered table-striped">
                        <tbody>
                            @php($i = 0)
                            @php($configurations = array(
                                    'pemail'=>'Primary Email',
                                    'semail'=>'Secondary Email',
                                    'location'=>'Location',
                                    'contact'=>'Contact No.',
                                    'mobile'=>'Mobile No.',
                                    'smobile'=>'Secondary Mobile No.',
                                    'facebook'=>'Facebook URL',
                                    'twitter'=>'Twitter URL',
                                    'linkedin'=>'Linkedin URL',
                                    'youtube' =>'Youtube',
                                    'instagram' =>'Instagram'
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