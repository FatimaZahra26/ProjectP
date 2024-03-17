<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WiseWalletPro</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body{
            background-color:#9ac5ef;
        }
        /* Style the navigation menu */
        .navbar {
            overflow: hidden;
            background-color:#13335b;
            height: 60px;
            display: flex;
            justify-content: space-between; /* Align items horizontally */
            align-items: center; /* Align items vertically */
            padding: 0 20px; /* Add padding to the sides */
        }
        /* Navigation links */
        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 14px 20px;
            font-family:unset;
        }
        /* Right-aligned links */
        .navbar a.right {
            float: right;
        }
        /* Change the background color on hover */
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        /* Hide the link that should open and close the navbar on small screens */
        .navbar a.icon {
            display: none;
        }
        /* Dropdown container */
        .dropdown {
            position: relative; /* Position relative for dropdown positioning */
        }
        /* Dropdown button */
        .dropdown .dropbtn {
            font-size: 16px;
            border: none;
            outline: none;
            color: white;
            padding: 14px 20px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
        }
        /* Add a red background color to navbar links on hover */
        .dropdown:hover .dropbtn {
            background-color: #ddd;
            color: black;
        }
        /* Dropdown content (hidden by default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 160px;
            z-index: 1;
            top: 100%; /* Position dropdown below its parent */
            left: 0; /* Align dropdown with its parent */
        }
        /* Links inside the dropdown */
        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }
        /* Add a grey background color to dropdown links on hover */
        .dropdown-content a:hover {
            background-color: #ddd;
            color: black;
        }
        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }
        /* Media query for responsiveness - display the navbar links vertically instead of horizontally on small screens */
        @media screen and (max-width: 600px) {
            .navbar {
                flex-direction: column; /* Align items vertically on small screens */
                height: auto; /* Auto height for flexible layout */
            }
            .navbar a {
                padding: 14px 0; /* Adjust padding for vertical layout */
            }
            .navbar a.right {
                float: none; /* Remove float for vertical layout */
                text-align: center; /* Align center for vertical layout */
            }
            .navbar a.icon {
                display: block; /* Show toggle icon */
            }
            /* Style the navbar links that are displayed on small screens */
            .navbar a.icon {
                padding: 14px 20px;
            }
        }
        /* Logo style */
        .logo {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }
        
    .content-container {
        padding: 20px;
        background-color: #1461ae;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        
        margin-left: 100px;
        margin-top: 100px;
        width: 37%;
    }
    .content-container1{
        padding: 20px;
       
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        
        margin-left: 100px;
        margin-top: 100px;
        width: 37%;
    }

    .content-container h2 {
        color: #150a50;
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .content-container p {
        padding-top: 20px;
        font-size: 16px;
        line-height: 1.5;
        color: #e8edf7;
    }

.container{
    display: flex;
}
    </style>
</head>
<body class="antialiased">
    <div class="navbar">
        <!-- Logo section -->
        <a href="#" class="logo" style="display: flex; margin-left:0px;"><img src="{{ asset('assets/walleticon.png') }}" alt="Example Image" style="width:50px; margin-right:25px;height:50px;margin-top:5px">
            <h3>WiseWalletPro</h3></a>
        <!-- Navigation links -->
        
        
        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
            <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline" style="color:#edf2f7">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline" style="color:#edf2f7">Log in</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline" style="color:#edf2f7">Register</a>
            @endif
            @endauth
        </div>
        @endif
    </div>
    <!-- Content goes here -->
    <div class="container">
    <div class="content-container">
        <h2>Empower Your Finances with Smart Budgeting and Saving Optimization</h2>
        <p>Discover our features, optimize savings, and transform financial aspirations into reality with WiseWalletPro. We support you through every step of household budgeting and expense management.</p>
        <p>With our intuitive tools and personalized insights, you can gain full control over your finances and make informed decisions to achieve your financial goals.</p>
        
    </div>
    <div class="content-container1">
        <img src="{{ asset('assets/home.png') }}" alt="Example Image">

        
    </div>
    
    <div>
</body>
</html>
