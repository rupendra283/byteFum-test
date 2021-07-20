@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edit Blog
                </div>

                <div class="card-body">
                    <form action="{{ route('blog.update', $blog->slug) }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" class="form-control" value="{{ $blog->title }}" type="text" name="title">
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input id="image" class="form-control" type="file" name="image">
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input id="tags" class="form-control" value="{{ $blog->tags }}" placeholder="comma saparated tags" type="text" name="tags" >
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" cols="4" rows="4">{{ $blog->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// $(document).ready(function () {
//     $('#blog-form').on('submit',function(e){
//         e.preventDefault();
//         var formData = new FormData(this);

//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
//                 'accept':'appplication/json',
//                 "Authorization": 'Bearer '+ localStorage.getItem('api_token')
//             }
//         });

//         $.ajax({
//             url:'/api/store-blog',
//             type: "POST",
//             dataType: 'json',
//             processData: false,
//             contentType: false,
//             data:formData,

//             success:function(response){
//                 console.log(response);
//                 if (response.success == true) {
//                 // alert("You will now be redirected.");
//                 window.location = "/blogs";
//                 }
//             },
//             error: function(err){
//                 var errors = err.responseJSON.errors;
//                 console.log(err.responseJSON.errors);
//             }
//         });
//     });

// });


</script>
@endsection
