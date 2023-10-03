<div class="col-md-12">
    <div class="card p-5 mx-auto border-0 w-50" id="profile-card">
        <div class="card-body">
            <div class="d-flex justify-content-between flex-row">
                <?php echo $this->Html->image($user['photo'] ?? 'avatars/profile_default.png', 
                                            array(
                                                'fullBase' => true, 
                                                'alt' => 'Img', 
                                                'class' => 'img-fluid',
                                                'width' => '40%')); ?>
                <div class="d-flex flex-column">
                    <h4 class="h4 mb-4"><?= $user['name']; ?></h4>
                    <span>Gender: <?= $user['gender'] ?? 'unset'; ?></span>
                    <span>Birthdate: <?= $user['birthdate'] ?? 'unset'; ?></span>
                    <span>Joined: <?= $user['created_at'] ?? 'unset'; ?></span>
                    <span>Last Login: <?= $user['last_login'] ?? 'unset'; ?></span>
                </div>
            </div>
            <div class="d-flex justify-content-center flex-column mt-4">
                <h6 class="h6">Bio:</h6>
                <p><?= $user['description'] ?? 'No profile description available.'; ?></p>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="<?php echo Router::url('/profile/edit') ?>" class="btn btn-primary" id="edit_profile">Edit Profile</a>
            </div>
        </div>
    </div>
</div>