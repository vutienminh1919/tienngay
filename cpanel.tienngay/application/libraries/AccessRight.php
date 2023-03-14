<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AccessRight {
    public function checkRoleMenu($menuId, $listIds) {
        $isRole = FALSE;
        if(in_array($menuId, $listIds)) $isRole = TRUE;
        return $isRole;
    }
}