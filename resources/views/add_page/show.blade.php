@extends('app')
@section('content')
@if(\Auth::check())
<div class="content-wrapper">
    <?php
    $header = \App\PageHeader::find(5);
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
                        <div class="col-sm-12">
                            <div class="panel lobidisable panel-bd">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h4>Show Page</h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">     
                                        <table id="myTable" class="table  table-bordered dt-responsive   table-striped jambo_table bulk_action"> 
                                            <tr>
                                                <th style="width: 30%;">Image:</th>
                                                <td><img src="http://strikerinfotech.com/aljuan/public/{{$page['image']}}"  alt="User Image" width="100" height="100"> </td>  
                                            </tr>
                                            <tr>
                                                <th style="width: 30%;">Name:</th>
                                                <td class="our_story"> 
                                                    <div class="mytd"><input type="hidden" class="tedata" value="{{$page['name']}}" /> <div class="tbdata"></div></div>

                                                </td> 
                                            </tr>
                                            <tr>
                                                <th style="width: 30%;">Header:</th>
                                                <td> 
                                                    {{$page['header']}}
                                                </td> 
                                            </tr>
                                            <tr>
                                                <th style="width: 30%;">Title:</th>
                                                <td class="mission"> 
                                                    <div class="mytd"><input type="hidden" class="tedata" value="{{$page['title']}}" /> <div class="tbdata"></div></div>

                                                </td> 
                                            </tr>
                                            <tr>
                                                <th style="width: 30%;">Menu:</th>
                                                <td> 
                                                    {{$page->submenu['name']}}

                                                </td> 
                                            </tr>

                                        </table> 
                                    </div> 
                                </div>
                            </div>
                        </div>

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
                            <form action="{{route('backend.page.header.update',5)}}" class="form-horizontal"  enctype="multipart/form-data" role='form' method="POST">  
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
function myFunction() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}


$(document).ready(function () {
    $(".our_story").each(function () {

        var myhtml = $(this).find('.mytd').children('.tedata').val();

        $(this).find('.mytd').find('.tbdata').html(myhtml);

    });

});
$(document).ready(function () {
    $(".mission").each(function () {

        var myhtml = $(this).find('.mytd').children('.tedata').val();

        $(this).find('.mytd').find('.tbdata').html(myhtml);

    });

});
$(document).ready(function () {
    $(".certification").each(function () {

        var myhtml = $(this).find('.mytd').children('.tedata').val();

        $(this).find('.mytd').find('.tbdata').html(myhtml);

    });

});
</script>
@else
<script>window.location.href = "http://strikerinfotech.com/aljuan/public/";</script>
@endif
@stop
