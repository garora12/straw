<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
</head>
<body>
    
    <div class="col-md-6 offset-md-3">
        <span class="anchor" id="formChangePassword"></span>
        <hr class="mb-5">

        <!-- form card change password -->
        <div class="card card-outline-secondary">
            <div class="card-header">
                <h3 class="mb-0">Change Password</h3>
            </div>
            <div class="card-body">
                <form class="form" role="form" autocomplete="off" id="frm">
                    <div class="form-group">
                        <label for="inputPasswordNew">Email</label>
                        <input type="text" name="universityEmail" class="form-control" value="{{ $email }}" id="email" required="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputPasswordNew">New Password</label>
                        <input type="password" name="password" class="form-control" id="password" required="">
                        <!-- <span class="form-text small text-muted">
                            The password must be 8-20 characters, and must <em>not</em> contain spaces.
                        </span> -->
                    </div>
                    <div class="form-group">
                        <label for="inputPasswordOld">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" required="">
                    </div>
                    <div class="form-group">
                        <button type="button" id="btnSbt" class="btn btn-success btn-lg float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /form card change password -->
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        $( '#btnSbt' ).on( 'click', function() {

            var pwd = $('#password').val();
            var cnfpwd = $('#confirmPassword').val();

            if( pwd.length < 6 ) {

                alert('Password must be atleast 6 characters!');
                return;
            }

            if( cnfpwd.length < 6 ) {

                alert('Confirm Password must be atleast 6 characters!');
                return;
            }

            if( pwd != cnfpwd ) {

                alert( 'Password and confirm password does not matched!' );
                return;
            }

            $.ajax({
                url: '/straw-app/resetPassword',
                method: 'POST',
                dataType: 'JSON',
                data: $('#frm').serialize(),
                success: function( retdata ) {
                    if( retdata.errorArr.length > 0 ) {
                        // alert("Unable to reset password!");
                        alert(retdata.errorArr);
                    } else {
                        alert("Password reset successfully!");
                    }
                },
                error: function(e){
                    console.log(e);
                }
            });
        } );
    </script>
</body>
</html>