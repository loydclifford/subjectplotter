@extends('public._partials._layout')

@section('main-content')

    <div class="row-fluid">
        <div class="span5">
            <h4><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Us</h4>
            <label>Name</label>
            <input type="text" value="" id="" class="input-block-level">
            <label>Email</label>
            <input type="text" value="" id="Text1" class="input-block-level">
            <label>Mobile No</label>
            <input type="text" value="" id="Text2" class="input-block-level">
            <label>Message</label>
            <textarea class="input-block-level" rows="5"></textarea>
            <a href="#" class=" btn ">Send Message&nbsp;&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>
            <br class="visible-phone">
            <br class="visible-phone">
        </div>
    </div>
@stop
