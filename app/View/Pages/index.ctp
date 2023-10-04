<div class="col-md-12 px-0">
    <div class="card border-0">
        <div class="card-header d-flex justify-content-end align-items-center bg-white">
            <a href="<?php echo Router::url('/compose');?>" class="btn btn-primary">New Message</a>
        </div>
        <div class="card-body" id="message-container">
            <div class="d-flex flex-row border-bottom border-dark message-head">
                <div class="user-icon p-2">
                <?php echo $this->Html->image('avatars/profile_default.png', 
                                array(
                                    'fullBase' => true, 
                                    'alt' => 'Img', 
                                    'class' => 'img-fluid',
                                    'width' => '120')); ?>
                </div>
                <div class="d-flex justify-content-start flex-column mx-2">
                    <h5 class="h5">User Name</h5>
                    <p class="mb-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                             Sit molestias numquam corporis quidem repellat recusandae reprehenderit sint aspernatur ex inventore eos 
                             soluta odio repellendus, dolores nostrum vero, consequatur quaerat obcaecati.</p>
                    <div class="d-flex justify-content-end mx-2 my-1">
                        <span class="align-self-end">Date</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
</div>
<?php echo $this->Html->script('messageValidation'); ?>