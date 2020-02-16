<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JKM | <?php echo (isset($title))? $title : '';?></title>
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
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <script>
        var BASEURL = '<?php echo base_url(); ?>';

        //Category ID variables
        var ADSALESCAT = '<?php echo ADSALESCAT; ?>';
        var LOCALIZATIONCAT = '<?php echo LOCALIZATIONCAT; ?>';
        var CONTENTCAT = '<?php echo CONTENTCAT; ?>';
        var WIRELESSCAT = '<?php echo WIRELESSCAT; ?>';
        var TECHNOLOGYCAT = '<?php echo TECHNOLOGYCAT; ?>';
        var ADNETWORKSCAT = '<?php echo ADNETWORKSCAT; ?>';
        var ADSALESINCCAT = '<?php echo ADSALESINCCAT; ?>';
        var LOCALIZATIONINCCAT = '<?php echo LOCALIZATIONINCCAT; ?>';
        var WIRELESSINCCAT = '<?php echo WIRELESSINCCAT; ?>';
        var TECHNOLOGYINCCAT = '<?php echo TECHNOLOGYINCCAT; ?>';
        var ADNETWORKSINCCAT = '<?php echo ADNETWORKSINCCAT; ?>';
    </script>

    <script src="<?php echo base_url();?>assets/vendor/jquery/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/jquery/js/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap-multiselect.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/placeholdem/js/placeholdem.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/material/js/material.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/datatables/js/datatables.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/mCustomScrollbar/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/highcharts/js/highcharts.js"></script>
	<script src="<?php echo base_url();?>assets/vendor/nice-select/js/jquery.nice-select.min.js"></script>
	<script src="<?php echo base_url();?>assets/vendor/moment/moment.js"></script>
    <script src="<?php echo base_url();?>assets/js/tableHeadFixer.js"></script>
    <script src="<?php echo base_url();?>assets/js/custom_script.js"></script>
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
$user = getCurrentUser();
$userPermission = $this->session->userdata('userPermission');
$menuList = get_left_menu($user->id, $user->role_id);

$currentURL = $this->uri->uri_string();
if($this->uri->segment(3)) {
    $allParts =  explode('/', $currentURL);
    array_pop($allParts);
    $currentURL = implode('/', $allParts);
}
$mainMenuArray = array(
    'Dashboard' =>  array('dashboard', 'dashboard/approve-pending', 'dashboard/change-password'),
    'manage_clients' => array('clients','clients/add-client', 'clients/edit-client'),
    'users' => array('users/add', 'users/edit'),
    'Manage Invoice' => array('jobs', 'jobs/new-job','jobs/view-job', 'jobs/edit-job', 'collections', 'invoice/generates', 'invoice/generate-invoice', 'invoice/invoice-approval', 'invoice-delivery'),
    'view invoices'=> array('collection', 'collection/view','collection/pending'),
    'Reports' => array('reports'),
    'Payment Laser' => array('payments'),
    'job_inquiry' => array('inquiry'),
);

