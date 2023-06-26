<?php
include "conn.php";
include "app.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO `users`(`username`, `password`) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
}
?>

<body>
    <div class="container">
        <h1>Registrazione utente</h1>
        <form action="#" method="post">
            <input type="text" name="username" id="username" placeholder="Username">
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="submit" value="Registrati" class="btn">
        </form>
    </div>
</body>