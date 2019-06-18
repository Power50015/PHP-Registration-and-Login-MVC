<main>
    <div class="bg-img">
        <img src="../img/a-1644824-unsplash.jpg">
    </div>
    <h1 class="title">Register</h1>
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
            <form method="POST" action="/register" enctype="multipart/form-data">
                <input type="text" class="input" placeholder="Name" name="name" required value="<?= ($this->User_name) ?>">
                <input type="email" class="input" placeholder="Email" name="email" required value="<?= ($this->User_email) ?>">
                <input type="password" class="input" placeholder="Password" name="password1" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" title="Minimum 6 chars at least one letter and number">
                <input type="password" class="input" placeholder="Re-Password" name="password2" required>

                <div class="checkbox-section">
                    <label class="checkbox-text" for="Check"> Select image to upload:</label>
                    <input type="file" name="img" required>
                </div>
                <button type="submit" class="submit" name="submit">Register</button>
                <a href="/login" class="redurect-link">If you have an accunt click me</a>
            </form>

        </div>
    </div>
</main>