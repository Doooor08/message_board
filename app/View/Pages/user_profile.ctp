<!-- <?php echo json_encode($userData)?> -->
<div class="col-md-12">
    <div class="card p-5 mx-auto border-0 w-50" id="profile-card">
        <div class="card-body">
            <div class="d-flex justify-content-between flex-row">
                <?php $img = $userData['photo'] ?? 'profile_default.png'; ?>
                <?php echo $this->Html->image('avatars/'.$img, 
                                            array(
                                                'fullBase' => true, 
                                                'alt' => 'Img', 
                                                'class' => 'img-fluid',
                                                'width' => '40%')); ?>
                <div class="d-flex flex-column">
                    <h4 class="h4 mb-4"><?= $userData['name']; ?></h4>
                    <span>Gender: <?= $userData['gender'] ?? 'unset'; ?></span>
                    <span>Birthdate: <?= $userData['birthdate'] ?? 'unset'; ?></span>
                    <span>Joined: <?= $userData['created_at'] ?? 'unset'; ?></span>
                    <span>Last Login: <?= $userData['last_login'] ?? 'unset'; ?></span>
                </div>
            </div>
            <div class="d-flex justify-content-center flex-column mt-4">
                <h6 class="h6">Bio:</h6>
                <p><?= $userData['description'] ?? 'No profile description available.'; ?></p>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="<?php echo Router::url('/profile/edit') ?>" class="btn btn-primary" id="edit_profile">Edit Profile</a>
            </div>
        </div>
    </div>
</div>