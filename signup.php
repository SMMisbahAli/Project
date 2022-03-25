<?include_once("global.php");

include("./includes/models/users.php");

$role = 'user';

if(!$g_signupEnabled){
    header("Location: ./");
}

?>
<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
	    <?require("./includes/views/head.php")?>
		<link href="assets/css/pages/login/login-1.css" rel="stylesheet" type="text/css" />
		<style>
								.kt-login.kt-login--v1 .kt-login__wrapper {
								    background:#e3f1ff
								}
								.kt-login.kt-login--v1 .kt-login__wrapper .kt-login__body .kt-login__form .kt-form .form-group .form-control {
                                    background-color: white;
								}
								</style>
	</head>
	
<div id="kt_header" class="kt-header  kt-header--fixed " data-ktheader-minimize="on">
						<div class="kt-container  kt-container--fluid ">

							<!-- begin: Header Menu -->
							<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
							<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
							    <!--
								<button class="kt-aside-toggler kt-aside-toggler--left" id="kt_aside_toggler"><span></span></button>
								-->
								<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
									<ul class="kt-menu__nav">
									    
									    
									    <li class="kt-menu__item " data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                            <a href="./home.php" class="kt-menu__link"><span class="kt-menu__link-text">Home</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                        </li>
                                        <li class="kt-menu__item " data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                            <a href="./login.php" class="kt-menu__link"><span class="kt-menu__link-text">Login</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                        </li>
                                        <li class="kt-menu__item kt-menu__item--here" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                            <a href="./signup.php" class="kt-menu__link"><span class="kt-menu__link-text">Signup</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                        </li>

                                    </ul>

								</div>
							</div>

							<!-- end: Header Menu -->

							<!-- begin:: Brand -->
							<!--<div class="kt-header__brand   kt-grid__item" id="kt_header_brand">-->
							<!--	<a class="kt-header__brand-logo" href="./">-->
							<!--		<img style="width:40px;" alt="Logo" src="https://www.anomoz.com/style/logo.png" />-->
							<!--	</a>-->
							<!--</div>-->

							<!-- end:: Brand -->

							<!-- begin:: Header Topbar -->
														<div class="kt-header__topbar kt-grid__item">


								<!--begin: User bar -->

								<!--end: User bar -->

								<!--begin: Quick panel toggler -->
								<!--
								<div class="kt-header__topbar-item" data-toggle="kt-tooltip" title="Quick panel" data-placement="top">
									<div class="kt-header__topbar-wrapper">
										<span class="kt-header__topbar-icon" id="kt_quick_panel_toggler_btn"><i class="flaticon2-cube-1"></i></span>
									</div>
								</div>
								-->

								<!--end: Quick panel toggler -->
							</div>
							
							<!-- end:: Header Topbar -->
						</div>
					</div>
		

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--left kt-aside--fixed kt-page--loading">

		<!-- begin::Page loader -->

		<!-- end::Page Loader -->

		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">

					<!--begin::Aside-->
					<?require("./includes/views/signupsidebar.php")?>

					<!--begin::Aside-->

					<!--begin::Content-->
					<div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">

						<!--begin::Head-->
						<!--
						<div class="kt-login__head">
							<span class="kt-login__signup-label">Don't have an account yet?</span>&nbsp;&nbsp;
							<a href="./signup.php" class="kt-link kt-login__signup-link">Sign Up!</a>
						</div>
						-->

						<!--end::Head-->

						<!--begin::Body-->
						<div class="kt-login__body">

							<!--begin::Signin-->
							<div class="kt-login__form">
								<div class="kt-login__title">
									<h3><?echo ucfirst($role)?> Signup</h3>
								</div>

								<!--begin::Form-->
								<form class="kt-form" action="" method="post" id="kt_login_form" >
								    
								    <?if(isset($_GET['m'])){?>
								    <div class="form-group">
                                        <div class="alert alert-warning"><?echo $_GET['m']?></div>
                                    </div>
                                    <?}?>
                                    
                                    <?
                                    if($role=="vendor"){
                                        $fields = array("businessName","mobilePhone","address","city","state","zip","website");
                                    }else{
                                        $fields = array("company","mobilePhone", "homePhone","zip");
                                    }
                                    $fields = array();
                                    
                                    foreach($fields as $col){
                                    ?>
                                    <div class="form-group">
										<input class="form-control" type="text" placeholder="<?echo ucfirst($col)?>" name="<?echo $col?>" >
									</div>
                                    <?}?>
                                    
                                    <!-- <div class="form-group">
										<input class="form-control" type="text" placeholder="Name" name="name" required>
									</div> -->
									<div class="form-group">
										<input class="form-control" type="text" placeholder="First Name" name="first_name" required>
									</div>
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Last Name" name="last_name" required>
									</div>
									<div class="form-group">
										<input class="form-control" type="email" placeholder="Email" name="email" required>
									</div>
								
									<div class="form-group">
										<input class="form-control" type="password" placeholder="Password" name="password" required>
									</div>
									<br>
                                   
									<!--begin::Action-->
									<div class="kt-login__actions">
									    
										<a href="./login.php" class="kt-link kt-login__link-forgot">
											Already have an account?
										</a>
										<input name="create_user" value="signup" hidden>
									
										<input type="submit" value="Sign up" id="kt_login_signin_submit" class="btn btn-primary btn-elevate kt-login__btn-primary" >
										
									</div>
									
								
									<!--end::Action-->
								</form>

								

								<!--end::Options-->
							</div>

							<!--end::Signin-->
						</div>

						<!--end::Body-->
					</div>

					<!--end::Content-->
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#591df1",
						"light": "#ffffff",
						"dark": "#282a3c",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};
		</script>

		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
		<script src="assets/js/scripts.bundle.js" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->

		<!--end::Page Scripts -->
	</body>
	
	


	<!-- end::Body -->
</html>