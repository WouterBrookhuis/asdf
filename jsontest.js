/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var token = String(document.getElementById('token').children[0].id);
$.post("request.php", {tk: token, tp: "test"}, request_callback, "json");

function request_callback(data)
{
    console.log(data);
    console.log("Data: " + data.user);
    console.log("Data: " + data.time);
}