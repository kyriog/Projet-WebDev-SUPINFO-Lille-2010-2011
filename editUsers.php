<?php
session_start();
require_once('config.php');
require_once('autoload.php');
Helper_Access::rejectIfLogout();
if(isset($_POST['action'])):
    switch($_POST['action']) {
        case 'add':
            $user = new Model_User();
            $user->setPassword($_POST['password']);
            $user->setLname($_POST['lname']);
            $user->setFname($_POST['fname']);
            $user->setPhone($_POST['phone']);
            $user->save();
            echo 'ok/%/'.$user->getId().'/%/'.$user->getLname().'/%/'.$user->getFname().'/%/'.$user->getPhone();
            break;
        case 'updatePassword':
            $user = new Model_User($_POST['id']);
            $user->setPassword($_POST['password']);
            $user->save();
            echo 'ok';
            break;
        case 'updateUser':
            $user = new Model_User($_POST['id']);
            $user->setLname($_POST['lname']);
            $user->setFname($_POST['fname']);
            $user->setPhone($_POST['phone']);
            $user->save();
            echo 'ok/%/'.$user->getLname().'/%/'.$user->getFname().'/%/'.$user->getPhone();
            break;
        case 'delete':
            $user = new Model_User($_POST['id']);
            $user->remove();
            echo 'ok';
            break;
    }
