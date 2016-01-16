<?php
require 'lfl.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(lfl_user_is_of_type())
{
    $token = filter_input(INPUT_POST, 'tk');
    $type = filter_input(INPUT_POST, 'tp');
    if(lfl_token_verify($token))
    {
        $result = 'error';
        switch($type)
        {
            case "test":
            {
                $result = (array('user' => $_SESSION['user']['username'], 'time' => time()));
                break;
            }
            case "addlist":
            {
                $listname = filter_input(INPUT_POST, 'name');
                $result = array('success' => lfl_add_list($_SESSION['user']['userId'], $listname));
                break;
            }
            case "getlists":
            {
                $userId = $_SESSION['user']['userId'];
                $s = lfl_get_user_lists($userId);
                if($s)
                {
                    $result = array('success' => true, 'data' => $s);
                }
                else
                {
                    $result = array('success' => false);
                }
                break;
            }
            default:
            {
                $result = 'error';
                break;
            }
        }
        echo json_encode($result);
        exit();
    }
}
echo json_encode('error');