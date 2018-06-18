<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IMS | <?php echo (isset($title))? $title : '';?></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/material/css/material.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap-multiselect.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/datatables.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/mCustomScrollbar/css/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/nice-select/css/nice-select.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <!-- Page level plugin CSS-->
    <!--<link href="<?php echo base_url();?>assets/vendor/datatables/css/dataTables.bootstrap4.css" rel="stylesheet">-->

    <script src="<?php echo base_url();?>assets/vendor/jquery/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/jquery/js/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/jquery/js/jquery-ui.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap-multiselect.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/placeholdem/js/placeholdem.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/material/js/material.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/datatables/js/datatables.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/mCustomScrollbar/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/highcharts/js/highcharts.js"></script>

    <script src="<?php echo base_url();?>assets/js/custom_script.js"></script>

    <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/nice-select/js/jquery.nice-select.min.js"></script>
    <!--<script src="<?php echo base_url();?>assets/vendor/datatables/js/dataTables.bootstrap4.js"></script>-->

    <script>
        var BASEURL = '<?php echo base_url(); ?>';
    </script>

</head>
<body class="page_body">
<div class="loader-wrapper" id="loader-3">
    <div id="loader"></div>
    <div id="loader"></div>
    <div id="loader"></div>
    <div id="loader"></div>
    <div id="loader"></div>
</div>
<?php
$user = $this->session->userdata('systemAdmin');
$currentURL = $this->uri->uri_string();
if($this->uri->segment(3)) {
    $allParts =  explode('/', $currentURL);
    array_pop($allParts);
    $currentURL = implode('/', $allParts);
}
$mainMenuArray = array(
    'dashboard' =>  array('admin/dashboard'),
    'users' => array('admin/users','admin/users/add', 'admin/users/edit', 'admin/users/assign-category'),
    'menu' => array('admin/menu','admin/menu/add', 'admin/menu/edit'),
    'category' => array('admin/category','admin/category/add', 'admin/category/edit'),
    'currency'=> array('admin/currency','admin/currency/add', 'admin/currency/edit'),
    'company' =>  array('admin/company','admin/company/add', 'admin/company/edit'),
    'tax' =>  array('admin/tax','admin/tax/add', 'admin/tax/edit'),
    'clients' =>  array('admin/clients', 'admin/clients/edit-client'),
    'invoices' =>  array('admin/invoices'),
    'configurations' => array('admin/configurations')
);
?>
<div class="wrapper">
    <aside class="ims-sidebar">
        <div class="side_logo"><a href="<?php echo base_url('admin'); ?>/dashboard" title="Dashboard"><img class="img-responsive" src="<?php echo base_url();?>assets/images/logo_ims.svg" /></a></div>
        <div class="side_menu">
            <ul>
                <li class="<?php echo (in_array($currentURL, $mainMenuArray['dashboard'])) ? "active" : ''; ?>"><a href="<?php echo base_url()?>admin/dashboard"><span class="fa fa-dashboard"></span>Dashboard <i class="fa fa-angle-right"></i></a></li>
                <li class="<?php echo (in_array($currentURL, $mainMenuArray['users'])) ? "active" : ''; ?>"><a data-toggle="collapse" href="#manageUsers"><span class="fa fa-user"></span>Manage Users <i class="fa fa-angle-right"></i></a>
                    <ul class="collapse sub_menu" id="manageUsers">
                        <li class=""><a href="<?php echo base_url()?>admin/users">View Users</a></li>
                        <li class=""><a href="<?php echo base_url()?>admin/users/add">Add Users</a></li>
                        <li class=""><a href="<?php echo base_url()?>admin/users/assign-category">Category Assignment</a></li>
                    </ul>
                </li>
                <li class="<?php echo (in_array($currentURL, $mainMenuArray['menu'])) ? "active" : ''; ?>"><a data-toggle="collapse" href="#menuManagement"><span class="fa fa-navicon"></span>Manage Menus <i class="fa fa-angle-right"></i></a>
                    <ul class="collapse sub_menu" id="menuManagement">
                        <li class=""><a href="<?php echo base_url()?>admin/menu">View Menus</a></li>
                        <li class=""><a href="<?php echo base_url()?>admin/menu/add">Add Menu</a></li>
                        <li class=""><a href="<?php echo base_url()?>admin/menu/menu-assignment">Assign Primary Menu</a></li>
                        <li class=""><a href="<?php echo base_url()?>admin/menu/submenu-assignment">Assign Submenu</a></li>
                    </ul>
                </li>
                <li class="<?php echo (in_array($currentURL, $mainMenuArray['category'])) ? "active" : ''; ?>"><a href="<?php echo base_url()?>admin/category"><span class="fa fa-tags"></span>Manage Category<i class="fa fa-angle-right"></i></a></li>
                <li class="<?php echo (in_array($currentURL, $mainMenuArray['currency'])) ? "active" : ''; ?>"><a href="<?php echo base_url()?>admin/currency"><span class="fa fa-inr"></span>Manage Currency<i class="fa fa-angle-right"></i></a></li>
                <li class="<?php echo (in_array($currentURL, $mainMenuArray['company'])) ? "active" : ''; ?>"><a href="<?php echo base_url()?>admin/company"><span class="fa fa-building"></span>Manage Company<i class="fa fa-angle-right"></i></a></li>
                <li class="<?php echo (in_array($currentURL, $mainMenuArray['tax'])) ? "active" : ''; ?>"><a href="<?php echo base_url()?>admin/tax"><span class="fa fa-credit-card"></span>Manage Tax<i class="fa fa-angle-right"></i></a></li>
                <li class="<?php echo (in_array($currentURL, $mainMenuArray['clients'])) ? "active" : ''; ?>"><a href="<?php echo base_url()?>admin/clients"><span class="fa fa-user"></span>Manage Clients<i class="fa fa-angle-right"></i></a></li>
                <li class="<?php echo (in_array($currentURL, $mainMenuArray['invoices'])) ? "active" : ''; ?>"><a href="<?php echo base_url()?>admin/invoices"><span class="fa fa-window-close-o"></span>Manage Invoices<i class="fa fa-angle-right"></i></a></li>
                <li class="<?php echo (in_array($currentURL, $mainMenuArray['configurations'])) ? "active" : ''; ?>"><a href="<?php echo base_url()?>admin/configurations"><span class="fa fa-cog"></span>Configurations <i class="fa fa-angle-right"></i></a></li>
                <!--<li><a href="#"><span class="icon-invoice"></span>Manage Invoice <i class="fa fa-angle-right"></i></a></li>
                <li><a href="#"><span class="icon-order"></span>Manage Orders <i class="fa fa-angle-right"></i></a></li>
                <li><a href="#"><span class="icon-view"></span>View Invoice <i class="fa fa-angle-right"></i></a></li>
                <li><a href="#"><span class="icon-report"></span>Reports <i class="fa fa-angle-right"></i></a></li>-->
            </ul>
        </div>
    </aside>
    <main class="content-box">
        <nav class="navbar-ims clearfix">
            <div class="nav-page-title">System Admin</div>
            <div class="navbar-right-content">
                <ul class="nav-alerts">
                    <li class="dropdown"><a href="#" class="dropdown-toggle ripple" data-toggle="dropdown" aria-expanded="false"><span class="user_info"><i class="flaticon-avatar"></i> Welcome <?php echo ucwords($user->first_name.' '.$user->last_name); ?>  <i class="fa fa-angle-down"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-left dropdown-card dropdown-card-profile">
                            <div class="card">
                                <ul class="list-unstyled card-body">

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="modal" data-target="#logoutModal" href="#">
                                            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/login/logout">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <?php echo (isset($contents)) ? $contents :"<h2>Unable to load content.</h2>";?>
    </main><!--content-box-->
