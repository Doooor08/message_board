<div class="col-md-12 px-0">
    <div class="card border-0" style="height: 80vh;">
        <div class="card-header d-flex justify-content-end align-items-center bg-white">
            <a href="<?php echo Router::url('/compose');?>" class="btn btn-primary">New Message</a>
        </div>
        <div class="card-body mh-100">
            <div class="row">
                <div class="col-md-4 border-right mh-100">
                    <ul class="mb-0 p-0" id="convo-container">
                        <!-- messageValidation.js appends message tabs here -->
                        <!-- <li class="message-head">
                            <div class="d-flex flex-row border-bottom border-dark">
                                <div class="user-icon p-2">
                                <?php echo $this->Html->image('avatars/profile_default.png', 
                                        array(
                                            'fullBase' => true, 
                                            'alt' => 'Img', 
                                            'class' => 'img-fluid',
                                            'width' => '120')); ?>
                                </div>
                                <div class="d-flex justify-content-start flex-column mx-2 my-auto flex-fill">
                                    <h5 class="h5">Not Joey</h5>
                                    <p class="mb-1">Hello Admin!</p>
                                    <div class="d-flex justify-content-end align-self-stretch mx-2 my-1">
                                        <span class="align-self-end">2023-10-05 11:47:43</span>
                                    </div>
                                </div>
                            </div>
                        </li> -->
                    </ul>
                </div>
                <div class="col-md-8">
                    <ul class="mb-0 p-0" id="message-container"></ul>
                </div>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
</div>
<?php echo $this->Html->script('messageValidation'); ?>