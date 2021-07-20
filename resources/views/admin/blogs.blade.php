@extends('admin.admin_layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Blogs

                </div>

                <div class="card-body">
                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>tags</th>
                                <th>username</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $blog)

                            <tr>
                                <td>
                                    <img src="{{ Storage::url($blog->image) }}" width="60px" alt="">
                                </td>
                                <td>{{ $blog->title }}</td>
                                <td>{{ $blog->tags }}</td>
                                <td>{{ $blog->user->username }}</td>
                                <td>
                                    @if (isset($blog->deleted_at))
                                    <a href="/blog/delete-permenent/{{ $blog->slug }}" class="btn btn-danger">Delete Permanently</a>

                                    @else
                                    <a href="/blog/delete-permenent/{{ $blog->slug }}" class="btn btn-danger">Delete</a>

                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
