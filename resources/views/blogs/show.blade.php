@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style="background-image: url({{ Storage::url($blog->image) }}); height: 200px; background-size: cover">
                    <h2 class="text-white">{{ $blog->title }}</h2>
                </div>

                <div class="card-body">
                    <h5>Created By :  </h5>
                    <img src="{{ Storage::url($blog->user->avatar) }}" class="rounded-circle" width="40px" height="40px" alt=""> <strong>{{ $blog->user->username }}</strong>

                    <hr>
                    <h5>Description</h5>
                    <p>{{ $blog->description }}</p>
                    <a href="/blogs" class="btn btn-primary float-right">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#blog-form').on('submit',function(e){
        e.preventDefault();
        var formData = new FormData(this);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'accept':'appplication/json'
            }
        });

        $.ajax({
            url:'/api/store-blog',
            type: "POST",
            dataType: 'json',
            processData: false,
            contentType: false,
            data:formData,

            success:function(response){
                console.log(response);
                if (response.success == true) {
                // alert("You will now be redirected.");
                window.location = "/blogs";
                }
            },
            error: function(err){
                var errors = err.responseJSON.errors;
                console.log(err.responseJSON.errors);
            }
        });
    });

});


</script>
@endsection
