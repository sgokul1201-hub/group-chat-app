<?php
session_start();
include "db.php";

$error = ""; // default

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashed);
    if ($stmt->fetch() && password_verify($password, $hashed)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        header("Location: chat.php");
        exit;
    } else {
        $error = "⚠️ Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - Future 2040</title>
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        color: #fff;
        overflow: hidden;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.05);
        padding: 40px;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        box-shadow: 0 0 30px rgba(0,255,255,0.2);
        width: 350px;
        text-align: center;
        animation: fadeIn 1.2s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-container h2 {
        margin-bottom: 20px;
        font-size: 26px;
        background: linear-gradient(90deg, #00f2fe, #4facfe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .login-container input {
        width: 90%;
        padding: 12px;
        margin: 10px 0 5px;
        border: none;
        border-radius: 10px;
        outline: none;
        background: rgba(255,255,255,0.1);
        color: #fff;
        font-size: 15px;
        box-shadow: inset 0 0 5px rgba(0,255,255,0.4);
        transition: 0.3s;
    }
    .login-container input:focus {
        background: rgba(0,255,255,0.1);
        box-shadow: 0 0 10px #00f2fe;
    }

    .login-container button {
        width: 100%;
        padding: 12px;
        margin-top: 15px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        background: linear-gradient(90deg, #00f2fe, #4facfe);
        color: #0f2027;
        box-shadow: 0 0 15px rgba(0,255,255,0.4);
        transition: all 0.3s ease;
    }
    .login-container button:hover {
        box-shadow: 0 0 25px #00f2fe;
        transform: scale(1.05);
    }

    .login-container a {
        display: block;
        margin-top: 15px;
        color: #00f2fe;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s;
    }
    .login-container a:hover {
        color: #4facfe;
    }

    /* 🔹 Error message right below inputs */
    .error {
        margin: 5px 0 10px;
        color: #ff4b5c;
        font-size: 13px;
        text-align: left;
        width: 90%;
        margin-left: auto;
        margin-right: auto;
        animation: shake 0.3s;
    }

    @keyframes shake {
        0% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        50% { transform: translateX(4px); }
        75% { transform: translateX(-4px); }
        100% { transform: translateX(0); }
    }
</style>
</head>
<body>
    <div class="login-container">
        <h2>🚀 Login</h2>
        <form method="post">
            <input type="text" name="username" placeholder="👤 Username" required>
            <input type="password" name="password" placeholder="🔒 Password" required>
            
            <!-- 🔹 Error message appears below password field -->
            <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

            <button type="submit">Login</button>
        </form>
        <a href="register.php">✨ Create account</a>
    </div>
</body>
</html>
