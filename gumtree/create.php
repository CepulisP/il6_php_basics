<?php include 'parts/header.php'; ?>
    <h2>Create new ad</h2>
    <form action="submitted.php" method="post">
        <input type="text" name="title" placeholder="title"><br>
        <textarea name="content"></textarea><br>
        <input type="number" step="0.01" name="price" placeholder="xxx$"><br>
        <select name="year">
            <?php for ($i = 1990; $i <= date('Y'); $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            } ?>
        </select>
        <br>
        <input type="submit" value="create" name="createAd">
    </form>
<?php include 'parts/footer.php'; ?>