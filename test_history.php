<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];

// Fetch all history for this user
$stmt = $con->prepare("SELECT * FROM mh_history WHERE user_email=? ORDER BY date_taken DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Health Assessment History</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-5xl">

        <!-- BACK BUTTON -->
        <div class="mb-4">
            <a href="dashboard.php" class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
        </div>

        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-history text-blue-600 mr-3"></i>Your Mental Health Assessment History
            </h1>
            <p class="text-gray-600">Review your past mental wellness assessments</p>
        </div>

        <!-- HISTORY CARDS -->
        <?php if ($result->num_rows > 0): ?>
            <div class="space-y-6">
                <?php while ($row = $result->fetch_assoc()): 
                    $percent = round($row['score_total'] / 30 * 100, 1); // total possible 30

                    // Determine color scheme
                    if ($percent >= 80) {
                        $bgColor = 'bg-green-50';
                        $borderColor = 'border-green-200';
                        $badgeColor = 'bg-green-100 text-green-800';
                        $resultText = 'Excellent Mental Wellness';
                        $iconColor = 'text-green-600';
                    } elseif ($percent >= 50) {
                        $bgColor = 'bg-yellow-50';
                        $borderColor = 'border-yellow-200';
                        $badgeColor = 'bg-yellow-100 text-yellow-800';
                        $resultText = 'Moderate Mental Wellness';
                        $iconColor = 'text-yellow-600';
                    } else {
                        $bgColor = 'bg-red-50';
                        $borderColor = 'border-red-200';
                        $badgeColor = 'bg-red-100 text-red-800';
                        $resultText = 'Low Mental Wellness';
                        $iconColor = 'text-red-600';
                    }
                ?>
                    <div class="<?= $bgColor ?> border <?= $borderColor ?> rounded-lg p-6 shadow-sm">
                        <!-- Header with Date and Badge -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-gray-700">
                                <i class="far fa-calendar-alt mr-2 <?= $iconColor ?>"></i> 
                                <span class="font-semibold"><?= $row['date_taken'] ?></span>
                            </div>
                            <span class="<?= $badgeColor ?> px-3 py-1 rounded-full text-sm font-semibold"><?= $resultText ?></span>
                        </div>

                        <!-- Score Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-sm text-gray-600 mb-1">Total Score</div>
                                <div class="text-2xl font-bold text-gray-800">
                                    <?= $row['score_total'] ?> <span class="text-sm font-normal text-gray-500">/ 30</span>
                                </div>
                                <div class="text-sm text-gray-600 mt-1"><?= $percent ?>%</div>
                            </div>

                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-brain mr-1 text-blue-500"></i> Stress &amp; Anxiety
                                </div>
                                <div class="text-xl font-semibold text-gray-800"><?= $row['score_stress'] ?></div>
                            </div>

                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-smile mr-1 text-purple-500"></i> Mood &amp; Emotions
                                </div>
                                <div class="text-xl font-semibold text-gray-800"><?= $row['score_mood'] ?></div>
                            </div>

                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-bed mr-1 text-indigo-500"></i> Sleep &amp; Function
                                </div>
                                <div class="text-xl font-semibold text-gray-800"><?= $row['score_sleep'] ?></div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 text-lg">No history found.</p>
                <p class="text-gray-400 text-sm mt-2">Take your first assessment to see results here.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
