<!DOCTYPE html>
<html>
    <head>
        <title>Forms</title>
    </head>
    <body>
        <div class="header">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Some pages</a></li>
                <li><a href="#">Log in</a></li>
            </ul>
        </div>
        <div class="content">
            <h1>Our title</h1>
            <h2>Registracijos forma</h2>
            <form action="functions.php" method="post">
                <ul style="list-style-type: none">
                    <li><input type="text" name="name" placeholder="Vardas"></li>
                    <li><input type="text" name="name2" placeholder="Pavarde"></li>
                    <li><input type="email" name="email" placeholder="name@domain.com"></li>
                    <li><input type="password" name="pw1" placeholder="slaptazodis"></li>
                    <li><input type="password" name="pw2" placeholder="slaptazodis"></li>
                    <li><input type="submit" value="Registruotis" name="submit"></li>
                </ul>
<!--                <input type="text" name="email" placeholder="name@domain.com">-->
<!--                <input type="number" name="number">-->
<!--                <select name="operation">-->
<!--                    <option value=" "></option>-->
<!--                    <option value="+">+</option>-->
<!--                    <option value="-">-</option>-->
<!--                    <option value="*">*</option>-->
<!--                    <option value="/">/</option>-->
<!--                </select>-->
<!--                <input type="number" name="number2">-->
<!--                <input type="submit" value="OK" name="submit">-->
            </form>
        </div>
    </body>
</html>
