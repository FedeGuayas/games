@if (Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        {{Session::get('message')}}
    </div>
    {{--{{Session::forget('message')}}--}}
    @elseif(Session::has('message_danger'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get('message_danger')}}
    </div>
{{--    {{Session::forget('message_danger')}}--}}
@endif