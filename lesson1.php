<?php
// validate form data
if($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $productName = $_POST['product'];
    $descriptionName = $_POST['description'];
    $productPrice = $_POST['price'];

    if(empty($productName)) {
        $message['product'] = "Bạn phải nhập tên sản phẩm";
    }

    if(empty($descriptionName)) {
        $message['description'] = "Bạn phải mô tả sản phẩm";
    }

    if(empty($productPrice)) {
        $message['price'] = "Bạn phải nhập giá sản phẩm";
    }

    //test fileToUpload
    //Thư mục khi upload file
    $target_dir = 'images/';
    //Lấy file
    $file = $_FILES['fileToUpload'];
    //lấy tên file
    $file_name = $file['name'];

    
    //test file khi upload images
    if (($file['size'] > 2000000) || (empty($file['size']))) {
        $message['file'] = "Dung lượng file vượt quá 2MB và file không được để trống";
    }
    //tạo mảng test file images khi upload
    $img = ['jpg', 'jpeg', 'png', 'png','pdf'];
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    if (!in_array($ext, $img)) {
        $message['file'] = "File upload không phải là ảnh";
    }

    if(empty($message['file'])) {
        move_uploaded_file($file['tmp_name'], $target_dir.$file_name);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <title>Registration</title>
    <style>
    .tab__login {
        margin: 80px auto;
        width: 700px;
        height: auto;
        background-color: #ffffff;
        padding: 32px 42px;
        border-radius: 5px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .tab__login--title h4 {
        color: red;
        padding: 12px;
        font-size: 35px;
    }

    .login {
        margin-top: 12px;
    }

    .login__label {
        font-size: 20px;
        padding-bottom: 7px;
    }

    .login__sign--up--in {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .login__sign--up p {
        padding-top: 12px;
        margin: 0;
    }

    .login__sign--up a {
        text-decoration: none;
    }

    .btn-danger {
        margin-top: 12px;
        width: 100%;
        height: 50px;
    }
    </style>
</head>

<body>
    <div class="tab__login">
        <div class="tab__login--title text-center">
            <h4>Đăng kí</h4>
        </div>
        <form action="lesson1.php" method="post" enctype="multipart/form-data">
            <!-- username -->
            <div class="login login__form--username">
                <label for="" class="login__label"><b>Product name</b></label>
                <input type="text" name="product" class="form-control" placeholder="Username...">
                <span style="color:red">
                    <?= isset($message['product']) ? $message['product'] : "" ?>
                </span><br>
            </div>
            <!-- description -->
            <div class="login login__form--email">
                <label for="" class="login__label"><b>description</b></label>
                <input type="text" name="description" class="form-control" placeholder="Mô tả...">
                <span style="color:red">
                    <?= isset($message['description']) ? $message['description'] : "" ?>
                </span><br>
            </div>
            <!-- price -->
            <div class="login login__form--password">
                <label for="" class="login__label"><b>Price</b></label>
                <input type="text" name="price" class="form-control" placeholder="Price...">
                <span style="color:red">
                    <?= isset($message['price']) ? $message['price'] : "" ?>
                </span><br>
            </div>
            <!-- type product -->
            <div class="input-group my-3">
                <select class="form-select" id="inputGroupSelect02">
                    <option value="1" name="Ti vi">Tivi</option>
                    <option value="2" name="Tủ lanh">Tủ lạnh</option>
                    <option value="3" name="Máy tính">Máy tính</option>
                </select>
                <label class="input-group-text" for="inputGroupSelect02">Options</label>
            </div>
            <!-- file to upload -->
            <div class="mb-3">
                <label for="formFile" class="form-label">Chọn ảnh trên file của bạn</label>
                <input class="form-control" type="file" id="formFile" name="fileToUpload">
                <span style="color:red">
                    <?= $message['file'] ?? '' ?>
                </span>
            </div>
            <!-- login -->
            <div class="login__sign--up--in">
                <div class="login login__form--check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember"> Accept our Terms and
                        Conditions.
                    </label>
                </div>
                <div class="login__sign--up">
                    <p>Already have an account? <a href="/login_sign_in/index.html">Sign in</a></p>
                </div>
            </div>
            <div class="login login__form--submit">
                <button type="submit" class="btn btn-danger" name="btn_submit">Mua hàng</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>