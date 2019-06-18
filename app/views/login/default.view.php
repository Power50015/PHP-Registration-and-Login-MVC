<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
    <!-- Grid Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap-grid.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="main.css">

    <title>Login</title>
</head>

<body>
    <main>
        <div class="bg-img">
            <img src="../img/a-1644824-unsplash.jpg">
        </div>
        <h1 class="title">Login</h1>
        <div class="container">
            <div class="login-box">
                <?php
                if (isset($this->Errors)) {
                    if (!empty($this->Errors)) {
                        foreach ($this->Errors as $key => $value) {
                            echo "<h4 class='alert alert-danger'>" . $value . "</h4>";
                        }
                    }
                }
                ?>
                <form method="POST" action="/login">
                    <input type="email" class="input" placeholder="Enter email" name="email" required>
                    <input type="password" class="input" placeholder="Password" name='password' required>
                    <div class="checkbox-section">
                        <input type="checkbox" class="checkbox" name="check" id="check" value="1">
                        <label class="checkbox-text" for="check">Remember me</label>
                    </div>
                    <button type="submit" class="submit" name="submit">Login</button>
                    <a href="/register" class="redurect-link">If you don't have an accunt click me</a>
                </form>

            </div>
        </div>
    </main>
</body>

</html>