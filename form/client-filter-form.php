<form action="" method="POST" id="filterForm">

    <div class="row">
        <!-- <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">Client Id</label>
                                    <input type="number" class="form-control" name="uid" value="" min="0">
                                </div>
                            </div> -->
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="">Client Name</label>
                <input type="text" class="form-control" name="name" value="">
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="">Contact Number</label>
                <input type="number" maxlength="10" class="form-control" name="number" value="" min="0">
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" value="">
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="">Source</label>
                <select class="form-control" name="source">
                    <option value="">-- Select--</option>
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
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="">Assigned To</label>
                <select class="form-control" name="spname">
                    <option value="">-- Select--</option>
                    <option value="5">Anita</option>
                    <option value="4">Deepu</option>
                    <option value="8">Mudassir</option>
                    <option value="3">Neha</option>
                    <option value="2">Rahul</option>
                    <option value="1">Ranjeet</option>
                    <option value="6">Riya</option>
                    <option value="7">Yash</option>
                </select>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="">Service</label>
                <input type="text" class="ser form-control ui-autocomplete-input" name="sname" value=""
                    autocomplete="off">
                <input type="hidden" class="serr" name="sid" value="">
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="">Gender</label>
                <select class="form-control" name="gender">
                    <option value="">-- Select--</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>&nbsp;</label>
                <button type="submit" name="filter" value="mfilter" class="btn btn-filter btn-block btn-primary"><i
                        class="fa fa-filter" aria-hidden="true"></i> Filter </button>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>&nbsp;</label>
                <a href="client.php" class="btn btn-danger d-block"><i class="fa fa-times" aria-hidden="true"></i> Clear
                </a>
            </div>
        </div>
    </div>
</form>