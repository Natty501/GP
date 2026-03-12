<?php
session_start();
include 'db.php';

if(!isset($_SESSION['2fa_email'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['2fa_email'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $code_entered = $_POST['sms_code'];

    // Fetch user
    $stmt = $con->prepare("SELECT sms_code, sms_code_expires FROM form WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user['sms_code'] == $code_entered && strtotime($user['sms_code_expires']) > time()){
        // Success
        $_SESSION['email'] = $email;

        // Clear 2FA code
        $stmt = $con->prepare("UPDATE form SET sms_code=NULL, sms_code_expires=NULL WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        unset($_SESSION['2fa_email']);

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid or expired code";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SMS Authentication</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-xl shadow-md w-96">
        <h2 class="text-2xl font-bold mb-4">SMS Authentication</h2>
        <p class="text-gray-600 mb-4">Enter the 6-digit code sent to your phone.</p>

        <?php if(isset($error)): ?>
            <p class="text-red-600 mb-4"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="sms_code" maxlength="6" placeholder="123456" class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Verify</button>
        </form>
    </div>
</body>
</html>
