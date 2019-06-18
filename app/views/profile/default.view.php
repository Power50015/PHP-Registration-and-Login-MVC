<a href="/logout/" class="redurect-link m-5">Logout</a>
<main class="container">
    <?php
    if (isset($this->Errors)) {
        if (!empty($this->Errors)) {
            foreach ($this->Errors as $key => $value) {
                echo "<h4 class='alert alert-danger'>" . $value . "</h4>";
            }
        }
    }
    ?>
    <form class="row" method="POST" action="/profile/edit/" enctype="multipart/form-data">
        <div class="col-12 col-md-4 mt-5">
            <img src="<?= ('../upload/' . $this->User_img) ?>" class="w-100 h-250">
            <label class="checkbox-text" for="Check"> Select image to upload:</label>
            <input type="file" name="img" value="Upload img">
        </div>
        <div class="col-12 col-md-8 mt-5">
            <input type="text" class="input" placeholder="Name" name="name" value="<?= ($this->User_name) ?>">
            <input type="email" class="input" placeholder="Email" name="email" value="<?= ($this->User_email) ?>">
            <input type="password" class="input" placeholder="Password" name="password" required required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" title="Minimum 6 chars at least one letter and number">
        </div>
        <button type="submit" class="submit mt-5" name="submit">Edit</button>
    </form>
</main>