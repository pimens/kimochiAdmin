<!DOCTYPE html>
<html>
<?php
$id;
$info;
$judul;
foreach ($promo as $c) {
    $id = $c->id;
    $judul = $c->judul;
    $info = $c->deskripsi;   

} ?>

<body>
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            <!--Page wrapper-->
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div id="add" class="col-md-6 col-md-offset-3">
                        <div class="sidebar">
                            <div class="widget">
                                <?php echo form_open_multipart("Ad/editPromo"); ?>
                                <div class="form-group">
                                    <input type="text" name='judul' value="<?php echo $judul; ?>" class="form-control" id="name" placeholder="Enter Judul">
                                </div>                               
                                <div class="form-group">
                                    <textarea name="desk" value="<?php echo $info; ?>" id="inputdeskripsi" class="form-control" rows="3" required="required"><?php echo $info; ?></textarea>
                                </div>                                
                                <div class="form-group">
                                    <input class="form-control" type="file" name="thumb">
                                </div>                               
                                <input type="hidden" value="<?php echo $id; ?>" name="id" />                                                         
                                <button type="submit" class="btn btn-danger">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                                <button id="closeAdd" class="btn btn-default">close</button>

                                <?php echo form_close(); ?>

                            </div> <!-- widget end -->
                        </div> <!-- sidebar end -->
                    </div> <!-- kolom 8 end -->                   
                </div> <!-- row end -->

            </div>
        </div>
        <!--Wrapper Content-->
    </div>
    <!--Wrapper-->

</body>
<script src="<?php echo base_url(); ?>assetadmin/js/dataTables.bootstrap.js"></script>
</html>