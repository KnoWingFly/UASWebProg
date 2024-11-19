<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending Approval</title>
    @vite('resources/css/app.css') <!-- Ensure your Tailwind CSS is correctly linked -->
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-lg rounded-lg max-w-md mx-auto p-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">Account Pending Approval</h1>
        <p class="text-gray-600 mt-2">
            Your account is currently under review by an admin. You will be notified once your account is approved.
        </p>
        <a href="/logout" class="mt-6 inline-block bg-blue-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-700">
            Logout
        </a>
        <a href="/dashboard" class="mt-4 inline-block bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-indigo-700"></a>
    </div>
</body>
</html>
