<div class="col-md-3 left_col ">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">

			<?php if (is_array($groupRoles)): ?>
			<?php if(in_array('5de726e4d6612b6f2c310c78',$groupRoles) ||in_array('5de726c9d6612b6f2a617ef5',$groupRoles) ||in_array('5ec74bd2d6612b3cc464e64a',$groupRoles) || in_array('608137415324a7567e5ffe04',$groupRoles) || in_array('quan-ly-cap-cao',$groupRoles)  || in_array('quan-ly-khu-vuc',$groupRoles)  || in_array('giao-dich-vien',$groupRoles)  || in_array('cua-hang-truong',$groupRoles)): ?>
			<a href="<?php echo base_url();?>report_kpi/kpi_domain_v2">
            <img src="<?php echo base_url("assets/imgs/")?>logo.png" alt="">
            </a>
			<?php else: ?>
				<a>
					<img src="<?php echo base_url("assets/imgs/")?>logo.png" alt="">
				</a>
			<?php endif; ?>
			<?php else: ?>
			<a>
				<img src="<?php echo base_url("assets/imgs/")?>logo.png" alt="">
			</a>
			<?php endif; ?>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <!-- <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?php echo base_url();?>assets/imgs/avatar_none.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2 style=' max-width: 120px; overflow: hidden; text-overflow: ellipsis;'><?= !empty($userSession['email']) ?  " ".$userSession['email'] : ""?></h2>
            </div>
        </div> -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">

                <?php
                    $language = !empty($this->session->userdata("language")) ? $this->session->userdata("language") : "english";
                    $session = $this->session->userdata('user');
                    $roleMenus = array();
                    if(!empty($userRoles->role_menus) && count($userRoles->role_menus) > 0) {
                        $roleMenus = $userRoles->role_menus;
                    }

                    $menus = $this->menu_model->get_menu($session['token'],$language);
                    function multilevelMenu($parentId, $ctgLists, $ctgData, $index=0, $session, $roleMenus) {
                        $html = '';
                        if(isset($ctgLists[$parentId])) {
                            $clsMain = $index == 0 ? "side-menu" : "child_menu";
                            $html = '<ul class="nav '.$clsMain.'">';
                            //Start display tab for SuperAmin
                            if($index == 0 && $session['is_superadmin'] == 1) {
                                //$html.= '<li class=""><a href="'.base_url("menu").'">Quản lý menu</a></li>';
                                //$html.= '<li class=""><a href="'.base_url("role/search").'">Quản lý phân quyền</a></li>';
                                //$html.= '<li class=""><a href="'.base_url("accessRight").'">Quản lý access right</a></li>';
                            }
                            //End display tab for SuperAmin
                            foreach ($ctgLists[$parentId] as $childId) {
                                $haveParent = checkParentMenu($ctgLists, $childId);
                                $haveChild = checkChild($ctgLists, $childId);
                                $strDown = "";
                                if($haveChild == TRUE) {
                                    $strDown = '<span class="fa fa-chevron-down"></span>';
                                }
                                $url = "";
                                if($haveParent == TRUE && $haveChild == FALSE) {
                                    $url = "href='".base_url($ctgData[$childId]['url'])."'";
                                }
                                if ($ctgData[$childId]['parent_name'] == "Thư Viện Trực Tuyến" || $ctgData[$childId]['parent_name'] == "5.1 Thư Viện Trực Tuyến" ){
									$url =  "target='_blank' href='".$ctgData[$childId]['url']."'";
								}

                                $icon = !empty($ctgData[$childId]['icon']) ? $ctgData[$childId]['icon'] : "";
                                if(
                                    (!empty($roleMenus) && in_array($ctgData[$childId]['id'], $roleMenus)) 
                                    || $session['is_superadmin'] == 1 
                                    || $ctgData[$childId]['isNotRole'] == 1
                                ) {
                                    $html .= '<li data-menu-id="'.$ctgData[$childId]['id'].'"><a '.$url.'>'.'<i class="'.$icon.'"></i>'. $ctgData[$childId]['name'] .$strDown.'</a>';
                                    $index++;
                                    $html .= multilevelMenu($childId, $ctgLists, $ctgData, $index, $session, $roleMenus);
                                    $html .= '</li>';
                                }
                            }
                            $html .= '</ul>';
                        }
                      return $html;
                    }
                    //Start init [parent_id] = array("child_id_1", "child_id_2")
                    $ctgLists = array();
                    $ctgLists['root']  = array();
                    foreach($menus as $parent) {
                        $ctgLists[getId($parent->_id)]  = array();
                        foreach($menus as $child) {
                            if($child->parent_id == getId($parent->_id)) {
                                array_push($ctgLists[getId($parent->_id)], getId($child->_id));
                            }
                        }
                        if(count($ctgLists[getId($parent->_id)]) == 0) {
                            unset($ctgLists[getId($parent->_id)]);
                        }
                        if(empty($parent->parent_id)) {
                            array_push($ctgLists['root'], getId($parent->_id));
                        }
                    }
                    //Start init [current_id] = array("name" => "", "url" => "")
                    $ctgData = array();
                    foreach($menus as $item) {
                        $ctgData[getId($item->_id)]  = array(
                            "name" => $item->name,
                            "url" => $item->url,
                            "id" => getId($item->_id),
                            "icon" => !empty($item->icon) ? $item->icon : "",
                            "parent_name" => !empty($item->parent_name) ? $item->parent_name : "",
                            "isNotRole" => !empty($item->isNotRole) ? $item->isNotRole : 0
                        );
                    }
                    $index = 0;

                    echo multilevelMenu('root', $ctgLists, $ctgData, $index, $session, $roleMenus);
                ?>
            </div>
        </div>
        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <!-- <a data-toggle="tooltip" data-placement="top" title="Settings">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a> -->
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
