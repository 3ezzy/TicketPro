<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TickePro - Tableau de Bord</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0A4D68',    // Dark Blue
                        secondary: '#088395',   // Medium Blue
                        mint: '#05BFDB',       // Bright Mint
                        'mint-light': '#00FFCA' // Light Mint
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Include Navigation -->
    @include('layouts.navigation')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto p-8">
        @yield('content')
    </div>
</body>
</html>