@extends('admin.common.main')
@section('contents')
<div class="card">
  <div class="header">
    <h2>Menu Item &nbsp;&nbsp;&nbsp;&nbsp;
      @if(@$menu)
        <a class="btn btn-sm btn-primary m-l-10" href="{{route('admin.menu.new', $menucat->id)}}">Add New Item in <?php echo $menucat->name; ?></a>
      @endif
      <a class="btn btn-sm btn-danger m-l-10" href="{{route('admin.menu.show', $menucat->id)}}">Back to <?php echo $menucat->name; ?></a>
    </h2>
  </div>
  <div class="body table-responsive">
    @if(isset($menu))
      <form method="post" action="{{route('admin.menu.update', $menu->id)}}">
      <input name="_method" type="hidden" value="PUT">  
    @else
      <form method="post" action="{{route('admin.menu.store', $menucat->id)}}">
    @endif
    {{csrf_field()}}
  <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div>
        <label for="link_type">Link Type</label><br>
        <select class="form-control" id="link_type" name="link_type" >
            <option value="0" <?php if(@$menu->link_type==0) echo 'selected'; ?>>Internal Link</option>
            <option value="1" <?php if(@$menu->link_type==1) echo 'selected'; ?>>External Link</option>
          </select>
      </div>
    </div>
  </div>
  <div id="internal_link_group"  style="display: <?php if(@$menu->link_type==1) echo "none";  ?>">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div>
            <label for="link_from">Link From</label><br>
            <select class="form-control" id="link_from" name="dbname">
              <option value="">Select</option>
              <option <?php if(@$menu->dbname=='blog') echo 'selected'; ?> value="blog">Blog</option>
              <option <?php if(@$menu->dbname=='pages') echo 'selected'; ?> value="pages">Page</option>
              <option <?php if(@$menu->dbname=='categories') echo 'selected'; ?> value="categories">Category</option>
            </select>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div >
          <label for="menu_link" >Select Link</label><br>
          <select class="form-control withsearch" id="menu_link" name="menu_link" >
            <option value="">Select</option>
            <?php if(@$menu->link_type==0 && !empty(@$menu->menu_link)){
              foreach($alllinks as $alllink){ ?>
                <option <?php if(@$menu->menu_link==$alllink->id){ echo "selected='selected'"; $placeholdertitle = @$alllink->title; } ?> value="<?php echo @$alllink->id; ?>"><?php echo @$alllink->title; ?></option>
            <?php } } ?>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div id="external_link_group"  style="display:<?php if(@$menu->link_type==0) echo "none";  ?>">        
    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div>
          <label for="custom_Link">Input Link</label><br>
          <input id="custom_Link" class="form-control" type="text" name="custom_link" value="<?php if(@$menu->link_type==1) echo @$menu->custom_link;  ?>">
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 col-sm-8 col-xs-12">
      <div >
        <label for="menu_title">Menu Title <small style="color:red;">(Only Input if the link is custom link or if you have to change the title of the link.)</small></label>
        <input placeholder="<?php echo @$placeholdertitle; ?>" value="<?php echo @$menu->menu_title; ?>" class="form-control" id="menu_title" name="menu_title" type="text">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div >
        <label for="menu_class">Menu Class</label>
        <input value="<?php echo @$menu->menu_class; ?>" class="form-control" id="menu_class" name="menu_class" type="text">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="parent_id">Parent Link</label><br >
        <select name="parent_id" id="parent_id" class="form-control withsearch">
          <option value="0">Self</option>
              <?php
              echo $parent_links; ?>
          </select>
        </div>
      </div>
    </div>
    <div class="box-footer clearfix">
      <ul class="list-inline">
        <li><button onclick="needToConfirm = false" type="submit" value="continue" name="SubmitBtn" class="btn btn-primary">Submit</button></li>
      </ul>
    </div>  
  </form>
</div>
</div>
@endsection