<?php
require 'lfl.php';
?>
<!DOCTYPE html>
<!--
TODO:
- Pagina's toevoegen
- Content home toevoegen
- DB spul?
-->
<html>
    <head>
        <title>Lists - POST it</title>
        <meta charset="UTF-8">
        <!-- Mobile phone 'support' -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="jquery-1.11.3.min.js"></script>
        <script src="menu.js"></script>
        <script src="header.js"></script>
    </head>
    <body>
        <?php 
        include 'inc/header.php';
        include 'inc/menu.php';
        ?>
        <div id="pageContent">
            <div id="content">
                <?php
                    if(lfl_user_is_of_type())
                    {
                        echo '<div id="token"><div id="' . lfl_token_update() . '"></div></div>';
                        ?>
                <script>
                    var token = String(document.getElementById('token').children[0].id);
                    function submitNewList()
                    {
                        var newListName = document.getElementById("newListField").value;
                        if(!newListName.match(/^\s*$/))
                        {
                            $.post("request.php", { tk: token, tp: "addlist", name: newListName}, function(data){
                                document.getElementById("newListField").value = '';
                                document.getElementById("newListMessage").innerHTML = 'New list was created';
                                fetchLists();
                            }, "json");
                        }
                        else
                        {
                            document.getElementById("newListMessage").innerHTML = 'Please fill in a list name';
                        }
                    }
                    function fetchLists()
                    {
                        $.post("request.php", { tk: token, tp: "getlists" }, function(data){
                                console.log(data);
                                if(data.success)
                                {
                                    if(data.data.length > 0)
                                    {
                                        var currentTable = document.getElementsByClassName('listsTable');
                                        if(currentTable.length > 0)
                                        {
                                            currentTable[0].remove();
                                        }
                                        
                                        console.log(data.data.length + ' lists found');
                                        var body = document.body;
                                        var table = document.createElement('table');
                                        table.className = "listsTable";
                                        var tr = table.insertRow();
                                        var header = document.createElement('th');
                                        header.className = "col_80";
                                        tr.appendChild(header);
                                        header = document.createElement('th');
                                        header.className = "col_20";
                                        tr.appendChild(header);
                                        
                                        for(var i = 0; i < data.data.length; i++)
                                        {
                                            tr = table.insertRow();
                                            td = tr.insertCell();
                                            td.className = "col_80";
                                            var a = document.createElement('a');
                                            a.href = "viewlist.php?listId=" + data.data[i].listId;
                                            a.appendChild(document.createTextNode(data.data[i].listname));
                                            td.appendChild(a);
                                            td = tr.insertCell();
                                            td.className = "col_20";
                                            var img = document.createElement('img');
                                            img.alt = 'fav icon';
                                            img.src = (data.data[i].isFav > 0) ? 'img/icon-star-checked.png' : 'img/icon-star-unchecked.png';;
                                            td.appendChild(img);
                                        }
                                        
                                        document.getElementById('content').appendChild(table);
                                    }
                                    else
                                    {
                                        console.log('No lists');
                                    }
                                }
                            }, "json");
                    }
                    $(document).ready(function(){
                        fetchLists();
                    });
                    
                </script>
                <div>
                    <p>Create new list</p>
                    <input id="newListField" type="text" name="listname">
                    <button onclick="submitNewList()">Add new list</button>
                    <p id="newListMessage"></p>
                </div>
                <?php
                    }
                    else
                    {
                        echo '<p>You have to be <a href="login.php">logged in</a> to visit this page</p>';
                    }
                ?>
            </div>
        </div>
        <?php
        include 'inc/footer.php';
        ?>
    </body>
</html>
