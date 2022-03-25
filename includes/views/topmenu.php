

<style>

.kt-header-menu .kt-menu__nav > .kt-menu__item {
    white-space: pre;
}
    
</style>
<div id="kt_header" class="kt-header  kt-header--fixed " data-ktheader-minimize="on">
						<div class="kt-container  kt-container--fluid ">

							<!-- begin: Header Menu -->
							<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
							<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
							    
							    <?if($g_enableLeftMenu){?>
								<button class="kt-aside-toggler kt-aside-toggler--left" id="kt_aside_toggler"><span></span></button>
								<?}?>
								<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
									<ul class="kt-menu__nav">
									    
									    
									    <?if($logged==1 ){?>
    									    
                                            <li class="kt-menu__item <?if($filenameLink=='home.php'){echo 'kt-menu__item--here';}?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                                <a href="./home.php" class="kt-menu__link"><span class="kt-menu__link-text">Home</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            </li>
                                    	
                                           
                                        <?}else{?>
                                            <li class="kt-menu__item <?if($filenameLink=='login.php'){echo 'kt-menu__item--here';}?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                                <a href="./login.php" class="kt-menu__link"><span class="kt-menu__link-text">Login</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            </li>
                                        
                                            <?if($g_signupEnabled){?>
                                                <li class="kt-menu__item <?if($filenameLink=='signup.php'){echo 'kt-menu__item--here';}?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                                    <a href="./signup.php" class="kt-menu__link"><span class="kt-menu__link-text">Signup</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                                </li>
                                            <?}?>
                                        <?}?>
                                        
                                    </ul>

								</div>
							</div>

							

							<!-- begin:: Header Topbar -->
							<?if($logged==1){?>
							<div class="kt-header__topbar kt-grid__item">
								<!--begin: User bar -->
								<div class="kt-header__topbar-item kt-header__topbar-item--user">
									<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
										<span class="kt-header__topbar-welcome kt-visible-desktop"> </span>
										<span class="kt-header__topbar-username kt-visible-desktop"></span>
										<!--
										<img alt="Pic" src="assets/media/users/300_21.jpg" />
										-->

										<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
										<span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"><?echo substr($session_name, 0, 1);?></span>
									</div>
									<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

										<!--begin: Head -->
									<div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
											<div class="kt-user-card__avatar">
											    <!--
												<img class="kt-hidden-" alt="Pic" src="assets/media/users/300_25.jpg" />
												-->

											    <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"><?echo substr($session_name, 0, 1);?></span>
											</div>
											<div class="kt-user-card__name">
												<?echo $session_name?>
											</div>
											<div class="kt-user-card__badge">
												<a href="./?logout=1" class="btn btn-label-primary btn-sm btn-bold btn-font-md">Logout</a>
											</div>
										</div>

                                        <?if($g_accountSettingsEnabled){?>
                                        <div class="kt-notification">
											<a href="./settings.php" class="kt-notification__item">
												<div class="kt-notification__item-icon">
													<i class="flaticon2-calendar-3 kt-font-success"></i>
												</div>
												<div class="kt-notification__item-details">
													<div class="kt-notification__item-title kt-font-bold">
														Settings
													</div>
													<div class="kt-notification__item-time">
														Account settings 
													</div>
												</div>
											</a>
										
											
										</div>
										<?}?>
								
									
										
										<!--end: Navigation -->
									</div>
								</div>

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
							<?}?>

							<!-- end:: Header Topbar -->
						</div>
					</div>