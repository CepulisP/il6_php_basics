<!DOCTYPE html>
<html>
<head><title>Our website</title></head>
<body>
<h2>Prisijungti</h2>
<form action="login.php" method="post">
    <input type="email" name="email" placeholder="john@gmail.com">
    <input type="password" name="password" placeholder="********">
    <input type="submit" value="Prisijungti">
</form>
<hr>
<h2> Registracijos forma</h2>
<form action="registration.php" method="post">
    <input type="text" name="first_name" placeholder="Vardas"><br>
    <input type="text" name="last_name" placeholder="Pavarde"><br>
    <input type="email" name="email" placeholder="emailas"><br>
    <input type="password" name="password1" placeholder="********"><br>
    <input type="password" name="password2" placeholder="********"><br>
    <input type="checkbox" name="agree_terms" id="agree_terms">
    <label for="agree_terms">Sutinku su registracijos taisyklemis.</label><br>
    <input type="submit" value="Registruotis">
</form>
</body>
</html>