</div><!--wrapper-->
<!--<footer class="sticky-footer">
    <div class="container">
        <div class="text-center">
            <small>&copy; <?php /*echo date('Y');*/?>Webdunia.com</small>
        </div>
    </div>
</footer>-->

<style>
    .loader-wrapper{
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 99999;
        background: rgba(74, 81, 190, 0.8);
    }
    .loader-wrapper #loader{
        position: absolute;
        width: 2vw;
        height: 2vw;
        background: rgb(255,0,0);
        top:50%;
        left: 50%;
        border-radius: 50%;
        z-index: 1500;
        -webkit-animation: forward 2.3s linear infinite;
        -moz-animation: forward 2.3s linear infinite;
        -o-animation: forward 2.3s linear infinite;
        animation: forward 2.3s linear infinite ;
    }

    .loader-wrapper > #loader:nth-of-type(1) {
        -webkit-animation-delay: -0.46s;
        -moz-animation-delay: -0.46s;
        -o-animation-delay: -0.46s;
        animation-delay: -0.46s;
    }

    .loader-wrapper > #loader:nth-of-type(2) {
        -webkit-animation-delay: -0.92s;
        -moz-animation-delay: -0.92s;
        -o-animation-delay: -0.92s;
        animation-delay: -0.92s;
    }
    .loader-wrapper > #loader:nth-of-type(3) {
        -webkit-animation-delay: -1.38s;
        -moz-animation-delay: -1.38s;
        -o-animation-delay: -1.38s;
        animation-delay: -1.38s;
    }
    .loader-wrapper > #loader:nth-of-type(4) {
        -webkit-animation-delay: -1.84s;
        -moz-animation-delay: -1.84s;
        -o-animation-delay: -1.84s;
        animation-delay: -1.84s;
    }

    /*keyframes for forward animations*/

    @-webkit-keyframes forward {
        0% {
            left: 40%;
            opacity: 0;
            background: rgb(255,255,0);
        }
        10% {
            left: 45%;
            opacity: 1;
        }
        90% {
            left: 55%;
            opacity: 1;
        }
        100% {
            left: 62%;
            opacity: 0;
        }
    }

    @-moz-keyframes forward {
        0% {
            left: 40%;
            opacity: 0;
            background: rgb(255,255,0);
        }
        10% {
            left: 45%;
            opacity: 1;
        }
        90% {
            left: 55%;
            opacity: 1;
        }
        100% {
            left: 62%;
            opacity: 0;
        }
    }

    @-o-keyframes forward {
        0% {
            left: 40%;
            opacity: 0;
            background: rgb(255,255,0);
        }
        10% {
            left: 45%;
            opacity: 1;
        }
        90% {
            left: 55%;
            opacity: 1;
        }
        100% {
            left: 62%;
            opacity: 0;
        }
    }

    @keyframes forward {
        0% {
            left: 40%;
            opacity: 0;
            background: rgb(255,255,0);
        }
        10% {
            left: 45%;
            opacity: 1;
        }
        90% {
            left: 55%;
            opacity: 1;
        }
        100% {
            left: 62%;
            opacity: 0;
        }
    }
</style>

</body>
</html>