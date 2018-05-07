@extends('frontend')
@section('content')
<section id="page-heading-sec">
    <img src="http://strikerinfotech.com/aljuan/public/{{$menu['image']}}" alt="First Slide Image">
    <h1 class="wow slideInLeft text-center">{{$menu['name']}}</h1>
</section>
<section class="section-padding-ash" id="our-services">
    <div class="container">
        <div class="row">
            <div class="row">
                <p class="sec-title"></p>
                <h3 class="sec-hding" >{{$menu['name']}}</h3><br>
                <h3 class="Project_sub_name" style="margin-top: 54px;">{{$menu['header']}}</h3>
                <div>
                    <div class="title"> 
                            <div class="mytd"><input type="hidden" class="tedata" value="{{$menu['title']}}" /> <div class="tbdata"></div></div>

                        </div> 
                </div>
            </div>
        </div>
        <br/>
    </div>

</section>
<script src="http://strikerinfotech.com/aljuan/public/frontend/js/jquery.min.js"></script> 
    <script src="http://strikerinfotech.com/aljuan/public/frontend/js/main.js"></script>
    <script>
$(document).ready(function () {
    $(".title").each(function () {

        var myhtml = $(this).find('.mytd').children('.tedata').val();

        $(this).find('.mytd').find('.tbdata').html(myhtml);

    });

});
    </script>
@stop