else:
    $users = Model_User::getAllUsers();
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
            .center {
                text-align: center;
            }
        </style>
        <script type="text/javascript" src="jquery-1.6.1.min.js"></script>
        <script type="text/javascript">
            var action_loading = "<img src=\"media/loading-mini.gif\" alt=\"Chargement\" />";
            var action_alert = "<img src=\"media/alert.png\" alt=\"Erreur\" />";
            var action_create = "<img src=\"media/add.png\" alt=\"Ajouter\" class=\"user_action_add\" />";
            var action_edit = "<img src=\"media/edit.png\" alt=\"Éditer\" class=\"user_action_edit\" />&nbsp;<img src=\"media/delete.png\" alt=\"Supprimer\" class=\"user_action_delete\" />";
            var action_confirm = "<img src=\"media/confirm_edit.png\" alt=\"Confirmer\" class=\"user_action_confirm\" />&nbsp;<img src=\"media/cancel_edit.png\" alt=\"Annuler\" class=\"user_action_cancel\" />";
            $(document).ready(function() {
                $("#lastline").live('focus',function() {
                    $(this).removeAttr("id");
                    $(this).append("<td class=\"user_action pointer\">"+action_create+"</td>");
                    $("#user_container").append("\n\
            <tr class=\"user_line\" id=\"lastline\">\n\
                <td class=\"user_id\"></td>\n\
                <td class=\"user_password\"><input type=\"password\" class=\"user_input_password1\" /><input type=\"password\" class=\"user_input_password2\" /><span class=\"user_password_info\"></span></td>\n\
                <td class=\"user_lname\"><input type=\"text\" class=\"user_input_lname\" /></td>\n\
                <td class=\"user_fname\"><input type=\"text\" class=\"user_input_fname\" /></td>\n\
                <td class=\"user_phone\"><input type=\"text\" class=\"user_input_phone\" /></td>\n\
            </tr>");
                });
                $(".user_action_add").live('click',function() {
                    var id = $(".user_action").index($(this).parent());
                    var password1 = $($(".user_password")[id]).children(".user_input_password1").val();
                    var password2 = $($(".user_password")[id]).children(".user_input_password2").val();
                    var lname = $($(".user_lname")[id]).children(".user_input_lname").val();
                    var fname = $($(".user_fname")[id]).children(".user_input_fname").val();
                    var phone = $($(".user_phone")[id]).children(".user_input_phone").val();
                    if(password1 == password2) {
                        $($(".user_password")[id]).children(".user_input_password1").attr("disabled","disabled");
                        $($(".user_password")[id]).children(".user_input_password2").attr("disabled","disabled");
                        $($(".user_lname")[id]).children(".user_input_lname").attr("disabled","disabled");
                        $($(".user_fname")[id]).children(".user_input_fname").attr("disabled","disabled");
                        $($(".user_phone")[id]).children(".user_input_phone").attr("disabled","disabled");
                        $($(".user_action")[id]).removeClass("pointer");
                        $($(".user_action")[id]).html(action_loading);
                        $.ajax({
                            type: "POST",
                            url: "editUsers.php",
                            data: "action=add&password="+password1+"&lname="+lname+"&fname="+fname+"&phone="+phone,
                            success: function(msg) {
                                msg = msg.split("/%/");
                                if($.trim(msg[0]) == "ok") {
                                    $($(".user_id")[id]).text($.trim(msg[1]));
                                    $($(".user_password")[id]).addClass("center");
                                    $($(".user_password")[id]).html("<button class=\"user_password_reset\">Réinitialiser le mot de passe</button>");
                                    $($(".user_lname")[id]).text($.trim(msg[2]));
                                    $($(".user_fname")[id]).text($.trim(msg[3]));
                                    $($(".user_phone")[id]).text($.trim(msg[4]));
                                    $($(".user_action")[id]).addClass("pointer");
                                    $($(".user_action")[id]).html(action_edit);
                                } else {
                                    $($(".user_action")[id]).html(action_alert);
                                }
                            }
                        });
                    } else {
                        $($(".user_password")[id]).children(".user_password_info").html("<img src=\"media/alert.png\" alt=\"Erreur\" title=\"Les mots de passe ne sont pas identiques\" />");
                    }
                });
                $(".user_password_reset").live('click',function() {
                    var id = $(".user_password").index($(this).parent());
                    $($(".user_password")[id]).html("<input type=\"password\" class=\"user_input_password1\" /><input type=\"password\" class=\"user_input_password2\" /><span class=\"user_password_info\"></span><span class=\"user_password_action pointer\"><img src=\"media/confirm_edit.png\" class=\"user_password_confirm\" />&nbsp;<img src=\"media/cancel_edit.png\" class=\"user_password_cancel\" /></span>");
                });
                $(".user_password_confirm").live('click',function() {
                    var id = $(".user_password").index($(this).parent().parent());
                    var id_db = $($(".user_id")[id]).text();
                    var password1 = $($(".user_password")[id]).children(".user_input_password1").val();
                    var password2 = $($(".user_password")[id]).children(".user_input_password2").val();
                    if(password1 == password2) {
                        $($(".user_password")[id]).children(".user_input_password1").attr("disabled","disabled");
                        $($(".user_password")[id]).children(".user_input_password2").attr("disabled","disabled");
                        $($(".user_password")[id]).children(".user_password_info").remove();
                        $($(".user_password")[id]).children(".user_password_action").removeClass("pointer");
                        $($(".user_password")[id]).children(".user_password_action").html(action_loading);
                        $.ajax({
                            type: "POST",
                            url: "editUsers.php",
                            data: "action=updatePassword&id="+id_db+"&password="+password1,
                            success: function(msg) {
                                if($.trim(msg) == "ok") {
                                    var timer = 600;
                                    $($(".user_password")[id]).fadeOut(timer, function() {
                                        $(this).html("<img src=\"media/valid.png\" alt=\"V\" /> Mot de passe réinitialisé avec succès <img src=\"media/valid.png\" alt=\"V\" />");
                                        $(this).fadeIn(timer, function() {
                                            $(this).fadeOut(timer, function() {
                                                $(this).fadeIn(timer, function() {
                                                    $(this).fadeOut(timer, function() {
                                                        $(this).html("<button class=\"user_password_reset\">Réinitialiser le mot de passe</button>");
                                                        $(this).fadeIn(timer);
                                                    });
                                                });
                                            });
                                        });
                                    });
                                } else {
                                    $($(".user_password")[id]).children(".user_password_action").html(action_alert);
                                }
                            }
                        })
                    } else {
                        $($(".user_password")[id]).children(".user_password_info").html("<img src=\"media/alert.png\" alt=\"Erreur\" title=\"Les mots de passe ne sont pas identiques\" />");
                    }
                });
                $(".user_password_cancel").live('click',function() {
                    var id = $(".user_password").index($(this).parent().parent());
                    $($(".user_password")[id]).html("<button class=\"user_password_reset\">Réinitialiser le mot de passe</button>");
                })
                $(".user_action_edit").live('click', function() {
                    var id = $(".user_action").index($(this).parent());
                    var lname = $($(".user_lname")[id]).text();
                    var fname = $($(".user_fname")[id]).text();
                    var phone = $($(".user_phone")[id]).text();
                    $($(".user_lname")[id]).html("<input type=\"text\" class=\"user_input_lname\" value=\""+lname+"\" /><span class=\"user_lname_original hidden\">"+lname+"</span>");
                    $($(".user_fname")[id]).html("<input type=\"text\" class=\"user_input_fname\" value=\""+fname+"\" /><span class=\"user_fname_original hidden\">"+fname+"</span>");
                    $($(".user_phone")[id]).html("<input type=\"text\" class=\"user_input_phone\" value=\""+phone+"\" /><span class=\"user_phone_original hidden\">"+phone+"</span>");
                    $($(".user_action")[id]).html(action_confirm);
                });
                $(".user_action_confirm").live('click', function() {
                    var id = $(".user_action").index($(this).parent());
                    var id_db = $($(".user_id")[id]).text();
                    var lname = $($(".user_lname")[id]).children(".user_input_lname").val();
                    var fname = $($(".user_fname")[id]).children(".user_input_fname").val();
                    var phone = $($(".user_phone")[id]).children(".user_input_phone").val();
                    $($(".user_lname")[id]).children(".user_input_lname").attr("disabled","disabled");
                    $($(".user_fname")[id]).children(".user_input_fname").attr("disabled","disabled");
                    $($(".user_phone")[id]).children(".user_input_phone").attr("disabled","disabled");
                    $($(".user_action")[id]).removeClass("pointer");
                    $($(".user_action")[id]).html(action_loading);
                    $.ajax({
                        type: "POST",
                        url: "editUsers.php",
                        data: "action=updateUser&id="+id_db+"&lname="+lname+"&fname="+fname+"&phone="+phone,
                        success: function(msg) {
                            msg = msg.split("/%/");
                            if($.trim(msg[0]) == "ok") {
                                $($(".user_lname")[id]).text($.trim(msg[1]));
                                $($(".user_fname")[id]).text($.trim(msg[2]));
                                $($(".user_phone")[id]).text($.trim(msg[3]));
                                var timer = 1000;
                                $($(".user_action")[id]).fadeOut(timer, function() {
                                    $($(".user_action")[id]).html("<img src=\"media/valid.png\" alt=\"V\" /> Utilisateur mis à jour avec succès");
                                    $($(".user_action")[id]).fadeIn(timer, function() {
                                        $($(".user_action")[id]).fadeOut(timer, function() {
                                            $($(".user_action")[id]).addClass("pointer");
                                            $($(".user_action")[id]).html(action_edit);
                                            $($(".user_action")[id]).fadeIn(timer);
                                        });
                                    });
                                });
                            } else {
                                $($(".user_action")[id]).html(action_alert);
                            }
                        }
                    });
                });
                $(".user_action_cancel").live('click', function()  {
                    var id = $(".user_action").index($(this).parent());
                    var lname = $($(".user_lname")[id]).children(".user_lname_original").text();
                    var fname = $($(".user_fname")[id]).children(".user_fname_original").text();
                    var phone = $($(".user_phone")[id]).children(".user_phone_original").text();
                    $($(".user_lname")[id]).text(lname);
                    $($(".user_fname")[id]).text(fname);
                    $($(".user_phone")[id]).text(phone);
                    $($(".user_action")[id]).html(action_edit);
                });
                $(".user_action_delete").live('click', function() {
                    var id = $(".user_action").index($(this).parent());
                    var id_db = $($(".user_id")[id]).text();
                    $($(".user_action")[id]).removeClass("pointer");
                    $($(".user_action")[id]).html(action_loading);
                    if(confirm("Êtes-vous sûr de vouloir supprimer l'utilisateur n°"+id_db+" ?")) {
                        $.ajax({
                            type: "POST",
                            url: "editUsers.php",
                            data: "action=delete&id="+id_db,
                            success: function(msg) {
                                $($(".user_line")[id]).fadeOut(1000,function() {
                                    $(this).remove();
                                })
                            }
                        });
                    } else {
                        $($(".user_action")[id]).addClass("pointer");
                        $($(".user_action")[id]).html(action_edit);
                    }
                });
            })
        </script>
    </head>
    <body>
        <?php include_once 'search.php';?>
        <h1>Gestion des utilisateurs</h1>
        <table id="user_container">
            <thead>
                <th>id</th>
                <th>Mot de passe</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr class="user_line">
                    <td class="user_id"><?php echo $user->getId() ?></td>
                    <td class="user_password center"><button class="user_password_reset">Réinitialiser le mot de passe</button></td>
                    <td class="user_lname"><?php echo $user->getLname() ?></td>
                    <td class="user_fname"><?php echo $user->getFname() ?></td>
                    <td class="user_phone"><?php echo $user->getPhone() ?></td>
                    <td class="user_action pointer"><img src="media/edit.png" alt="Éditer" class="user_action_edit" />&nbsp;<img src="media/delete.png" alt="Supprimer" class="user_action_delete" /></td>
                </tr>
                <?php endforeach ?>
                <tr class="user_line" id="lastline">
                    <td class="user_id"></td>
                    <td class="user_password"><input type="password" class="user_input_password1" /><input type="password" class="user_input_password2" /><span class="user_password_info"></span></td>
                    <td class="user_lname"><input type="text" class="user_input_lname" /></td>
                    <td class="user_fname"><input type="text" class="user_input_fname" /></td>
                    <td class="user_phone"><input type="text" class="user_input_phone" /></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
<?php endif ?>