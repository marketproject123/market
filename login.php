<?php

$st = "";

if (isset($_POST['name']) && isset($_POST['phone'])) {
    $n = $_POST['name'];
    $h = $_POST['phone'];
    $a = $_POST['address'];
    $u = $_POST['username'];
    $p = $_POST['password'];

    include_once 'connect.php';

    $db->exec("INSERT INTO `users` (`id`, `name`, `phone`, `address`, `username`, `password`, `date`) VALUES (NULL, '$n', '$h', '$a', '$u', '$p', current_timestamp())");
    $st = "<span style='color: green'>تم تسجيل الدخول بنجاح الرجاء تسجيل الدخول</span>";
}elseif (isset($_POST['username']) && isset($_POST['password'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];


    include_once 'connect.php';

    $data = $db->query("SELECT * FROM `admin` WHERE `username` ='$u' AND `password` = '$p' ")->fetchall();


    if (count($data) > 0) {

        setcookie("pass", $data[0]["password"], time() + (86400 * 30), "/");
        setcookie("admin", $data[0]["name"], time() + (86400 * 30), "/");

        header("Location: admin.php");
    } else {
        $data = $db->query("SELECT * FROM `users` WHERE `username` ='$u' AND `password` = '$p' ")->fetchall();

        if (count($data) > 0) {
            // echo 12334;

            setcookie("name", $data[0]["name"], time() + (86400 * 30), "/");
            setcookie("phone", $data[0]["phone"], time() + (86400 * 30), "/");
            setcookie("address", $data[0]["address"], time() + (86400 * 30), "/");
            setcookie("user", $data[0]["username"], time() + (86400 * 30), "/");
            setcookie("pass", $data[0]["password"], time() + (86400 * 30), "/");

            header("Location: index.php");
        } else {
            $st = "<div> كلمة المرور او اسم المستخدم ليس صحيحا </div>";
        }
    }
} elseif (isset($_GET['logout'])) {
    setcookie("admin", null, -1, "/");
    setcookie("user", null, -1, "/");
    setcookie("pass", null, -1, "/");
    setcookie("name", null, -1, "/");
    setcookie("phone", null, -1, "/");
    setcookie("address", null, -1, "/");
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>متجر</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>
    <div class="app">
        <header>
            <div class="naves" style="justify-content: space-evenly">

                <span class="title">متجر مستلزمات منزلية</span>
                <span><a href="index.php">الصفحة الرئسية </a></span>
            </div>
        </header>


        <main>
            <div class="contener">
                <div class="pages-contener" style="display: block">
                    <div class="login">

                        <?php if (isset($_GET["sigin"])) { ?>
                            <h1>تسجيل  جديد</h1>
                            <form action="login.php" method="POST">
                                <div style='color:red;font-weight:bold;border:none;background:none'><?php echo $st ?></div>
                                
                                <label for="">اسم الزبون:</label>
                                <input type="text" name="name">

                                <label for="">رقم الهاتف:</label>
                                <input type="number" name="phone" value="+249">

                                
                                <label for="">عنوان الزبون:</label>
                                <input type="text" name="address">

                                <label for="">اسم المستخدم:</label>
                                <input type="text" name="username">
                                
                                <label for="">كلمة السر:</label>
                                <input type="password" name="password">
                                <br>
                                <button>تسجيل</button>
                            </form>
                        <?php } else { ?>
                            <h1>تسجيل الدخول بالموقع</h1>

                            <form action="login.php" method="POST">
                                <div style='color:red;font-weight:bold;border:none;background:none'><?php echo $st ?></div>
                                <label for="">اسم المستخدم:</label>
                                <input type="text" name="username">
                                <label for="">كلمة السر:</label>
                                <input type="password" name="password">
                                <br>
                                <button>تسجيل الدخول</button>
                                <label><a href="login.php?sigin" > تسجيل جديد </a></label>
                            </form>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

</html>