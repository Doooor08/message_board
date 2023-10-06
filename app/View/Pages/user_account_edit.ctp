<div class="col-md-12">
    <div class="card p-4 mx-auto border-0 w-50">
        <div class="card-body d-flex justify-content-center p-0">
            <form id="account_form" enctype="multipart/form-data">
                <div class="d-flex justify-content-start mb-3">
                    <span class="text-danger mx-5 invisible" id="error_message">test error</span>
                </div>
                <div class="d-flex justify-content-end align-items-center flex-row my-2">
                    <label for="email" class="mx-3 mb-0">Email</label>
                    <input type="text" name="email" id="email" class="form-control col-10 w-100" value="<?= $userData['email'] ?>" placeholder="Enter new email" required>                
                </div>
                <div class="d-flex justify-content-end align-items-center flex-row my-2">
                    <label for="pass" class="mx-3 mb-0" style="text-align: end;">New Password</label>
                    <input type="password" name="pass" id="pass" class="form-control col-10 w-100" placeholder="Enter Password">
                </div>
                <div class="d-flex justify-content-end align-items-center flex-row my-2">
                    <label for="conf_pass" class="mx-3 mb-0" style="text-align: end;">Confirm Password</label>
                    <input type="password" name="confirm_pass" id="conf_pass" class="form-control col-10 w-100" placeholder="Re-type Password" disabled>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-3">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo $this->Html->script('profileValidation'); ?>