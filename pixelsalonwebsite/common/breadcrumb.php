<?php
$pageName = basename($_SERVER['SCRIPT_NAME']);
$pageName = str_replace('.php', '', $pageName);
$pageName = str_replace('-', ' ', $pageName);
$pageName = strtoupper($pageName);
?>
<section id="breadcrumb" class="py-3">
    <div class="container">

        <div class="row">
            <div class="col-md-12 d-flex justify-content-between">
                <a class="btn btn-primary" href="./index"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                <a class="btn btn-primary" href="./index"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </div>
            <div class="col-md-12 my-3">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item text-weight-bold"><a href="./index">HOME</a></li>
                        <li class="breadcrumb-item active text-weight-600" aria-current="page"><?= $pageName ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>