<!-- Modal -->
<div class="modal modal-lg fade" id="servicesM" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Select Services</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php include('./form/assign-service-form.php')?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> <i class="fas fa-times"></i> Close</button>
        <button type="button" class="btn btn-success" onclick="saveAssignServices()" id="save_service_btn"><i class="fas fa-save"></i> Save</button>
      </div>
    </div>
  </div>
</div>