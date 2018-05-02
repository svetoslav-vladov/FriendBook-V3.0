<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Share photos</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <div class="custom-file">
                    <form id="share-photos-form" action="<?php echo URL_ROOT; ?>/post/sharePhoto" method="post" enctype="multipart/form-data">
                        <input type="file" name="multi-image[]" multiple="multiple" accept="image/*" class="custom-file-input" id="validatedCustomFile">
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        <input class="btn btn-success" type="submit" name="share-photos" value="share">
                    </form>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>