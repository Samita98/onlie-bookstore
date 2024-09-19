@extends('user.common.main')
@section('body')
<div class="card">
	<div class="card-header">
		<h4 class="card-title mb-0">All product
            <?php if(!isset($_GET['trashed'])){ ?>
                <a class="btn btn-warning waves-effect waves-light " href="{{route('user.product.index')}}?trashed">Show Trashed</a>
            <?php }else{ ?>
                <a class="btn btn-warning waves-effect waves-light " href="{{route('user.product.index')}}">Show Active</a>
            <?php } ?>
		</h4>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>S.N.</th>
						<th>Image</th>
						<th>Product title</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@php($pi=0)
				@if($products->count())
					@foreach($products as $product)
					@php($pi++)
						<tr>
							<td>{{$pi}}</td>
							<td>
                                @if($product->media)
                                    <span style="width: 65px;display: inline-block;">
                                        {!!$product->media->get_attachment('thumb')!!}
                                    </span>
                                @endif
                            </td>
							<td>{{$product->title}}</td>


                            <td>
                                @if(!isset($_GET['trashed']))
                                <a target="_blank" class="btn waves-effect waves-light btn-sm btn-primary m-r-10" href="{{route('product.detail', $product->permalink)}}">View</a>
                                <a class="btn waves-effect waves-light btn-sm btn-success" href="{{route('user.product.edit', $product->id)}}">Edit</a>
                                @endif
                                @if(isset($_GET['trashed']))
                                <form action="{{route('user.product.restore', $product->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <button type="submit" class="btn waves-effect waves-light btn-sm btn-success">Restore</button>
                                </form>
                                @endif
                                <form action="{{route('user.product.destroy', $product->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <button type="submit" class="btn waves-effect waves-light btn-sm btn-danger">
                                        <?php if(isset($_GET['trashed'])){ ?>
                                    Delete Permanently<?php }else{ echo 'Trash'; } ?></button>
                                </form>
                                
                            </td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="4"><center>No Product Found</center></td>
					</tr>
				@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection