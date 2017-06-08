@extends('layouts.app')

@section('content')
<div class="container">
    @if (Session::has('success'))
        <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ Session::get('success') }}
                        </div>
                    </div>
                </div>
         @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="/" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group" id="ppt">
                    <label>Title: </label>
                    <div class="row">
                        <input type="text" class="form-control" name="title" placeholder="MakersLog" required>
                    </div>
                    <label>PPT: </label>
                    <div class="row">
                        <input type="file" class="form-control" name="ppt" value="ppt" required>
                    </div>                        
                </div>
                <button type="submit" value="Submit"  class="btn btn-success" name="submit">Upload</button>
            </form>
            <hr>
            <hr>
            <iframe src="https://docs.google.com/presentation/d/1qllpXUeRiA2IP0j3Aq99Le52lquwrbHCA3YNKoB3_gc/embed?start=false&loop=false&delayms=3000" frameborder="0" width="960" height="749" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
        </div>
    </div>
</div>
@endsection
