<div class="col-md-12">
    <div class="card p-5 mx-auto border-0" style="width:40%">
        <div class="card-body d-flex justify-content-center align-items-center flex-column">
            <form id="new-message" enctype="multipart/form-data">
                <label for="recipient">Recipient</label>
                <select class="form-control w-100" name="recipient" id="recipient"></select>
                <label for="message">Message</label>
                <textarea name="message" class="form-control w-100" id="message" cols="30" rows="10"></textarea>
                <button>Submit</button>
            </form>
        </div>
    </div>
</div>
<?php echo $this->Html->script('messageValidation'); ?>