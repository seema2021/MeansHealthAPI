@extends('app')
@section('content')
@if(\Auth::check())
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>  
<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script> 
<div class="content-wrapper">
    <?php
    $header = \App\PageHeader::find(6);
    ?>
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-users"></i>
        </div>
        <div class="header-title">
            <h1>Add Page</h1>
            <small>.</small>
            <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#basicModal" style="    margin-left: 96%;
               margin-top: -24px; background-color: #009688;
               border-color: #009688; color: white" ><i class="fa fa-edit" ></i></a>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">                       
                    <div class="panel-body">
                        <form action="{{route('backend.add.page.update',$page->id)}}" class="form-horizontal"  enctype="multipart/form-data" role='form' method="POST">  
                            <input type="hidden" name="_method" value="PUT">   
                            <input type="hidden" name="_token" value="{{csrf_token()}}"> 
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label style="color:#009688">Change Image</label>
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="form-group">
                                            <img src="http://strikerinfotech.com/aljuan/public/{{$page['image']}}" class="img-circle" width="200" height="200"> <input type="file" name="image" value="{{$page['image']}}" class="form-control" placeholder="Enter Our Story" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="color:#009688">Name</label>
                                    <input type="text" name="name" value="{{$page['name']}}"  class="form-control" placeholder="Enter Name" required>
                                </div>
                                <div class="form-group">
                                    <label style="color:#009688">Header</label>
                                    <input type="text" name="header" value="{{$page['header']}}"  class="form-control" placeholder="Enter Header" required>
                                </div>
                                <div class="form-group">
                                    <label style="color:#009688" >Select Menu</label>
                                    <select class="form-control" name="menu" value="{{$page['menu']}}">
                                        <option value="{{$page['menu']}}">Select</option>
                                        @foreach($menus as $menu)
                                        <option value="{{$menu['id']}}">{{$menu['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="color:#009688">Title</label>
                                    <textarea type="text" name="title" id="editor2"  class="form-control" placeholder="Enter Title" required>{{$page['title']}}</textarea>
                                </div>
                                <button href="#" class="btn btn-success" type="submit" style="width: 200px; margin-left: 10px; margin-left: 128px; background-color: #009688;
                                        border-color: #009688;">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
    </section>
</div>
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Details</h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">                       
                        <div class="panel-body">
                            <form action="{{route('backend.page.header.update',6)}}" class="form-horizontal"  enctype="multipart/form-data" role='form' method="POST">  
                                <input type="hidden" name="_method" value="PUT">   
                                <input type="hidden" name="_token" value="{{csrf_token()}}"> 
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="title" value="{{$header['title']}}" class="form-control" placeholder="" required>
                                    </div>
                                    <button href="#" class="btn btn-success" type="submit" style="width: 200px; margin-left: 10px; margin-left: 128px; background-color: #009688;
                                            border-color: #009688;">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
CKEDITOR.replace('editor1');
CKEDITOR.replace('editor2');
CKEDITOR.replace('editor3');
</script> 
@else
<script>window.location.href = "http://strikerinfotech.com/aljuan/public/";</script>
@endif
@stop