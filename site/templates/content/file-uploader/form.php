<form action="<?= $page->fullURL->getUrl(); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="filename">File Name</label>
                    <input type="text" class="form-control input-sm" name="filename">
                    <p class="help-block">Leave blank if you do not need to change file name.</p>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="">Choose File</label>
                <input type="file" name="file">
            </div>
            <div class="col-sm-4">
                <label for="">Save as</label>
                <select class="form-control input-sm" name="file-extension">
                    <option value="txt">txt</option>
                    <?php foreach (FileUploader::$allowed_extensions as $extension) : ?>
                        <option value="<?= $extension; ?>"><?= $extension; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success">Upload</button>
</form>
