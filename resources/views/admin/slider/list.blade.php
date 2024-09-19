@extends('admin.common.main')
@section('contents')
<div class="card">
<div class="card-header bg-white">
    <h2 class="pageheader-title">Slider List <a class="btn waves-effect waves-light btn-primary ml-4" href="{{route('admin.slider.create')}}">Add Slider</a>
    <?php if(!isset($_GET['trashed'])){ ?>
        <a class="btn btn-warning waves-effect waves-light pull-right" href="{{route('admin.slider.index')}}?trashed">Show Trashed</a>
    <?php }else{ ?>
        <a class="btn btn-warning waves-effect waves-light pull-right" href="{{route('admin.slider.index')}}">Show Active</a>
    <?php } ?></h2>    
</div>

<div class="card-body table-responsive">
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
             <?php if(!isset($_GET['trashed'])){ ?>
            <th>Sort</th>
            <?php } ?>
            <th>Image</th>
            <th>Title</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="List_Sortable" class="ui-sortable" data-url="{{route('admin.slider.ajax')}}">
        @php($i = ($sliders->currentPage()-1)*$sliders->perPage())
        @if($sliders->count())
        @foreach($sliders as $slider)
        @php($i++)
        <tr>
            <th scope="row">{{$i}}<span class="main_id" style="display: none;">{{$slider->id}}</span></th>
            <?php if(!isset($_GET['trashed'])){ ?>
            <td><i class="fa fa-arrows-v handle" aria-hidden="true"></i></td>
            <?php } ?>
            <td width="150">
                @if(@$slider->media)
                  {!!@$slider->media->get_attachment('thumb')!!}
                @endif                                
            </td>
            <td>{{$slider->title}}</td>
            <td>
                @if(isset($_GET['trashed']))
                <form action="{{route('admin.slider.restore', $slider->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $slider->id }}">
                    <button type="submit" class="btn waves-effect waves-light btn-sm btn-success">Restore</button>
                </form>
                @else
                <a class="btn waves-effect waves-light btn-sm btn-success" href="{{route('admin.slider.edit', $slider->id)}}">Edit</a>
                @endif
                <form action="{{route('admin.slider.destroy', $slider->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="id" value="{{ $slider->id }}">
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
                <center>No Slider Found</center>
            </td>
        </tr>
        @endif
    </tbody>
</table>
</div>
<div class="footer text-center">
{{$sliders->render()}}
</div>
</div>
@stop