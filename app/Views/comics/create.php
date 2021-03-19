<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h4 class="my-3">Create New Comic</h4>
            <form action="/comics/save" method="post">
                <?= csrf_field(); ?>
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('title')) ? 'is-invalid' : ''; ?>" id="title" name="title" value="<?= old('title'); ?>" autofocus>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('title'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="author" class="col-sm-2 col-form-label">Author</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('author')) ? 'is-invalid' : ''; ?>" id="author" name="author" value="<?= old('author'); ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('author'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="publisher" class="col-sm-2 col-form-label">Publisher</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('publisher')) ? 'is-invalid' : ''; ?>" id="publisher" name="publisher" value="<?= old('publisher'); ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('publisher'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cover" class="col-sm-2 col-form-label">Cover</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="cover" name="cover" value="<?= old('cover'); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Add Comic</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>