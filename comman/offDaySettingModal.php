<?php

$weekArr = [
  'Monday',
  'Tuesday',
  'Wednesday',
  'Thursday',
  'Friday',
  'Saturday',
  'Sunday'
];

$offWeekDayQuery = mysqli_query($db, "SELECT day FROM service_provider_off_week_day WHERE sp_id='".$editid."'");
$holidaysQuery = mysqli_query($db, "SELECT * FROM service_provider_holiday WHERE sp_id='".$editid."'");
$offWeekDayModels = mysqli_fetch_all($offWeekDayQuery, MYSQLI_ASSOC);
$holidaysModels = mysqli_fetch_all($holidaysQuery, MYSQLI_ASSOC);
$oldWeekDay = array_column($offWeekDayModels, 'day');

?>

<!-- Modal -->
<div class="modal modal-lg fade" id="offDaySettingM" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Off Days Setting</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-3">
            <h5>Week Days</h5>
            <ul>
              <?php foreach ($weekArr as $weekKey => $weekValue) { ?>
                <li><label><input type="checkbox" <?=(in_array($weekValue, $oldWeekDay) ? 'checked':'')?> name="day" value="<?=$weekValue?>" class="day" onclick="save_off_days()"> &nbsp;<?=$weekValue?> </label></li>
              <?php } ?>
              <ul>
              </ul>
            </ul>
          </div>
          <div class="col-lg-9" style="border-left: 1px solid #ccc;">
            <h5>Holidays</h5>
            <div class="row">
              <div class="form-group col-md-2">
                <label style="margin-top: 10px;">Select Dates</label>
              </div>
              <div class="form-group col-lg-5">
                <input type="text" class="form-control" name="daterange" value="Select date" id="off_date">
              </div>
              <div class="form-group col-md-5">
                <button type="button" data-attr="submit" class="btn btn-success" id="save_off_days_btn" onclick="save_off_dates()"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 table-responsive">

                <table class="table table-bordered display" id="offSettingDataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="table-data offsetting-table-data">

                    <?php
                    
                    foreach ($holidaysModels as $holidaysKey => $holidayValues) { ?>
                    <?php $holidayValue = (object) $holidayValues; ?>
                    <tr>
                      <td class="counterCell"></td>
                      <td><?=$holidayValue->date?></td>
                      <td><button onclick="removeHoliday(<?=$holidayValue->id?>)" type="button" class="btn btn-xs btn-danger"><span style="font-size: 16px;" class="icon-delete"></span> Delete</button></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> <i class="fas fa-times"></i> Close</button>
        <button type="button" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    $('input[name="daterange"]').daterangepicker({
      opens: 'left'
    }, function(start, end, label) {
      console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

    dataTableLoad2();
  })
</script>