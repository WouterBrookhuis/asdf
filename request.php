<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(lfl_user_is_of_type())
{
    $token = filter_input(INPUT_POST, 'tk');
    $type = filter_input(INPUT_POST, 'tp');
}