<!DOCTYPE html>
<html>

<body>
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            <!--Page wrapper-->
            <div class="wrapper wrapper-content">             
                <div class="row">
                    <div id="add" class="col-md-6 col-md-offset-3">
                        <div class="sidebar">
                            <div class="widget">
                                <?php echo form_open_multipart("Ad/insertCabang"); ?>
                                <div class="form-group">
                                    <input type="text" name='nama' class="form-control" id="name" placeholder="Enter Nama">
                                </div>
                                <div class="alamat">
                                    <input type="text" name='alamat' class="form-control" id="name" placeholder="Enter Alamat">
                                </div>
                                <div class="form-group">
                                    <textarea name="desk" id="inputdeskripsi" class="form-control" rows="3" required="required"></textarea>
                                </div>                                                                                     
                                <button type="submit" class="btn btn-danger">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                                <button id="closeAdd" class="btn btn-default">close</button>
                                <?php echo form_close(); ?>
                            </div> <!-- widget end -->
                        </div> <!-- sidebar end -->
                    </div> <!-- kolom 8 end -->

                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Daftar Menu</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <button id="addButton" type="button" class="btn btn-md btn-info"><span class='glyphicon glyphicon-plus'></span>Tambah Cabang</button>
                                <table id="example3" class="table table-striped table-bordered tabelKomentar">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Deskripsi</th>                                         
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $u = base_url();
                                        foreach ($cabang as $c) {
                                            echo "<tr>
                                            <td>$c->nama</td>																				
											<td>$c->alamat</td>
											<td>$c->deskripsi</td>                                            
                                            ";
                                            echo "<td><a class='btn btn-primary btn-lg' href='$u/ad/getCabangById/$c->id'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a class='btn btn-danger btn-lg' onclick='hapus($c->id)' href='javascript:void(0)'><span class='glyphicon glyphicon-trash'></span></a>";
                                            echo "</td>
                                            </tr>";
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Alamat</th>
                                            <th>Deskripsi</th>                                           
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div id='form'></div>
                            </div>
                        </div>

                    </div> <!-- kolom 6 end -->
                </div> <!-- row end -->

            </div>
        </div>
        <!--Wrapper Content-->
    </div>
    <!--Wrapper-->

</body>
<script type="text/javascript">
    $(function() {
        $('#example3').dataTable();
    });
</script>
<script>
    function hapus(id) {
        swal({
                title: 'Konfirmasi?',
                text: "Apakah anda yakin ingin menghapus data ini!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                closeOnConfirm: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo site_url('Ad/deleteCabang') ?>/" + id,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data) {
                            if (data.status) //if success close modal and reload ajax table
                            {

                                swal({
                                    title: "Data Berhasil dihapus",
                                    type: "success",
                                });
                                window.location.reload();
                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error adding / update data');
                        }
                    });
                }
            });
    }
    
</script>
<script>
    $(document).ready(function() {
        $("#add").hide(1000);
        $("#addButton").click(function() {
            $("#add").show(1000);
        });
        $("#closeAdd").click(function() {
            $("#add").hide(1000);
        });
    });
</script>
<script src="<?php echo base_url(); ?>assetadmin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assetadmin/js/dataTables.bootstrap.js"></script>

</html>