<?php
include "app.php";
include "conn.php";
// check login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM `users` WHERE `username` = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user'] = $row['username'];
            header("Location: admin.php");
        } else {
            echo "<script>alert('Password errata')</script>";
            echo "<script>window.location.href = ''</script>";
        }
    } else {
        echo "<script>alert('Utente non trovato')</script>";
        echo "<script>window.location.href = ''</script>";
    }
}
?>

<body>
    <div class="container vcenter">
        <h1>Login</h1>
        <form action="#" method="post">
            <input required type="text" name="username" id="username" placeholder="Username">
            <input required type="password" name="password" id="password" placeholder="Password">
            <input type="submit" value="Login" class="btn">
        </form>
    </div>
</body>