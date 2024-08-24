<?php
/* PHP FILE LOCKER BY PUTTIPONG STUDIO */
/* PHP FILE LOCKER BY PUTTIPONG STUDIO */
/* PHP FILE LOCKER BY PUTTIPONG STUDIO */
/* PHP FILE LOCKER BY PUTTIPONG STUDIO */
/* PHP FILE LOCKER BY PUTTIPONG STUDIO */
/* PHP FILE LOCKER BY PUTTIPONG STUDIO */
/* PHP FILE LOCKER BY PUTTIPONG STUDIO */
/* PHP FILE LOCKER BY PUTTIPONG STUDIO */

if ((function_exists('session_status') && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
    @session_start();
}

function lock($password = "", $skin = 2, $options = array()) {
    global $tm;

    $locked = 1;
    $tries = 30;
    $page = "login";

    if (array_key_exists('skin', $options) && intval($options['skin']) > 1) {
        $skin = $options['skin'];
    }

    if (array_key_exists('password', $options)) {
        $password = $options['password'];
    }

    if (array_key_exists('tries', $options) && intval($options['tries']) > 1) {
        $tries = $options['tries'];
    }

    if (array_key_exists('bypass', $options) && is_array($options['bypass']) && in_array($_SERVER['REMOTE_ADDR'], $options['bypass'])) {
        $_SESSION['easylock'] = $password;
        $locked = 0;
    }

    if (array_key_exists('page', $options) && in_array($options['page'], array('login', 'redirect', 'custom'))) {
        $page = $options['page'];
    }

    if (isset($_POST['password']) && $_POST['password'] === $password) {
        $_SESSION['easylock'] = $password;
        $locked = 0;
    }

    if ($locked && (!isset($_SESSION['easylock']) || $_SESSION['easylock'] !== $password)) {
        echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Locked</title>
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAASpSURBVHja7JhNaFxVFIC/e997ySSvmUwmk2kDSTojwUz6GkrBunGjuGgrUgVBsMWVGwUXrrSoKLpUcFXcKG6EqK0/VHFZqIh/SAv9IaVRmmkVQojGplOdn3d/XHQyfZlJm5nONBbpgbc499133vfOueeec5+w1hKVw9PTtCDDwGPAHmACGAAcoABcBL4FPgNONWvwyf37V+kutyYJ4CDwLNC/xv0UkAUeBF4GvgZeAc62+iJ5C3C7gJ+Al24AVy8OsA/4GXiu1Ze16sGHgC/WALPAJeA3QAFDwDjQHZkTA96t3nvzdgDmgI/r4AxwGDgEnASKEbv3AAeA54Fk5Jk3gHngvU6H+BCQjuh/Ao8DTwHfReCoenEWeB24D/i+ztbb1Q/uGOAB4OGIfrWavV818ewc8AjwY2SsH3i1k4D1i/tg1WvNyjLwDHAlMvYEMNkJwO3A/RH9LPB+dIIxBq11w1UnM8AHdUmztxNJsgvwIvrnQHlF0Vqzqa+PLcPDSCmx1iKE4K+lJf5YXETKVT74BHghoj8AvNMSoDEGAYjrhuvD8EMtE5QiMTBALgjo6uoiWpU2Dw+Tv3CBS/k8juMghAA4B/wOjFSnjVejaKy1mEavN4Z4cvt2enw/GqJE3ZT5Fc8NplLkggDXdVFKNYR4azbL1mz22kZ5DX4ZuByxFQdcay1SSoZHRtb3YGpoiF7f59yZM/x99SqO64rVW7I1WmtGMxm2ZrMYazHGNBi21tYg++Jxzs/MoLVGShkt/tIaIxCC8YkJNm/Zsr4HwzAkFosxOTWFv2kTWmustbVLG8NY1TNaa+wacFFRSpEcHCQXBDiOgzGmZssYg5CSiclJhtJpKpVKc0mite6NxWKxyampy+dnZrrLpRJCCIwxjIyNxcey2ZhWqqfZPUYpxUAyaXLbtvHr7KxjjFlZkzI7Pp5IpdMlpVQI/FP/rKhvt/L5/NPAW0CPEEIbY3ytda2mep53xVqrANFyZyIlYRjGrbUOgBDCeJ63bIyR1Ur0YiaT+XA9wDkgU5sgRMPaakfWsZfPZDLZ9UIc7yTQWslzE4l3oh/cULkL2K64nTTmOA5SylrzcMcAOo6D4zgsLi5SKBToj8cZTKVQSq1ZZTYU0HEcisUiXx49yulTpyiVSvT09LBz504e3beP7u7utrzZ1hoUQmCt5aPpab45fpxyuYyUkmKxyLFjx/j0yBGEEA1734YBep7HL7OznDl9Gt/3kVIihMBxHHzf5+SJE8zNzeG6bucAV764mct1Xebn51FKNXhJCEGlUmFhYQHXdZu2ue4aXKujuFmIu7q6bhhCKSWe51Eul1uye1PApaWllor/UDpNIpGgUCjgeddPBmGlQiqVIplMsrCwcMvZ3NYaNMbQ39/P7r176e3trUEYY+iLx9m9Zw++77e11bRdScIwJAgCgiAgDMPa2I4dO7g3l6uN/aelTlc740jLAkJ0pJp0phZXW/hI9tztZv5f3YwQAqUUpVIJgFKpdG3zvlMAlVJkstladVFKMTo6ilLqzgHM5XIEQRA9ut42wCt1f0SbhuwA0HIzgK+tnIurv3g3KlmL1T+yq+TfAQBtouoCd5kXNwAAAABJRU5ErkJggg==">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .lock-container {
            text-align: center;
            background-color: #fff;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: float 3s ease-in-out infinite;
        }
        .lock-container img {
            width: 50px;
            margin-bottom: 20px;
        }
        .lock-container h1 {
            font-size: 24px;
            color: #d9534f;
            margin-bottom: 10px;
        }
        .lock-container p {
            color: #777;
            margin-bottom: 20px;
        }
        .lock-container input[type="password"] {
            padding: 10px;
            width: 80%;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .lock-container input[type="submit"] {
            padding: 10px 20px;
            background-color: #d9534f;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .lock-container input[type="submit"]:hover {
            background-color: #c9302c;
        }
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://maketline.github.io/goodday/font/stylesheet.css" type="text/css" charset="utf-8" />
<style>
        * {
	font-family: 'line_seed_sans_th';
}
</style>
    <div class="lock-container">
    <i class="fa-solid fa-lock fa-2xl" style="color: #df3030;"></i>
        <p><b><font style="color:#d9534f;font-size:30px">หน้าเพจนี้ถูกเข้ารหัส</font></b><br>หากคุณต้องการดูเนื้อหาภายใน กรุณากรอกรหัสผ่านที่เราได้ให้กับคุณไว้ เเละโปรดเก็บเป็นความลับ</p>
        <form method="post">
            <input type="password" name="password" placeholder="กรุณาป้อนรหัสผ่านที่นี่" required>
            <br>
            <input type="submit" value="ปลดล็อคเนื้อหา">
        </form><br>
        <small>โปรดเก็บรักษารหัสผ่านไว้เป็นความลับ<br>www.data.puttipong-studio.in.th</small>
    </div>
</body>
</html>
HTML;
        exit();
    }
}
?>
