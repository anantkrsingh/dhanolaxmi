<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
                <table id="datatable" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Banner</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0;
                            foreach ($Allbanner as $key => $banner) {
                            $i++; 
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><img src="<?= base_url(BANNER_URL.$banner->banner) ?>" height="50" width="50" ></td>
                            <td>
                                <a href="<?= base_url('backend/AppBanner/delete/'.$banner->id) ?>" onclick="return confirm('Are You Sure Want To Remove This Image?')" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><span class="fa fa-trash"></span></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>