@extends('admin.common.main')
@section('contents')

<script>var abcdef = "{{route('admin.product.ajax')}}";</script>
        <div class="card">
                <div class="card-header bg-white">
      <h4 class="mb-0 p-2 font-weight-bolder">Products List 
            <?php if(!isset($_GET['trashed'])){ ?>
                <a class="btn btn-warning waves-effect waves-light " href="{{route('admin.product.index')}}?trashed">Show Trashed</a>
            <?php }else{ ?>
                <a class="btn btn-warning waves-effect waves-light " href="{{route('admin.product.index')}}">Show Active</a>
            <?php } ?>
      </h4>

    </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Featured</th>
                            <th>New Release</th>
                            <th>Book Title</th>
                            <th>Posted by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = ($products->currentPage()-1)*$products->perPage())
                        @if($products->count())
                        @foreach($products as $product)
                        @php($i++)
                        <tr>
                            <th scope="row">{{$i}}</th>
                            <th>
                                <?php if($product->featured_at){ ?>
                                <a href="javascript:void(0);" onclick="change_status(<?php echo $product->id?>, this, abcdef, 'change_featured')" class=""><i class="fa fa-check btn btn-xs btn-success" aria-hidden="true"></i></a>

                                <?php }else{ ?>
                                <a href="javascript:void(0);" onclick="change_status(<?php echo $product->id?>, this, abcdef,  'change_featured')" class=""><i class="fa fa-times btn btn-xs btn-danger" aria-hidden="true"></i></a>
                                <?php } ?>
                            </th>
                            <th>
                              <?php if($product->latest_product){ ?>
                              <a href="javascript:void(0);" onclick="change_status(<?php echo $product->id?>, this, abcdef, 'change_latest')" class=""><i class="fa fa-check btn btn-xs btn-success" aria-hidden="true"></i></a>
                        
                              <?php }else{ ?>
                              <a href="javascript:void(0);" onclick="change_status(<?php echo $product->id?>, this, abcdef,  'change_latest')" class=""><i class="fa fa-times btn btn-xs btn-danger" aria-hidden="true"></i></a>
                              <?php } ?>
                            </th>
                            <td>{{$product->title}}</td>
                            <td>{{$product->user->name}}</td>
                            <td>
                                @if(!isset($_GET['trashed']))
                                <a target="_blank" class="btn waves-effect waves-light btn-sm btn-primary m-r-10" href="{{route('product.detail', $product->permalink)}}">View</a>
                                <a class="btn waves-effect waves-light btn-sm btn-success" href="{{route('admin.product.edit', $product->id)}}">Edit</a>
                                @endif
                                @if(isset($_GET['trashed']))
                                <form action="{{route('admin.product.restore', $product->id)}}" method="post" style="display: inline-block;" class="m-l-10">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <button type="submit" class="btn waves-effect waves-light btn-sm btn-success">Restore</button>
                                </form>
                                @endif
                                <form action="{{route('admin.product.destroy', $product->id)}}" method="post" style="display: inline-block;" class="m-l-10">
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
                            <td colspan="8">
                                <center>No Product Found</center>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="footer text-center">
                {{$products->render()}}
            </div>
        </div>
@stop