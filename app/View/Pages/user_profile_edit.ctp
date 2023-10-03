<div class="col-md-12">
    <div class="card p-5 mx-auto border-0 w-50">
        <div class="card-body d-flex justify-content-center">
            <form id="profile_form" enctype="multipart/form-data">
                <div class="d-flex justify-content-start align-items-center flex-row">
                    <input 
                        type="file" 
                        name="photo" 
                        id="imageInput" 
                        class="invisible d-none" 
                        accept="image/png, image/jpeg, image/gif" 
                        required
                    >
                    <?php echo $this->Html->image('avatars/'.$userData['photo'] ?? 'avatars/profile_default.png', 
                                                array(
                                                    'fullBase' => true, 
                                                    'alt' => 'Img', 
                                                    'id' => 'imagePreview',
                                                    'class' => 'img-fluid',
                                                    'width' => '40%')); ?>
                    <div class="d-flex flex-column mx-auto">
                        <button type="button" class="btn bg-light" id="profileUpload">Upload Pic</button>
                    </div>
                </div>
                <div class="d-flex justify-content-end align-items-center flex-row my-3">
                    <label for="name" class="mx-3 mb-0">Name</label>
                    <input type="text" name="name" id="name" class="form-control col-10 w-100" value="<?= $userData['name'] ?>" placeholder="Enter your name" required>                
                </div>
                <div class="d-flex justify-content-end align-items-center flex-row my-3">
                    <label for="birthdate"class="mx-3 mb-0">Birthdate</label>
                    <input type="text" name="birthdate" id="birthdate" class="form-control col-10 w-100" value="<?= $userData['birthdate'] ?>" placeholder="MM/DD/YYYY" required>
                </div>
                <div class="d-flex justify-content-start align-items-center flex-row my-3">
                    <label for="gender" class="mr-4 mb-0">Gender</label>
                    <div class="form-check mr-3">
                        <input 
                            type="radio" 
                            name="gender" 
                            id="male" 
                            class="form-check-input" 
                            value="male" 
                            <?php echo ($userData['gender'] === 'Male') ? 'checked' : ''; ?>
                            required
                        >
                        <label for="male" class="form-check-label mx-1 mb-0">Male</label>
                    </div>
                    <div class="form-check">
                        <input 
                            type="radio" 
                            name="gender" 
                            id="female" 
                            class="form-check-input" 
                            value="female" 
                            <?php echo ($userData['gender'] === 'Female') ? 'checked' : ''; ?>
                            required
                        >
                        <label for="female" class="form-check-label mx-1 mb-0">Female</label>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-start flex-row my-3">
                    <label for="description" class="mr-3 mb-0 flex-shrink">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5"><?= $userData['description'] ?></textarea>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-3">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo $this->Html->script('profileValidation'); ?>