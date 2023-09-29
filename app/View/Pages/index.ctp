<div class="col-md-12 px-0">
    <div class="card border-0">
        <div class="card-header d-flex justify-content-end align-items-center bg-white">
            <button type="button" id="new-message" class="btn btn-primary">
                New Message
            </button>
        </div>
        <div class="card-body">
            <div class="d-flex flex-row mx-2 p-2">
                <div class="media h-100">
                    <?php echo $this->Html->image('avatars/profile_default.png', 
                                array(
                                    'fullBase' => true, 
                                    'alt' => 'Img', 
                                    'class' => 'img-fluid mr-2',
                                    'width' => '10%')); ?>
                    <div class="media-body align-self-center">
                        <h5 class="mt-0">Media heading</h5>
                        <p>Will you do the same for me? It's time to face the music I'm no longer your muse. Heard it's beautiful, be the judge and my girls gonna take a vote. I can feel a phoenix inside of me. Heaven is jealous of our love, angels are crying from up above. Yeah, you take me to utopia.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
</div>