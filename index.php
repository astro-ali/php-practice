<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=ali_learning_php', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search = $_GET['search'] ?? '';

if($search) {
    $statement = $pdo->prepare('SELECT * FROM product WHERE title LIKE :search ORDER BY create_date DESC');
    $statement->bindValue(':search', "%$search%");
} else {
    $statement = $pdo->prepare('SELECT * FROM product ORDER BY create_date DESC');
}

$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
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

    <title>Product CRUD</title>
  </head>
  <body>
      <div id="my-php-app">
        <div class="container d-flex justify-content-start mt-3 mb-2">
            <h3 class="font-weight-bold mb-3">Products Crud PHP App</h3>
        </div>
        <div class="container mb-3">
            <a href="create.php" style="width: fit-content; gap: 3px;" class="btn btn-success d-flex align-items-center justify-content-center"> <div>Create Product</div> <div><h4 class="m-0 p-o"><i class="bi bi-plus"></i></h4></div>   
            </a>
        </div>
        <div class="container">
            <form>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="<?php echo $search ?>" placeholder="Search For Products" name="search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary text-sm" type="submit">Search<i class="bi bi-search pl-2"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="container my-table border">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Price</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $index => $product): ?>
                    <tr>
                        <th scope="row"><?php echo $index + 1 ?></th>
                        <td>
                            <?php if($product['image']): ?>
                                <img src="<?php echo $product['image'] ?>" alt="Phone" height="40px" width="40px">
                            <?php else: ?>
                                <div>None</div>
                            <?php endif ?>   
                        </td>
                        <td><?php echo $product['title'] ?></td>
                        <td><?php echo $product['price'].'$' ?></td>
                        <td><?php echo $product['create_date'] ?></td>
                        <td>
                        <a href="update.php?id=<?php echo $product['id'] ?>" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil-square"></i>
                        </a>
                        <form class="d-inline-block" action="delete.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $product['id'] ?>" >
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>