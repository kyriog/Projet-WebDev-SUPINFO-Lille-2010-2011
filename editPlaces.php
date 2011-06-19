<?php
require_once('config.php');
require_once('autoload.php');
if(isset($_POST['action'])):
    switch($_POST['action']) {
        case 'add':
            $place = new Model_Place();
            $place->setName($_POST['name']);
            $place->save();
            echo 'ok/%/'.$place->getId().'/%/'.$place->getName();
            break;
        case 'edit':
            $place = new Model_Place($_POST['id']);
            $place->setName($_POST['name']);
            $place->save();
            echo 'ok/%/'.$place->getName();
            break;
        case 'delete':
            $place = new Model_Place($_POST['id']);
            $place->remove();
            echo 'ok';
            break;
    }
else: 
    $places = Model_Place::getAllPlaces();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title></title>
        <style type="text/css">
            .pointer {
                cursor: pointer;
            }
            .hidden {
                display: none;
            }
        </style>
        <script type="text/javascript" src="jquery-1.6.1.min.js"></script>
        <script type="text/javascript">
            var action_create = "<img src=\"media/add.png\" alt=\"Ajouter\" class=\"place_action_add\" />";
            var action_edit = "<img src=\"media/edit.png\" alt=\"Éditer\" class=\"place_action_edit\" />&nbsp;<img src=\"media/delete.png\" alt=\"Supprimer\" class=\"place_action_delete\" />";
            var action_confirm = "<img src=\"media/confirm_edit.png\" alt=\"Confirmer\" class=\"place_action_confirm_edit\" />&nbsp;<img src=\"media/cancel_edit.png\" alt=\"Annuler\" class=\"place_action_cancel_edit\" />";
            var action_loading = "<img src=\"media/loading-mini.gif\" alt=\"Chargement\" />";
            var action_alert = "<img src=\"media/alert.png\" alt=\"Erreur\" />";
            $(document).ready(function() {
                $("#lastline").live('focus',function() {
                    $(this).removeAttr("id");
                    $(this).append("<td class=\"place_action pointer\">"+action_create+"</td>");
                    $("#place_container").append("<tr class=\"place_div\" id=\"lastline\"><td class=\"place_name\"><input type=\"text\" class=\"place_input\" /></td></tr>")
                });
                $(".place_action_add").live('click', function() {
                    var id = $(".place_action").index($(this).parent());
                    $($(".place_name")[id]).children(".place_input").attr("disabled","disabled");
                    $($(".place_action")[id]).removeClass("pointer");
                    $($(".place_action")[id]).html(action_loading);
                    $.ajax({
                        type: "POST",
                        url: "editPlaces.php",
                        data: "action=add&name="+$.trim($($(".place_name")[id]).children(".place_input").val()),
                        success: function(msg) {
                            msg = msg.split("/%/");
                            if($.trim(msg[0]) == "ok") {
                                $($(".place_div")[id]).html("<td class=\"place_name\">"+$.trim(msg[2])+"</td><td class=\"place_action\">"+action_edit+"</td><td class=\"place_id hidden\">"+msg[1]+"</td>");
                                $($(".place_action")[id]).addClass("pointer");
                            } else {
                                $($(".place_action")[id]).html(action_alert);
                            }
                        }
                    })
                });
                $(".place_action_edit").live('click', function() {
                    var id = $(".place_action").index($(this).parent());
                    var name = $($(".place_name")[id]).text();
                    $($(".place_name")[id]).html("<input type=\"text\" class=\"place_input\" value=\""+name+"\" /><span class=\"place_original hidden\">"+name+"</span>");
                    $($(".place_action")[id]).html(action_confirm);
                });
                $(".place_action_confirm_edit").live('click', function() {
                    var id = $(".place_action").index($(this).parent());
                    var name = $($(".place_name")[id]).children(".place_input").val();
                    var id_db = $($(".place_id")[id]).text();
                    $($(".place_action")[id]).children(".place_input").attr("disabled","disabled");
                    $($(".place_action")[id]).removeClass("pointer");
                    $($(".place_action")[id]).html(action_loading);
                    $.ajax({
                        type: "POST",
                        url: "editPlaces.php",
                        data: "action=edit&id="+id_db+"&name="+name,
                        success: function(msg) {
                            msg = msg.split("/%/");
                            if($.trim(msg[0]) == "ok") {
                                $($(".place_name")[id]).text($.trim(msg[1]));
                                $($(".place_action")[id]).html(action_edit);
                                $($(".place_action")[id]).addClass("pointer");
                            } else {
                                $($(".place_action")[id]).html(action_alert);
                            }
                        }
                    })
                });
                $(".place_action_cancel_edit").live('click', function() {
                    var id = $(".place_action").index($(this).parent());
                    var name = $($(".place_name")[id]).children(".place_original").text();
                    $($(".place_name")[id]).text(name);
                    $($(".place_action")[id]).html(action_edit);
                });
                $(".place_action_delete").live('click', function() {
                    var id = $(".place_action").index($(this).parent());
                    var name = $($(".place_name")[id]).text();
                    var id_db = $($(".place_id")[id]).text();
                    $($(".place_action")[id]).removeClass("pointer");
                    $($(".place_action")[id]).html(action_loading);
                    if(confirm("Êtes-vous sûr de vouloir supprimer la place "+name+" ?")) {
                        $.ajax({
                            type: "POST",
                            url: "editPlaces.php",
                            data: "action=delete&id="+id_db,
                            success: function(msg) {
                                if($.trim(msg) == "ok") {
                                    $($(".place_div")[id]).fadeOut(1000, function() {
                                        $(this).remove();
                                    })
                                } else {
                                    $($(".place_action")[id]).html(action_alert);
                                }
                            }
                        })
                    } else {
                        $($(".place_action")[id]).html(action_edit);
                        $($(".place_action")[id]).addClass("pointer");
                    }
                });
                $("#refresh").click(function() {
                    window.location = "editplaces.php";
                });
            });
        </script>
    </head>
    <body>
        <?php include_once 'search.php';?>
        <h1>Gestion des lieux</h1>
        <table id="place_container">
            <?php foreach($places as $place): ?>
            <tr class="place_div"><td class="place_name"><?php echo $place->getName() ?></td><td class="place_action pointer"><img src="media/edit.png" alt="Éditer" class="place_action_edit" />&nbsp;<img src="media/delete.png" alt="Supprimer" class="place_action_delete" /></td><td class="place_id hidden"><?php echo $place->getId() ?></td></tr>
            <?php endforeach ?>
            <tr class="place_div" id="lastline"><td class="place_name"><input type="text" class="place_input" /></td></tr>
        </table>
        <p><button id="refresh">Rafraîchir</button></p>
    </body>
</html>
<?php endif ?>