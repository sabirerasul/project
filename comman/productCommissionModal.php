<!-- Modal -->
<div class="modal modal-lg fade" id="productCommisionM" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Advance Product Commission Setting %</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./inc/service-provider/commission-save.php" method="post" id="saveCommission2" name="productCommission">
        <div class="modal-body">
          <?php include('./form/advance-product-commission-form.php') ?>
          <div class="notes">
            <p><i class="fa fa-hand-o-right" aria-hidden="true"></i>Important Notes:</p>
            <ol>
              <li>* All fields are required.</li>
              <li>* From price of Next rows must be 1 number greater then the previous row.<br><strong>
                  Row1 =&gt; From: 0.00 - To: 100000.00<br>
                  Row2 =&gt; From: 100001.00 To: 1500000.00</strong>
              </li>
            </ol>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> <i class="fas fa-times"></i> Close</button>
          <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
        </div>
      </form>
    </div>
  </div>
</div>