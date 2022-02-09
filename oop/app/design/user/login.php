<div>
    <h2>Login</h2>
    <div class="form-wrapper">
        <?php echo $this->data['form'];
        if (isset($this->data['message'])){
            echo $this->data['message'];
        }else{
            echo '?';
        }
        ?>
    </div>
</div>