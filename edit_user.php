<?php
session_start();
header("Content-Type:text/html;charset=utf8");

require_once ("config.php");
require_once ("functions.php");

if (!check_user()) {
    header("Location:index.php");
    exit();
}
$sess['sess'] = $_SESSION['sess'];
$role = role($sess);
if ($role['role'] !== '3') {
    unset($_SESSION['sess']);
    header("Location:index.php");
    exit();
}

if (isset($_POST['dell'])) {
    $msg = clean_com_work($_POST);
    if ($msg === TRUE) {
        $_SESSION['msg'] = "Данные удалены";
    }
    else {
        $_SESSION['msg'] = $msg;
    }    
}
if (isset($_POST['dell_add'])) {
    $msg = clean_add_work($_POST);
    if ($msg === TRUE) {
        $_SESSION['msg'] = "Данные удалены";
    }
    else {
        $_SESSION['msg'] = $msg;
    }
}

$posts = id_statti($_GET);
$post = completed_work($_GET);
$add_work = add_work($_GET);
$coef = coefficient($_GET);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="header">
            <div class="header-top">
                <div class="title">
                    <h1>Блокнот</h1>
                </div>
            </div>
        </div>
    </header>
    <section>
    	<? foreach ($posts as $item) :?>
        <div class="wrapper">
            <div class="edit-user">
                <div class="edit-user__title">
                    <div class="title">
                        <h1><?=$item['name'];?></h1>
                        <?=$_SESSION['msg'];?>
                        <? unset($_SESSION['msg']);?>
                    </div>
                </div>
                <div class="edit-user__cash">
                    <div class="cash">
                        <h2>Оклад: <span><?=$item['oklad'];?></span></h2>
                        <h2>Коэффициент: <span><?=$item['coefficient'];?></span></h2>
                        <h3> <a class="btn" href="create_coof.php?id=<?=$item['user_id'];?>">Изменить !!!</a></h3>
                    </div>
                </div>
                <div class="edit-user__coof">
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Коэффициент</th>
                                    <th>Комментарии</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($coef as $item) :?>
                                <tr>
                                    <td><?=$item['date_cof'];?></td>
                                    <td><?=$item['coff'];?></td>
                                    <td><?=$item['comm_cof'];?></td>
                                </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="edit-user__img"> </div>
                <div class="edit-user__inform">
                    <div class="title">
                        <? foreach ($posts as $item) :?>
                        <h2>Информация о сотруднике:</h2><span><a href="edit_inform-user.php?id=<?=$item['user_id'];?>">Редактировать !!!
                            </a></span>
                    </div>
                    <div class="box"></div>
                    <div class="birthday flex">
                        <h3>Дата рождения: </h3><span><?=$item['DR'];?></span>
                    </div>
                    <div class="hiring flex">
                        <h3>Дата найма: </h3><span><?=$item['DH'];?></span>
                    </div>
                    <div class="residence flex">
                        <h3>Место проживания: </h3><span><?=$item['info'];?></span>
                    </div>
                    <div class="comment flex">
                        <h3>Комментарии: </h3><span><?=$item['coment'];?></span>
                    </div>
                </div>
                <div class="edit-user__work">
                    <div class="title">
                        <div class="box">
                            <h3>Проделанная работа сотрудника: </h3>
                        </div><span><a class="btn" href="create_work.php?id=<?=$item['user_id'];?>">Добавить </a></span>
                        <? endforeach; ?>
                    </div>
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th> <span>Дата</span></th>
                                    <th> <span>Что сделал</span></th>
                                    <th> <span>Сумма</span></th>
                                    <th> <span>Комментарии</span></th>
                                    <th> <span>Оценка абонента</span></th>
                                    <th> <span>Редактировать</span></th>
                                    <th> <span>Удалить</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            	<? foreach ($post as $item) :?>
                                <tr>
                                    <td><?=$item['date'];?></td>
                                    <td><?=$item['type_work'];?></td>
                                    <td><?=$item['price'];?></td>
                                    <td><?=$item['comment'];?></td>
                                    <td><?=$item['grade'];?></td>
                                    <td> <a href="edit_work.php?id=<?=$item['user_id'];?>&comm=<?=$item['rec_num'];?>">Редактировать</a></td>
                                    <form method="POST" action="">
                                    <td><input type="hidden" name="dell" value="<?=$item['rec_num'];?>">
                                    <input type="submit" name="del" value="Удалить"/></td>
                                    </form>
                                </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="edit-user__prem">
                    <div class="title">
                        <div class="box">
                            <h3>Дополнительная работа:</h3>
                        </div><span> <a class="btn" href="create_prem.php?id=<?=$item['user_id'];?>">Добавить </a></span>
                    </div>
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th> <span>Дата</span></th>
                                    <th> <span>Что сделал</span></th>
                                    <th> <span>Сумма</span></th>
                                    <th> <span>Комментарии</span></th>
                                    <th> <span>Редактировать</span></th>
                                    <th><span>Удалить</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            	<? foreach ($add_work as $item) :?>
                                <tr>
                                    <td><?=$item['date'];?></td>
                                    <td><?=$item['add_work'];?></td>
                                    <td><?=$item['price'];?></td>
                                    <td><?=$item['comment'];?></td>
                                    <td> <a href="edit_prem.php?id=<?=$item['user_id'];?>&add=<?=$item['id'];?>">Редактировать</a></td>
                                    <form method="POST" action="">
                                    <td><input type="hidden" name="dell_add" value="<?=$item['id'];?>">
                                    <input type="submit" name="del" value="Удалить"/></td>
                                    </form>                                    
                                </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="edit-user__sort">
                    <div class="title">
                        <div class="box">
                            <h3>Сотировка работы:</h3>
                        </div><span> <a href="sort_cash.php?id=<?=$item['user_id'];?>"> Поиск</a></span>
                    </div>
                </div>
            </div>
        </div>
        <? endforeach; ?>
    </section>
    <footer>
        <div class="footer">
            <div class="footer__top"></div>
            <div class="footer__bot">
                <div class="bot"> <span>&COPY; Aledron</span></div>
            </div>
        </div>
    </footer>
    <script src="js/main.js"> </script>
</body>

</html>