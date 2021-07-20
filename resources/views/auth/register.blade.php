@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                 <div class="card-body">
                    <div class="alert alert-secondary " id="alert-err" role="alert">
                        <ul id="errors">
                        </ul>
                    </div>
                    <div class="container">
                      <div class="col-lg-8 m-auto d-block">
                        <form action="" method="POST" enctype="multipart/form-data" id="reg-form">
                            <div class="form-group">
                                <label for="avatar">Avatar</label>
                                <input type="file" name="avatar" class="form-control-file" id="avatar">
                            </div>
                            <div class="form-group">
                                <label for ="username">Username:</label>
                                <input type="text" name="username" id="username" class="form-control">
                                <span class="text-danger" id="username-err"></span>
                            </div>
                          <div class="form-group">
                              <label for="user">
                                    Email:
                              </label>
                              <input type="text" name="email" id="email" class="form-control">
                                <span class="text-danger" id="emailvalid"></span>
                                  @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                          <div class="form-group">
                              <label for="user">
                                  Company Name
                              </label>
                              <input type="text" name="companyName"
                                id="companyName"
                                class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="mobile">
                                  Mobile No:
                            </label>
                            <input type="text" name="mobile_no"
                              id="mobile_no"
                              class="form-control">
                              <span class="text-danger" id="mobileValid"></span>
                        </div>
                          <div class="form-group">
                              <label for="password">
                                    Password:
                              </label>
                              <input type="password" name="password"
                                id="password" class="form-control">
                                <span class="text-danger" id="passwordvalid"></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                          <div class="form-group">
                              <label for="conpassword">
                                    Confirm Password:
                              </label>
                              <input type="password" name="password_confirmation"
                                    id="password_confirmation" class="form-control">
                                    <span class="text-danger" id="confirmPsd"></span>
                          </div>
                          <input type="submit" id="submitbtn"
                             value="Submit" class="btn btn-primary">
                        </form>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>


$(document).ready(function () {
    $('#reg-form').on('submit',function(e){
        e.preventDefault();
        var formData = new FormData(this);
        // var data = JSON.stringify(Array.from(formData));
        var validated = validateForm(formData);
        // console.log(validated);
        if (validated) {
            $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'accept':'appplication/json'
        }

        });
            $.ajax({
                url:'/register',
                type: "POST",
                dataType: 'json',
                processData: false,
                contentType: false,
                data:formData,

                success:function(response){
                    // console.log(response);
                    if (response.success == true) {
                    // alert("You will now be redirected.");
                    window.location = "/login";
                }

                },
                error: function(err){
                    var errors = err.responseJSON.errors;

                    console.log(err.responseJSON.errors);
                        $.each(errors, function(key, val){
                            console.log(val);
                             var li = `<li>${val[0]}</li>`;
                             $('#errors').append(li);
                        });

                    $('.alert').removeClass('d-none');
                    $('.alert').alert();
                }
            });

        }
    });

});

function validateForm(inputData){

    if (inputData.get('username') == '') {
        $('#username-err').text('Please Enter username');
        return false;
    }else{

        $('#username-err').text('');
    }

    if (inputData.get('email') == '') {
        $('#emailvalid').text('Please Enter email');
        return false;
    }else if(!(inputData.get('email').indexOf("@") > 0)){
        $('#emailvalid').text('Enter valid email address');
    }else{
        $('#emailvalid').text('');

    }

    if (inputData.get('mobile_no') == ''  ) {
        $('#mobileValid').text('Please Enter Mobile Number');
        return false;
    }else if(inputData.get('mobile_no').length != 10){
        $('#mobileValid').text('Mobile no must be 10 digits');
    }else{

        $('#mobileValid').text('');
    }

    if (inputData.get('password') == '') {
        $('#passwordvalid').text('Please Enter password');
        return false;
    }else{
        $('#passwordvalid').text('');
    }

    if (inputData.get('password_confirmation') == '') {
        $('#confirmPsd').text('Please Enter confirm password');
        return false;
    }else{
        $('#confirmPsd').text('');
    }

    return true;
}

</script>
@endsection
