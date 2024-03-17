@extends('layouts.app')
@php
    use App\Models\Tag;
@endphp
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

<div class="sidebar">
    <div class="profile">
           
        <h3><i class="fas fa-user"></i><span> </span>{{ auth()->user()->name }}</h3>
    </div>
    <ul>
        <li><a href="#"><span class="icon"><i class="fas fa-home"></i></span>Home</a></li>
        <li>
            <a href="#">
                <span class="icon"><i class="fas fa-desktop"></i></span>
                <span class="item">My Dashboard</span>
            </a>
        </li>
        
        <li>
            <a href="#">
                <span class="icon"><i class='fas fa-file-invoice-dollar'></i></span>
                <span class="item">Expences</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="icon"><i class="fa fa-list-alt"></i></span>
                <span class="item">Categories</span>
            </a>
        </li>
       <li> <a href="">
            <span class="icon"><i class='fas fa-user-cog'></i></span>
            <span class="item">Profile</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span class="icon"><i class="fas fa-cog"></i></span>
            <span class="item">Settings</span>
        </a>
    </li>
        <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <li>
                      
                        
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                             <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                             <span class="item">Logout</span>
                        </x-responsive-nav-link>
                    
                </li>
                    </form>
    </ul>
</div>
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="home">
            <h2>Welcome, {{ auth()->user()->name }}</h2>
            <p style="color: #333">{{ $todayDate }}</p>
            </div>
            <!-- Content -->
            <div class="col-md-9">
                
                <div class="balance-section">
                    
                </div>
            </div>
        </div> 
    </div>
    @endsection
    <style>
        #show-form-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .tag-section {
        margin-top: 20px;
    }

    .tag-section h2 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #333;
    }

    .tag-section table {
        width: 100%;
        border-collapse: collapse;
    }

    .tag-section table th,
    .tag-section table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .tag-section table th {
        background-color: #b1d0ee;
        font-weight: bold;
    }

    .tag-section table td {
        background-color: #fff;
    }

    .tag-section table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .tag-section p {
        margin-top: 10px;
        color: #666;
    }
        /* Style the button on hover */
        #show-form-btn:hover {
            background-color: #45a049;
        }
         .sidebar {
            background: rgb(5, 68, 104);
    position: fixed;
    top: 0;
    left: 0;
    width: 225px;
    height: 100%;
    padding: 20px 0;
    padding-left: 0px;
    transition: all 0.5s ease;
        }
        #budget-form {
            display: none;
        }
        .sidebar a {
            
            text-decoration: none;
            font-size: 18px;
            color: #f8f9fa;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #6c757d;
        }
        .sidebar .profile {
            margin-bottom: 30px;
    text-align: center;
            color: #f8f9fa;
        }
        .sidebar .profile h3 {
            margin-top: 0;
        }
        .sidebar ul{list-style: none;
        margin-top: 70px;
    margin-left:0px;}
        .sidebar ul li a{
    display: block;
    padding: 13px 0px;
    border-bottom: 1px solid #10558d;
    color: rgb(241, 237, 237);
    font-size: 17px;
    position: relative;
}

 .sidebar ul li a .icon{
    color: #dee4ec;
    width: 30px;
    display: inline-block;
}
.sidebar ul li a:hover,
 .sidebar ul li a.active{
    color: #0c7db1;

    background:white;
    border-right: 2px solid rgb(5, 68, 104);
}

.wrapper .sidebar ul li a:hover .icon,
.wrapper .sidebar ul li a.active .icon{
    color: #0c7db1;
}

.sidebar ul li a:hover:before,
 .sidebar ul li a.active:before{
    display: block;
}
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .budget-section, .categories-section, .balance-section {
            margin-bottom: 30px;
        }

        .categories-list {
            list-style: none;
            padding: 0;
        }

        .categories-list li {
            margin-bottom: 10px;
        }

        .categories-list li a {
            display: block;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s;
        }

        .categories-list li a:hover {
            background-color: #f0f0f0;
        }

        .logout-button {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-button i {
            margin-right: 5px;
        }

        .expense-form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .balance-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .balance-item {
            color: #333;
        }

        .balance-value {
            font-weight: bold;
            color: #4caf50;
        }
    </style>

<script>
    document.getElementById('show-form-btn').addEventListener('click', function() {
        // Toggle the display property of the form section
        var formSection = document.getElementById('budget-form');
        if (formSection.style.display === 'none') {
            formSection.style.display = 'block';
        } else {
            formSection.style.display = 'none';
        }
    });
</script>
        
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




   

