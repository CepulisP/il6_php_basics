<?php include 'parts/header.php' ?>
                <form action="submitted.php" method="post">
                    <input type="text" name="name" placeholder="Name"><br>
                    <input type="text" name="lastName" placeholder="Last Name"><br>
                    <input type="email" name="email" placeholder="name@email.com"><br>
                    <input type="password" name="pass1" placeholder="Password"><br>
                    <input type="password" name="pass2" placeholder="Repeat password"><br>
                    <input type="tel" name="phone" placeholder="+370xxxxxxxx"><br>
                    <select name="city">
                        <option value="1">Vilnius</option>
                        <option value="2">Klaipeda</option>
                        <option value="3">Panevezys</option>
                        <option value="4">Jonava</option>
                        <option value="5">Kaunas</option>
                    </select><br>
                    <input type="submit" value="create" name="createUser">
                </form>
<?php include 'parts/footer.php' ?>