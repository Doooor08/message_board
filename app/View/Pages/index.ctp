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
                <div class="col-md-8 d-flex justify-content-between flex-column" style="height: 65vh !important;">
                    <ul class="mb-0 p-0 overflow-auto" id="message-container"></ul>
                    <div class="d-flex align-items-end mt-3" id="reply-container">
                        <!-- <form id="message-reply" enctype="multipart/form-data">
                            <div class="d-flex justify-content-end">
                                <input type="hidden" name="msg_id" value="">
                                <textarea name="reply" id="reply" cols="85" rows="2" class="form-control"></textarea>
                                <div class="d-flex align-items-start">
                                    <button type="submit" class="btn btn-primary ml-1">Reply</button>
                                </div>
                            </div>
                        </form> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
</div>
<?php echo $this->Html->script('messageValidation'); ?>