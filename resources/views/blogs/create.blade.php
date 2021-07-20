@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Create Blog
                </div>

                <div class="card-body">
                    <form action="" id="blog-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" class="form-control" type="text" name="title">
                            <span class="text-danger" id="title-err"></span>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input id="image" class="form-control" type="file" name="image">
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input id="tags" class="form-control" placeholder="comma saparated tags" type="text" name="tags" >
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" cols="4" rows="4"></textarea>
                            <span class="text-danger" id="desc-err"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
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
                'Accept':'appplication/json',
                "Authorization": 'Bearer '+ localStorage.getItem('api_token')
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
                // console.log(response);
                if (response.success == true) {
                // alert("You will now be redirected.");
                window.location = "/blogs";
                }
            },
            error: function(err){
                var errors = err.responseJSON.errors;
                if (errors.title) {
                    $('#title-err').html(errors.title[0]);
                } else {
                    $('#title-err').html('');
                }
                if (errors.description) {
                    $('#desc-err').html(errors.description[0]);
                } else {
                    $('#desc-err').html('');
                }

            }
        });
    });

});


</script>
@endsection
