<?php
require_once('config.php');
require_once('autoload.php');
if(isset($_POST['action'])):
    switch($_POST['action']) {
        case 'add':
            $structure = new Model_Structure();
            $structure->setName($_POST['name']);
            $structure->save();
            echo 'ok/%/'.$structure->getId().'/%/'.$structure->getName();
            break;
        case 'edit':
            $structure = new Model_Structure($_POST['id']);
            $structure->setName($_POST['name']);
            $structure->save();
            echo 'ok/%/'.$structure->getName();
            break;
        case 'delete':
            $structure = new Model_Structure($_POST['id']);
            $structure->remove();
            echo 'ok';
            break;
    }
else: 
    $structures = Model_Structure::getAllStructures();
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
            var action_create = "<img src=\"media/add.png\" alt=\"Ajouter\" class=\"structure_action_add\" />";
            var action_edit = "<img src=\"media/edit.png\" alt=\"Éditer\" class=\"structure_action_edit\" />&nbsp;<img src=\"media/delete.png\" alt=\"Supprimer\" class=\"structure_action_delete\" />";
            var action_confirm = "<img src=\"media/confirm_edit.png\" alt=\"Confirmer\" class=\"structure_action_confirm_edit\" />&nbsp;<img src=\"media/cancel_edit.png\" alt=\"Annuler\" class=\"structure_action_cancel_edit\" />";
            var action_loading = "<img src=\"media/loading-mini.gif\" alt=\"Chargement\" />";
            var action_alert = "<img src=\"media/alert.png\" alt=\"Erreur\" />";
            $(document).ready(function() {
                $("#lastline").live('focus',function() {
                    $(this).removeAttr("id");
                    $(this).append("<td class=\"structure_action pointer\">"+action_create+"</td>");
                    $("#structure_container").append("<tr class=\"structure_div\" id=\"lastline\"><td class=\"structure_name\"><input type=\"text\" class=\"structure_input\" /></td></tr>")
                });
                $(".structure_action_add").live('click', function() {
                    var id = $(".structure_action").index($(this).parent());
                    $($(".structure_name")[id]).children(".structure_input").attr("disabled","disabled");
                    $($(".structure_action")[id]).removeClass("pointer");
                    $($(".structure_action")[id]).html(action_loading);
                    $.ajax({
                        type: "POST",
                        url: "editStructures.php",
                        data: "action=add&name="+$.trim($($(".structure_name")[id]).children(".structure_input").val()),
                        success: function(msg) {
                            msg = msg.split("/%/");
                            if($.trim(msg[0]) == "ok") {
                                $($(".structure_div")[id]).html("<td class=\"structure_name\">"+$.trim(msg[2])+"</td><td class=\"structure_action\">"+action_edit+"</td><td class=\"structure_id hidden\">"+msg[1]+"</td>");
                                $($(".structure_action")[id]).addClass("pointer");
                            } else {
                                $($(".structure_action")[id]).html(action_alert);
                            }
                        }
                    })
                });
                $(".structure_action_edit").live('click', function() {
                    var id = $(".structure_action").index($(this).parent());
                    var name = $($(".structure_name")[id]).text();
                    $($(".structure_name")[id]).html("<input type=\"text\" class=\"structure_input\" value=\""+name+"\" /><span class=\"structure_original hidden\">"+name+"</span>");
                    $($(".structure_action")[id]).html(action_confirm);
                });
                $(".structure_action_confirm_edit").live('click', function() {
                    var id = $(".structure_action").index($(this).parent());
                    var name = $($(".structure_name")[id]).children(".structure_input").val();
                    var id_db = $($(".structure_id")[id]).text();
                    $($(".structure_action")[id]).children(".structure_input").attr("disabled","disabled");
                    $($(".structure_action")[id]).removeClass("pointer");
                    $($(".structure_action")[id]).html(action_loading);
                    $.ajax({
                        type: "POST",
                        url: "editStructures.php",
                        data: "action=edit&id="+id_db+"&name="+name,
                        success: function(msg) {
                            msg = msg.split("/%/");
                            if($.trim(msg[0]) == "ok") {
                                $($(".structure_name")[id]).text($.trim(msg[1]));
                                $($(".structure_action")[id]).html(action_edit);
                                $($(".structure_action")[id]).addClass("pointer");
                            } else {
                                $($(".structure_action")[id]).html(action_alert);
                            }
                        }
                    })
                });
                $(".structure_action_cancel_edit").live('click', function() {
                    var id = $(".structure_action").index($(this).parent());
                    var name = $($(".structure_name")[id]).children(".structure_original").text();
                    $($(".structure_name")[id]).text(name);
                    $($(".structure_action")[id]).html(action_edit);
                });
                $(".structure_action_delete").live('click', function() {
                    var id = $(".structure_action").index($(this).parent());
                    var name = $($(".structure_name")[id]).text();
                    var id_db = $($(".structure_id")[id]).text();
                    $($(".structure_action")[id]).removeClass("pointer");
                    $($(".structure_action")[id]).html(action_loading);
                    if(confirm("Êtes-vous sûr de vouloir supprimer la structure "+name+" ?")) {
                        $.ajax({
                            type: "POST",
                            url: "editStructures.php",
                            data: "action=delete&id="+id_db,
                            success: function(msg) {
                                if($.trim(msg) == "ok") {
                                    $($(".structure_div")[id]).fadeOut(1000, function() {
                                        $(this).remove();
                                    })
                                } else {
                                    $($(".structure_action")[id]).html(action_alert);
                                }
                            }
                        })
                    } else {
                        $($(".structure_action")[id]).html(action_edit);
                        $($(".structure_action")[id]).addClass("pointer");
                    }
                });
                $("#refresh").click(function() {
                    window.location = "editStructures.php";
                });
            });
        </script>
    </head>
    <body>
        <?php include_once 'search.php';?>
        <h1>Gestion des structures</h1>
        <table id="structure_container">
            <?php foreach($structures as $structure): ?>
            <tr class="structure_div"><td class="structure_name"><?php echo $structure->getName() ?></td><td class="structure_action pointer"><img src="media/edit.png" alt="Éditer" class="structure_action_edit" />&nbsp;<img src="media/delete.png" alt="Supprimer" class="structure_action_delete" /></td><td class="structure_id hidden"><?php echo $structure->getId() ?></td></tr>
            <?php endforeach ?>
            <tr class="structure_div" id="lastline"><td class="structure_name"><input type="text" class="structure_input" /></td></tr>
        </table>
        <p><button id="refresh">Rafraîchir</button></p>
    </body>
</html>
<?php endif ?>