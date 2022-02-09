<div>
    <h2>Login</h2>
    <div class="form-wrapper">
        <?php
        echo $this->data['form'];
        if (isset($_SESSION['message'])){
            echo $_SESSION['message'];
        }
        ?>
    </div>
</div>