<div class="row">
    <div class="col-lg-12">
        <label><input type="checkbox" id="checkAll"> Select All</label>
    </div>
    <?php
    $serviceModel = fetch_all($db, "SELECT * FROM service WHERE status='1'");
    foreach ($serviceModel as $key => $val) {
        $value = (object) $val;

        $assignServiceResult = mysqli_query($db, "SELECT id FROM service_provider_assign_services WHERE sp_id='".$editid."' AND s_id='".$value->id."'");
        $assignService11 = mysqli_num_rows($assignServiceResult);
        $checked = $assignService11 ? 'checked' : '';
        
    ?>
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-2">
        <!-- checked="" -->
            <label class="service-label"><input type="checkbox" <?=$checked?> class="provider_service" value="<?=$value->id?>"> <?=$value->service_name?> </label>
        </div>
    <?php } ?>
</div>