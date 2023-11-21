<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Client Form-->

            <form action="./inc/client/client-add.php" method="post" id="addClientForm">
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
                                <label for="client_name" class="required client_name">Client Name</label>
                                <input type="text" class="form-control" id="client_name" placeholder="Name" name="client_name">
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contact" class="required client_contact">Contact</label>
                                <input type="number" maxlength="10" class="form-control" id="contact" placeholder="Number" name="contact">
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlInput3">Date Of Birth</label>
                                <input type="text" class="form-control user-dob" id="exampleFormControlInput3" placeholder="dd/mm/yyyy" name="dob" autocomplete="off" readonly>
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlInput4">Anniversary</label>
                                <input type="text" class="form-control user-anniversary" id="exampleFormControlInput4" placeholder="dd/mm/yyyy" name="anniversary" autocomplete="off" readonly>
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gender" class="required" id="labelGender">Gender</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email" class="email-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email">
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Source Of Client</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="source_of_client">
                                    <option value="">Select</option>
                                    <option value="Client refrence">Client refrence</option>
                                    <option value="Cold Calling">Cold Calling</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Twitter">Twitter</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Other Social Media">Other Social Media</option>
                                    <option value="Website">Website</option>
                                    <option value="Walk-In">Walk-In</option>
                                    <option value="Flex">Flex</option>
                                    <option value="Flyer">Flyer</option>
                                    <option value="Newspaper">Newspaper</option>
                                    <option value="SMS">SMS</option>
                                    <option value="Street Hoardings">Street Hoardings</option>
                                    <option value="Event">Event</option>
                                    <option value="TV/Radio">TV/Radio</option>
                                </select>
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Address</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Address" name="address"></textarea>
                                <div class="showErr"></div>
                            </div>
                        </div>

                        <input type="hidden" name="branch_id" value="<?=BRANCHID?>">

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