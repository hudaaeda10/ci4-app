<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h4 class="mt-4">Detail Comic</h4>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/img/<?= $comic['cover']; ?>" class="card-img">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Title Comic : <?= $comic['title']; ?></h5>
                            <p class="card-text"><b> Author Comic : <?= $comic['author']; ?></b></p>
                            <p class="card-text"><small class="text-muted"><b>Publisher : <?= $comic['publisher']; ?></b></small></p>
                            <a href="/comics/edit/<?= $comic['slug']; ?>" class="btn btn-warning">Edit</a>

                            <form action="/comics/<?= $comic['id']; ?>" method="POST" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">Delete</button>
                            </form>
                            <br><br>
                            <a href="/comics" class="btn btn-primary">Back To List Comic</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>