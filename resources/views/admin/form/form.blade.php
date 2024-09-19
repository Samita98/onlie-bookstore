@extends('admin.common.main')
@section('contents')
<div class="card">
  <div class="header">
    <h2>Form Setup - {{@$form->name}} <a class="btn btn-primary" href="{{route('admin.form.index')}}">Back to List</a></h2>
  </div>
  <div class="body">
      <form method="post" action="{{route('admin.form.update', $form->id)}}">
      <input name="_method" type="hidden" value="PUT">  
      
      {{csrf_field()}}
     
      <div class="nav-tabs-custom">          
        <div class="row g-3">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="form-label">Success Message</label>
            <input value="{{@$form->success_msg}}" id="success_msg" name="success_msg" class="form-control" type="text">        
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="form-label">Admin Email</label>
            <input value="{{@$form->email}}" id="email" name="email" class="form-control" type="text">
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="box-footer clearfix">
          <ul class="list-inline">
            <li><button onclick="needToConfirm = false" type="submit" value="submit" name="SubmitBtn" class="btn btn-success">Submit</button></li>
          </ul>
        </div>
      </div> 
    </form>
  </div>
</div>
@stop