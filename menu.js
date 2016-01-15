/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var doStuff;
var minMenuWidth = 0.0;
var menuNormalTop;
var shouldShowShowcaseMenu = false;
var showcaseMenuList;
var showcaseMenuItems;

$(document).ready(function(){
    $(".menuLi").each(function(){
        minMenuWidth += $(this).outerWidth();
        console.log( $(this).outerWidth());
    });
    menuNormalHeight = $("#pageMenu").height();
    menuNormalTop = $("#pageMenu").offset().top;
    
    //Any element events get added here
    /*
     * If we haven't entered .showcaseMenuUl, hide when exiting #li_showcase
     * Else, hide when leaving .showcaseMenuUl
     */
    showcaseMenuList = $(".showcaseMenuUl");
    showcaseMenuItems = $(".showcaseMenuLi");
    
    $("#li_showcase").mouseenter(showShowcaseMenu);
    $("#li_showcase").mouseleave(function(){
        if(!shouldShowShowcaseMenu)
            hideShowcaseMenu();
    });
    showcaseMenuList.mouseenter(function(){
        shouldShowShowcaseMenu = true;
    });
    showcaseMenuList.mouseleave(function(){
        hideShowcaseMenu();
    });
    
    /*
     * Window events
     */
    $(window).resize(function(){    
        calcMenuSize();
        calcMenuPosition();
    });
    $(window).scroll(calcMenuPosition);

    
    calcMenuSize();
    calcMenuPosition();
});

function calcMenuSize()
{
    var menuTargetHeight = 0;
    
    if($("#menuUl").width() < minMenuWidth)
    {
        //Showcase menu
        showShowcaseMenu();
        showcaseMenuList.attr("class", "");
        showcaseMenuItems.css("padding-left", "15px");
        
        $(".menuLi").each(function(){
            $(this).css("width", $("#menuUl").width() + "px");
            menuTargetHeight += menuNormalHeight;
        });
        $(".showcaseMenuLi").each(function(){
            menuTargetHeight += menuNormalHeight;
        });
        
    }
    else
    {
        //Showcase menu
        showcaseMenuList.attr("class", "showcaseMenuUl");
        showcaseMenuItems.css("width", "");
        showcaseMenuItems.css("padding-left", "");
        hideShowcaseMenu();
        
        $(".menuLi").each(function(){
            $(this).css("width", "");
        });
        menuTargetHeight = menuNormalHeight;
        
    }
    $("#pageMenu").height(menuTargetHeight);
}
/*
 * Sticky menu
 */
function calcMenuPosition()
{
    //We don't want this on 'mobile'
    if($("#pageMenu").height() > menuNormalHeight)
    {
        $("#pageMenu").css("position", "static");
        $("#pageMenuFake").css("display", "none");
        return;
    }
        
    if($(window).scrollTop() > menuNormalTop)
    {
        $("#pageMenu").css("position", "fixed");
        $("#pageMenu").css("top", "0");
        $("#pageMenuFake").css("display", "block");
    }
    else
    {
        $("#pageMenu").css("position", "static");
        $("#pageMenuFake").css("display", "none");
    }
}

/*
 * Showcase
 */
function showShowcaseMenu()
{
    $(".showcaseMenuUl").css("display", "block");
}
function hideShowcaseMenu()
{
    $(".showcaseMenuUl").css("display", "none");
    shouldShowShowcaseMenu = false;
}
