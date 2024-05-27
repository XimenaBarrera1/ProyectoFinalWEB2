<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD Panel</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .btn-lg-custom {
            padding: 50px 80px;
            font-size: 18px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">CRUD JUEGO 2</h1>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <a href="nivel.php" class="btn btn-primary btn-lg-custom">
                    <i class="fas fa-layer-group"></i> Niveles
                </a>
            </div>
            <div class="col-md-4">
                <a href="escenario.php" class="btn btn-success btn-lg-custom">
                    <i class="fas fa-map"></i> Escenarios
                </a>
            </div>
            <div class="col-md-4">
                <a href="contexto.php" class="btn btn-info btn-lg-custom">
                    <i class="fas fa-map-marked-alt"></i> Contextos
                </a>
            </div>
        </div>
    </div>
    <script src="../js/admin.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
