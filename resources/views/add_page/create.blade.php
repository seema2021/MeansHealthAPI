@extends('app')
@section('content')
@if(\Auth::check())
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>  
<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script> 
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-users"></i>
        </div>
        <div class="header-title">
            <h1>Add Page</h1>
            <small>.</small>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">                       
                    <div class="panel-body">
                        <form action="{{route('backend.add.page.store')}}" class="form-horizontal" enctype="multipart/form-data" role='form' method="POST">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label style="color:#009688">Enter Name</label>
                                    <input type="text" name="name"  class="form-control" placeholder="Enter Name" required>
                                </div>
                                <div class="form-group">
                                    <label style="color:#009688">Enter Header</label>
                                    <input type="text" name="header"  class="form-control" placeholder="Enter Header" required>
                                </div>
                                <div class="form-group">
                                    <label style="color:#009688">Enter Image</label>
                                    <input type="file" name="image"  class="form-control" placeholder="Enter Image" required>
                                </div>
                                <div class="form-group">
                                    <label style="color:#009688">Select Menu</label>
                                    <select  class="form-control" name="menu" required>
                                        <option>Select</option>
                                        @foreach($menus as $menu)
                                        <option value="{{$menu['id']}}">{{$menu['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="color:#009688">Enter Titlt</label>
                                    <textarea type="text" name="title" id="editor1" class="form-control" placeholder="Enter Title" required></textarea>
                                </div>

                                <button href="#" class="btn btn-success"  type="submit" style="width: 200px; margin-left: 10px; margin-left: 128px; background-color: #009688;
                                        border-color: #009688;">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
    </section>
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