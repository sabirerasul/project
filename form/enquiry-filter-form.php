<form action="" method="POST" id="filterEnquiry">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="filterfollowdate" class="filterfollowdate_label required">Date To Follow</label>
                <input type="text" class="form-control filterfollowdate" name="filterfollowdate" value="Select date" id="filterfollowdate">
            </div>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 enq-for-wrapper">
            <div class="form-group">
                <label for="filterenquiry_for_title" class="filterenquiry_for_title_label required">Enquiry For</label>
                <input type="text" class="form-control filterenquiry_for_title" id="filterenquiry_for_title" placeholder="Services / Products / Packages / Membership" value="">
                <input type="hidden" class="filterenquiry_for" id="filterenquiry_for" name="filterenquiry_for" value="">
                <input type="hidden" class="filterenquiry_table_type" id="filterenquiry_table_type" name="filterenquiry_table_type" value="">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="filterleaduser" class="filterleaduser_label">Lead Representative</label>
                <select class="form-select filterleaduser" name="filterleaduser" id="filterleaduser">
                    <option value="">Select</option>
                    <option value="1">Admin</option>
                    <?php
                    foreach ($leadUserArr as $leadUserKey => $leadUserValue) {
                    ?>
                        <option value="<?= $leadUserValue['id'] ?>"><?= $leadUserValue['name'] ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="filterenquiry_type" class="filterenquiry_type_label required">Enquiry Type</label>
                <select class="form-select filterenquiry_type" name="filterenquiry_type" id="filterenquiry_type">
                    <option value="">Select</option>
                    <?php
                    foreach ($enquiryTypeArr as $enquiryTypeKey => $enquiryTypeValue) {
                    ?>
                        <option value="<?= $enquiryTypeKey ?>"><?= $enquiryTypeValue ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="filtersource_of_enquiry" class="filtersource_of_enquiry_label required">Source Of Enquiry</label>
                <select class="form-select filtersource_of_enquiry" name="filtersource_of_enquiry" id="filtersource_of_enquiry">
                    <option value="">Select</option>
                    <?php
                    foreach ($enquirySourceArr as $enquirySourceArrKey => $enquirySourceArrValue) {
                    ?>
                        <option value="<?= $enquirySourceArrKey ?>"><?= $enquirySourceArrValue ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="d-flex justify-content-between">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" name="filter" value="mfilter" class="btn btn-filter btn-block btn-primary"><i class="fa fa-filter" aria-hidden="true"></i> Apply </button>
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <a href="enquiry.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear</a>
                </div>
            </div>
        </div>
    </div>
</form>