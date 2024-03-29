<?php
ob_start();
session_start();
include("./model/pdo.php");
include("./model/danhmuc.php");
include("./model/sanpham.php");
include("./model/binhluan.php");
include("./model/wlandcart.php");
include("./model/taikhoan.php");
include("view/header.php");

$spnew = list_spnew_home();
$dsdm = list_danhmuc();
if((isset($_GET['act'])) && ($_GET['act'] != "")) {
    $act = $_GET['act'];
    switch($act) {
        case 'sigorreg':
            if(isset($_POST['register']) && ($_POST['register'])) {
                $tensohuu = $_POST['tensohuu'];
                $username = $_POST['username'];
                $pass = $_POST['pass'];
                $xnpass = $_POST['xnpass'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $diachi = $_POST['diachi'];
                $vaitro = $_POST['vaitro'];

                if($pass == $xnpass) {
                    insert_taikhoan($tensohuu, $username, $pass, $email, $phone, $diachi);
                } else {
                    $tb = "Mật khẩu không trùng khớp!";
                }
            } else if(isset($_POST['signin']) && ($_POST['signin'])) {
                $username = $_POST['username'];
                $pass = $_POST['pass'];

                $checkuser = check_user($username, $pass);
                if(is_array($checkuser)) {
                    $_SESSION['username'] = $checkuser;
                    header('Location: index.php');
                    // exit;
                } else {
                    echo "sai tài khoản";
                }
            }
            include('view/taikhoan/sigorreg.php');
            break;

        case 'myacc':
            include('view/taikhoan/my-account.php');
            break;

        case 'logout':
            session_unset();
            header('Location: index.php');
            break;

        case 'capnhattt':
            if(isset($_POST['updateacc']) && ($_POST['updateacc'])) {
                $tennew = $_POST['tennew'];
                $usernew = $_POST['usernew'];
                $emailnew = $_POST['emailnew'];
                $telnew = $_POST['telnew'];
                $diachinew = $_POST['diachinew'];
                $passnew = $_POST['passnew'];
                $xnpassnew = $_POST['xnpassnew'];
                $idtk = $_POST['idtk'];

                if($passnew == $xnpassnew && $tennew != "" && $usernew != "" && $emailnew != "" && $telnew != "" && $diachinew != "" && $passnew != "") {
                    update_taikhoan($tennew, $usernew, $passnew, $emailnew, $telnew, $diachinew, $idtk);
                    session_unset();
                    header('Location: ?act=sigorreg');
                    break;
                } else {
                    $tb = "Mật khẩu không trùng khớp hoặc thông tin trống!";
                }
            }
            include('view/taikhoan/my-account.php');
            break;

        case 'wlist':
            if(isset($_GET['idsp']) && isset($_GET['idact'])) {
                $idsp = $_GET['idsp'];
                $idact = $_GET['idact'];
                insert_wlist($idsp, $idact);
            }
            $dssp = listall_sp(null, null);
            $listwl = list_yeutich();
            include('view/cart/wishlist.php');
            break;

        case 'delyt':
            if(isset($_GET['idyt'])) {
                $idyt = $_GET['idyt'];
                del_yeuthich($idyt);
            }
            $dssp = listall_sp(null, null);
            $listwl = list_yeutich();
            include('view/cart/wishlist.php');
            break;

        case 'cart':
            if(!isset($_SESSION['giohang'])) {
                $_SESSION['giohang'] = [];
            }
            if(isset($_POST['addgio']) && ($_POST['addgio'])) {
                $IDSP = $_POST['idsp'];
                $IMGSP = $_POST['imgsp'];
                $TENSP = $_POST['tensp'];
                $GIASP = $_POST['giasp'];
                $SIZESP = $_POST['sizesp'];
                $SOLUONGSP = $_POST['soluongsp'];

                $fl = 0; // kiểm tra xem sản phẩm thêm mới đã tồn tại trong giỏ hàng chưa 0= chưa, 1 = đã có
                // kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
                for($i = 0; $i < count($_SESSION['giohang']); $i++) {
                    if($_SESSION['giohang'][$i][2] == $TENSP) {
                        $fl = 1;
                        $SOLUONGNEW = $SOLUONGSP + $_SESSION['giohang'][$i][5];
                        $_SESSION['giohang'][$i][5] = $SOLUONGNEW;
                        $_SESSION['giohang'][$i][4] = $SIZESP;
                        break;
                    }
                }

                // nếu sản phẩm không trùng thì tiến hành thêm mới
                if($fl == 0) {
                    // thêm mới sản phẩm
                    $sp = array($IDSP, $IMGSP, $TENSP, $GIASP, $SIZESP, $SOLUONGSP);
                    array_push($_SESSION['giohang'], $sp);
                }
                header('Location: ?act=cart');
            }
            include('view/cart/viewcart.php');
            break;

        case 'linkdelspid':
            if(isset($_GET['delsp']) && $_GET['delsp'] >= 0) {
                array_splice($_SESSION['giohang'], $_GET['delsp'], 1);
            }
            include('view/cart/viewcart.php');
            break;

        case 'delcart':
            if(isset($_GET['del']) && $_GET['del'] == 1) {
                unset($_SESSION['giohang']);
            }
            include('view/cart/viewcart.php');
            break;

        case 'danhmuc':
            if((isset($_POST['kyw'])) && ($_POST['kyw'] != "")) {
                $kyw = $_POST['kyw'];
            } else {
                $kyw = "";
            }
            if((isset($_GET['iddm'])) && ($_GET['iddm'] > 0)) {
                $iddm = $_GET['iddm'];

            } else {
                $iddm = 0;
            }
            $dssp = listall_sp($kyw, $iddm);
            $tendm = load_ten_dm($iddm);
            include('view/sanpham/sanpham.php');
            break;

        case 'sanpham':
            if((isset($_POST['kyw'])) && ($_POST['kyw'] != "")) {
                $kyw = $_POST['kyw'];
            } else {
                $kyw = "";
            }
            if((isset($_GET['iddm'])) && ($_GET['iddm'] > 0)) {
                $iddm = $_GET['iddm'];
            } else {
                $iddm = 0;
            }
            $ten_dm = load_ten_dm($iddm);
            $dssp = listall_sp($kyw, $iddm);
            include('view/sanpham/sanpham.php');
            break;

        case 'sanphamct':
            $listsizesp = listall_size();
            $dssp = listall_sp(null, null);
            include('view/sanpham/sanphamct.php');
            break;

        case 'faq':
            include('view/hotro/faq.php');
            break;

        case 'gioithieu':
            include('view/hotro/gioithieu.php');
            break;

        case 'lienhe':
            include('view/hotro/lienhe.php');
            break;

        default:
            $dssp = listall_sp("", 0);
            include('view/home.php');
            break;
    }
} else {
    $dssp = listall_sp("", 0);
    include('view/home.php');
}
include('view/footer.php');
ob_end_flush();
?>