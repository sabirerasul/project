<form action="./inc/feedback/feedback-add.php" method="post" id="addFeedbackForm">
    <div class="row mt-5">


        <div class="col-md-4">
            <div class="mb-3">
                <label for="invoice_number" class="required form-label invoice_number_label">Enter Invoice Number </label>
                <input type="text" class="form-control invoice_number" id="invoice_number" name="invoice_number" placeholder="Invoice Number" onchange="check_invoice(this)">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="name" class="name_label required form-label">Your Name </label>
                <input type="text" class="form-control name" id="name" name="name" placeholder="Enter Your Name">
                <div class="showErr"></div>
                <input type="hidden" class="client_id" name="client_id" value="0">
                <input type="hidden" class="branch_id" name="branch_id" value="0">
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="email" class="email_label required form-label">Email</label>
                <input type="email" class="form-control email" id="email" name="email" placeholder="Enter Your Email">
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="overall_experience" class="overall_experience_label required form-label">Overall Experience</label>
                <div class="" id="overall_experience">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="overall_experience" id="overall_experience1" checked value="Very Good">
                        <label class="form-check-label" for="overall_experience1">Very Good</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="overall_experience" id="overall_experience2" value="Good">
                        <label class="form-check-label" for="overall_experience2">Good</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="overall_experience" id="overall_experience3" value="Fair">
                        <label class="form-check-label" for="overall_experience3">Fair</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="overall_experience" id="overall_experience4" value="Poor">
                        <label class="form-check-label" for="overall_experience4">Poor</label>
                    </div>
                </div>
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="timely_response" class="timely_response_label required form-label">Timely Response</label>
                <div class="" id="timely_response">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="timely_response" id="timely_response1" checked value="Very Good">
                        <label class="form-check-label" for="timely_response1">Very Good</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="timely_response" id="timely_response2" value="Good">
                        <label class="form-check-label" for="timely_response2">Good</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="timely_response" id="timely_response3" value="Fair">
                        <label class="form-check-label" for="timely_response3">Fair</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="timely_response" id="timely_response4" value="Poor">
                        <label class="form-check-label" for="timely_response4">Poor</label>
                    </div>
                </div>
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="our_support" class="our_support_label required form-label">Our Support</label>
                <div class="" id="our_support">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="our_support" id="our_support1" checked value="Very Good">
                        <label class="form-check-label" for="our_support1">Very Good</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="our_support" id="our_support2" value="Good">
                        <label class="form-check-label" for="our_support2">Good</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="our_support" id="our_support3" value="Fair">
                        <label class="form-check-label" for="our_support3">Fair</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="our_support" id="our_support4" value="Poor">
                        <label class="form-check-label" for="our_support4">Poor</label>
                    </div>
                </div>
                <div class="showErr"></div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="mb-3">
                <label for="overall_satisfaction" class="overall_satisfaction_label required form-label">Overall Satisfaction</label>
                <div class="" id="overall_satisfaction">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="overall_satisfaction" id="overall_satisfaction1" checked value="Very Good">
                        <label class="form-check-label" for="overall_satisfaction1">Very Good</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="overall_satisfaction" id="overall_satisfaction2" value="Good">
                        <label class="form-check-label" for="overall_satisfaction2">Good</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="overall_satisfaction" id="overall_satisfaction3" value="Fair">
                        <label class="form-check-label" for="overall_satisfaction3">Fair</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="overall_satisfaction" id="overall_satisfaction4" value="Poor">
                        <label class="form-check-label" for="overall_satisfaction4">Poor</label>
                    </div>
                </div>
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="rating" class="rating_label required form-label">Want to rate with us for customer services?</label>
                <div id="rating">
                    <div class="form-radio form-radio-inline">
                        <input id="rating5" type="radio" name="rating" value="5" checked="">
                        <label for="rating5">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </label>
                    </div>
                    <div class="form-radio form-radio-inline">
                        <input id="rating4" type="radio" name="rating" value="4">
                        <label for="rating4">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </label>
                    </div>
                    <div class="form-radio form-radio-inline">
                        <input id="rating3" type="radio" name="rating" value="3">
                        <label for="rating3">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </label>
                    </div>
                    <div class="form-radio form-radio-inline">
                        <input id="rating2" type="radio" name="rating" value="2">
                        <label for="rating2">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </label>
                    </div>
                    <div class="form-radio form-radio-inline">
                        <input id="rating1" type="radio" name="rating" value="1">
                        <label for="rating1">
                            <i class="fa fa-star"></i>
                        </label>
                    </div>
                </div>
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-6">
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="review" class="review_label required form-label">Your Valuable Feedback</label>
                <textarea name="review" class="form-control review" id="review"></textarea>
                <div class="showErr"></div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="mb-3">
                <label for="suggestion" class="suggestion_label required form-label">Is there anything you would like to tell us?</label>
                <textarea id="suggestion" class="form-control suggestion" name="suggestion"></textarea>
                <div class="showErr"></div>
            </div>
        </div>

        <div class="col-md-12 d-flex justify-content-center my-5">
            <div class="form-group">
                <a href="./index" class="btn btn-danger"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back</a>
                <button type="submit" name="staff_submit" class="btn btn-success"> <i class="fa fa-plus" aria-hidden="true"></i> Submit </button>
            </div>
        </div>

    </div>
</form>