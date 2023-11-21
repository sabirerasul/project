<div class="sidebar-button-wrapper">
    <a class="" href="#" data-bs-toggle="modal" data-bs-target="#quick_billing_modal">
        <i class="fa fa-file-invoice"></i>
    </a>

    <a class="" href="./mark-attendance.php">
        <i class="fa fa-calendar-check"></i>
    </a>
</div>

<style>
    .sidebar-button-wrapper {
        position: fixed;
        top: 0;
        z-index: 99;
        top: 50%;
        right: 1%;
        transform: translateY(-50%);
    }

    .sidebar-button-wrapper a {
        margin: 5px;
    }

    .sidebar-button-wrapper .fa {
        font-size: 30px;
        width: 60px;
        height: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
        border: 2px solid #025043;
    }

    .sidebar-button-wrapper .fa:hover {
        background-color: #025043;
    }

    .sidebar-button-wrapper .fa-file-invoice {
        background: #198754;
        color: white;
    }

    .sidebar-button-wrapper .fa-calendar-check {
        background: #198754;
        color: white;
    }
</style>