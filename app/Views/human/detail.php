<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h4 class="mt-4">Detail Human</h4>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md">
                        <div class="card-body">
                            <h5 class="card-title">Human Name : <?= $human['name']; ?></h5>
                            <p class="card-text"><b>Address : <?= $human['address']; ?></b></p>
                            <p class="card-text"><small class="text-muted"><b>Created At : <?= $human['created_at']; ?></b></small></p>
                            <a href="/human" class="btn btn-primary">Back To List Humans</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>