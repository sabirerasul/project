<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Self Assessment Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Client Form-->

            <form action="./inc/self-assessment-data/self-assessment-data-add.php" method="post" id="addStaffForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible fade show server-error" role="alert" style="display: none;">
                                <strong>Error!</strong> <span id="error-message"></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="required label_name">Name</label>
                                <input type="text" class="form-control name" id="name" placeholder="Name" name="name">
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email" class="required label_email">Email</label>
                                <input type="email" class="form-control email" id="email" placeholder="name@example.com" name="email">
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mobile" class="required label_mobile">Contact</label>
                                <input type="number" maxlength="10" class="form-control mobile" id="mobile" placeholder="Mobile Number" name="mobile">
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address" class="required label_address">Address</label>
                                <textarea class="form-control address" id="address" rows="3" placeholder="Address" name="address"></textarea>
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="affected_countries_last" class="required label_affected_countries_last">Have you been to one of the COVID-19 affected countries in the last 14 days?</label>
                                <select class="form-control affected_countries_last" id="affected_countries_last" name="affected_countries_last">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No" selected>No</option>
                                </select>
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="confirmed_case_coronavirus" class="required label_confirmed_case_coronavirus">Have you been in close contact with a confirmed case of coronavirus?</label>
                                <select class="form-control confirmed_case_coronavirus" id="confirmed_case_coronavirus" name="confirmed_case_coronavirus">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No" selected>No</option>
                                </select>
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="experiencing_symptoms" class="required label_experiencing_symptoms">Are you currently experiencing symptoms (cough, shortness of breath, fever)</label>
                                <select class="form-control experiencing_symptoms" id="experiencing_symptoms" name="experiencing_symptoms">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No" selected>No</option>
                                </select>
                                <div class="showErr"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success add-new-client" name="client_submit">Save</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" id="clientModalClose">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
    @media (min-width: 992px) {

        .modal-lg,
        .modal-xl {
            max-width: 950px;
        }
    }
</style>