<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventX | Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        h1 {
            font-size: 50px;
        }

        .hero {
            background-image: url({{asset('assets/img/bg2.png')}});
            height: 100vh;
            display: flex;
            align-items: center;
            color: white;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
        }

        .hero-content {
            max-width: 600px;
            margin-left: 50px;
        }
    </style>
</head>

<body>
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Effortless event planning with EventX!</h1></p>
                <a href="{{route('user.login')}}" class="btn btn-danger btn-lg me-3">User login</a>
                <a href="{{route('admin.login')}}" class="btn btn-danger btn-lg">Admin login</a>
        </div>
    </div>
</section>
</body>

</html>
