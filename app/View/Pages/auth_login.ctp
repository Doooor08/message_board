<div class="col-md-12">
    <div class="card p-5 mx-auto" style="width:40%">
        <div class="card-header border-0 bg-white">
            <h3 class="text-center">Login</h3>
        </div>
        <div class="card-body d-flex justify-content-center">
            <form id="auth_login" enctype="multipart/form-data">
                <div class="d-flex justify-content-start mb-3">
                    <span class="text-danger mx-5 invisible" id="error_message">test error</span>
                </div>
                <div class="d-flex justify-content-end align-items-center flex-row my-2">
                    <label for="email" class="mx-3 mb-0">Email</label>
                    <input type="email" name="email" id="email" class="form-control col-10 w-100" placeholder="Enter Email Address" required>
                </div>
                <div class="d-flex justify-content-end align-items-center flex-row my-2">
                    <label for="pass" class="mx-3 mb-0">Password</label>
                    <input type="password" name="pass" id="pass" class="form-control col-10 w-100" placeholder="Enter Password" required>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Log in</button>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <span>Don't have an account? <a href="<?php echo Router::url('/register');?>">Sign up</a></span>
                </div>
            </form>
        </div>
    </div>
</div>