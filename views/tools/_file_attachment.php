<?php if (in_array($file->file_type, ['jpg', 'jpeg', 'png', 'gif'])): ?>


    <div class="thumbnail">

        <img src="<?= $file->getType()->path ?><?= $file->name ?>" alt="">

    </div>

<?php else: ?>

    <?php if ($file->file_type === "pdf"): ?>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="thumbnail">
                <div class="thumb" style="overflow: hidden">
                    <iframe src="<?= $file->getType()->path ?><?= $file->name ?>" alt="" style="border: 0px; overflow-y: hidden; width: 100%; height: 500px" frameBorder="0"></iframe>
                </div>
            </div>
        </div>

    <?php else: ?>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="thumbnail">
                <div class="thumb" style="overflow: hidden">
                    <i  class="glyphicon glyphicon-file"style="height: 400px; font-size: 20em"></i>

                    <div class="caption-overflow">

                        <span>
                            <a href="<?= $file->getType()->path ?><?= $file->name ?>" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded" target="blank"><i class="icon-image2"></i></a>
                        </span>
                        <br>
                        <center>
                            <label style="text-align: center"><?= $file->name ?></label>
                        </center>
                        <br>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

<?php endif; ?>
