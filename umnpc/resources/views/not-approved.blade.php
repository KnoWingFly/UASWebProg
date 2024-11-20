<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending Approval</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-lg rounded-lg max-w-md mx-auto p-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">Account Pending Approval</h1>
        <p class="text-gray-600 mt-2">
            Your account is currently under review by an admin. You will be notified once your account is approved.
        </p>

        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm 
        px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="window.location.href='/'">Back</button>

        <!-- <a href="/welcome" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm  -->
        <!-- px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"></a> -->
    </div>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</body>
</html>