?>
<div class="wrapper">
    <aside class="ims-sidebar">
        <div class="side_logo"><a title="" href="<?php echo base_url();?>"><img class="img-responsive" width="210" src="<?php echo base_url();?>assets/default/img/logo_2.png" /></a></div>
		<div class="res_menu">
			<button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#ims_menubar" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		</div>
        <div class="side_menu collapse navbar-collapse" id="ims_menubar" >
			<div class="mobile-usr">
				<div class="aside-user"><i class="fa fa-user-o"></i></div>
				<div class="dropdown usr_signout"><a href="#" class="dropdown-toggle ripple" data-toggle="dropdown" aria-expanded="false"><span class="user_info">  <span class="user_name"><?php echo ucwords($user->first_name.' '.$user->last_name); ?></span>  <i class="fa fa-angle-down"></i></span>
							</a>
					<div class="dropdown-menu dropdown-left dropdown-card dropdown-card-profile ">
						<div class="card">
							<ul class="list-unstyled card-body">
								<li><a href="<?php echo base_url()?>logout">Sign Out</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
            <?php  if($menuList) :

                $iconArray = array('Dashboard' => 'icon-dashboard','manage_clients' => 'icon-client',
                 'Manage Order' => 'icon-order', 'Manage Invoice' => 'icon-invoice-menu', 
                 'payment-laser' => 'icon-projection', 'job_inquiry'=> 'icon-report-new',
                 'view invoices'=> 'icon-view','Reports' => 'icon-report-new',
                 'currency_conversions' => 'icon-recycle' );
                ?>

            <ul>
                <?php  foreach($menuList as $list) :
                    $mainMenu = (isset($mainMenuArray[$list->menu_name])) ? $mainMenuArray[$list->menu_name] : array();
                    /*Condition For MAIN MENU SHOW/HIDE BASED ON PERMISSION*/
                    if($list->redirect_url !='NA'):
                        if(1): ?>
                            <!--<li><a href="#"><span class="<?php /*echo $iconArray[$list->menu_name] */?>"></span><?php /*echo $list->display_name; */?> <i class="fa fa-angle-right"></i></a></li>-->
                            <li class="<?php echo (in_array($currentURL, $mainMenu)) ? "active" : ''; ?>">
                                <a data-toggle="<?php echo  ($list->redirect_url == 'NA') ? 'collapse' : ''; ?>" href="<?php echo  ($list->redirect_url == 'NA') ? '#'.str_replace(" ","_", $list->menu_name) : base_url().$list->redirect_url; ?>"><span class="<?php echo (isset($iconArray[$list->menu_name])) ? $iconArray[$list->menu_name]: ""; ?>"></span><?php echo $list->display_name; ?>
                                    <?php if($list->redirect_url == 'NA' && count($list->submenuList)):  ?>
                                        <i class="fa fa-angle-right"></i>
                                    <?php endif;  ?>
                                </a>
                                <?php if($list->redirect_url == 'NA' && $list->has_submenu == 'Y' && count($list->submenuList)) : ?>
                                    <ul class="collapse sub_menu" id="<?php echo str_replace(" ","_", $list->menu_name); ?>">
                                        <?php  foreach($list->submenuList as $submenulist) :?>
                                            <?php if(1): ?>
                                                <li class="<?php echo (strpos($currentURL, $submenulist->redirect_url) !== false) ? "active" : ''; ?>"><a href="<?php echo base_url().$submenulist->redirect_url;?>"><?php echo $submenulist->display_name; ?></a></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                            </li>
                        <?php endif; ?>

                    <?php else: ?>
                        <!--<li><a href="#"><span class="<?php /*echo $iconArray[$list->menu_name] */?>"></span><?php /*echo $list->display_name; */?> <i class="fa fa-angle-right"></i></a></li>-->
                        <li class="<?php echo (in_array($currentURL, $mainMenu)) ? "active" : ''; ?>">
                            <a data-toggle="<?php echo  ($list->redirect_url == 'NA') ? 'collapse' : ''; ?>" href="<?php echo  ($list->redirect_url == 'NA') ? '#'.str_replace(" ","_", $list->menu_name) : base_url().$list->redirect_url; ?>"><span class="<?php echo (isset($iconArray[$list->menu_name])) ? $iconArray[$list->menu_name]: ""; ?>"></span><?php echo $list->display_name; ?>
                                <?php if($list->redirect_url == 'NA' && count($list->submenuList)):  ?>
                                <i class="fa fa-angle-right"></i>
                                <?php endif;  ?>
                            </a>
                            <?php if($list->redirect_url == 'NA' && $list->has_submenu == 'Y' && count($list->submenuList)) : ?>
                            <ul class="collapse sub_menu" id="<?php echo str_replace(" ","_", $list->menu_name); ?>">
                                <?php  foreach($list->submenuList as $submenulist) :?>
                                <?php if(1): ?>
                                <li class="<?php echo (strpos($currentURL, $submenulist->redirect_url) !== false) ? "active" : ''; ?>"><a href="<?php echo base_url().$submenulist->redirect_url;?>"><?php echo $submenulist->display_name; ?></a></li>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>

                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
				<li class="signout-mob-ftr"><a href="<?php echo base_url()?>logout"><span class="icon-logout" aria-hidden="true"></span> Sign Out</a>
            </ul>
            <?php  endif; ?>
        </div>
    </aside>
    <main class="content-box">
        <nav class="navbar-ims clearfix">
            <?php if($currentURL == 'dashboard') : ?>
            <div class="nav-page-title">Dashboard</div>
            <?php endif; ?>
            <div class="navbar-right-content">
                <ul class="nav-alerts">
                    <?php /*if($userPermission && in_array('orders/create-order', $userPermission)): */?><!--
                    <li class="create_link"><a href="<?php /*echo base_url()*/?>orders/create-order" class="btn-theme btn-pink mdl-js-button mdl-js-ripple-effect ripple-white">Create Job </a></li>
                    --><?php /*endif; */?>

                    <li class="notification_dropdown">
						<a href="javascript:voiude(0);"><i class="fa fa-bell-o" aria-hidden="true"></i><!--<span class="notification_count">5</span>-->
						</a>
                    </li>
                    <li class="dropdown usr_signout"><a href="#" class="dropdown-toggle ripple" data-toggle="dropdown" aria-expanded="false"><span class="user_info"><span class="user_name"><?php echo ucwords($user->first_name.' '.$user->last_name); ?></span>  <i class="fa fa-angle-down"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-left dropdown-card dropdown-card-profile ">
                            <div class="card">
                                <ul class="list-unstyled card-body">
                                    <!--<li><a href="#">Manage Accounts</a>
                                    </li>
                                    <li><a href="#">Change Password</a>
                                    </li>
                                    <li><a href="#">Check Inbox</a>
                                    </li>-->
                                    <li><a href="<?php echo base_url('dashboard/')?>change-password">Change Password</a>
                                    <li><a href="<?php echo base_url()?>logout">Sign Out</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <?php echo (isset($contents)) ? $contents :"<h2>Unable to load content.</h2>";?>
        </main><!--content-box-->

    </div><!--wrapper-->
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