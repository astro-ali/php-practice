<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=ali_learning_php', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$title = '';
$description = '';
$price = '';

$errors = [];

function randomString($n) {
    $charactors = "0123456789abcdefghjiklmnstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $str = '';
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($charactors) - 1);
        $str .= $charactors[$index];
    }
    return $str;
}

// echo $_SERVER['REQUEST_METHOD'].'<br>';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');

    if(!$title) {
        $errors[] = 'Title is Required!';
    }

    if(!$price) {
        $errors[] = 'Price is Required!';
    }

    $statement = $pdo->prepare("INSERT INTO product
        (title, image, description, price, create_date)
        VALUES (:title, :image, :description, :price, :date)
    ");

    if(!is_dir('images')){
        mkdir('images');
    }

    if(empty($errors)){
        $image = $_FILES['image'] ?? null;
        $imagePath = '';
        if($image['name']){
            $imagePath = 'images/'.randomString(20).'/'.$image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', $date);
        $statement->execute();
        header('Location: index.php');
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="app.css">

    <title>Create New Product</title>
  </head>
  <body>
    <div id="my-php-app">
        <div class="container">
            <a href="index.php" class="btn btn-link btn-sm mt-3">Go Back Home</a>
        </div>
        <div class="container d-flex justify-content-start mt-2 pt-2 mb-2 border-top">
            <h3 class="font-weight-bold mb-3">Create new product</h3>
        </div>
        <div class="container errors">
            <?php if(!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo $error ?></div>
                    <?php endforeach; ?> 
                </div>
            <?php endif; ?>   
        </div>
        <div class="form-container container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image">
            </div>
            <div class="form-group">
                <label>Product Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $title ?>">
            </div>
            <div class="form-group">
                <label>Product Description</label>
                <textarea style="min-height: 140px;" name="description" class="form-control"><?php echo $description ?></textarea>
            </div>
            <div class="form-group">
                <label>Product Price</label>
                <input type="number" step=".01" name="price" class="form-control" value="<?php echo $price ?>">
            </div>
            <button type="submit" class="btn btn-primary mb-3">Submit</button>
        </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>