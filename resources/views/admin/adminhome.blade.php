<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include any CSS files here -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            margin-bottom: 30px;
            color: #333;
        }
        table {
            width: 50%;
            background-color: #fff;
            border-collapse: collapse;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-left: 450px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .sidebar {
            background: rgb(5, 68, 104);
    position: fixed;
    top: 0;
    left: 0;
    width: 225px;
    height: 100%;
    padding: 20px 0;
    transition: all 0.5s ease;
        }
        .sidebar a {
            padding: 10px 15px;
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
        .sidebar ul li a{
    display: block;
    padding: 13px 30px;
    border-bottom: 1px solid #10558d;
    color: rgb(241, 237, 237);
    font-size: 16px;
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
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile">
           
            <h3><i class="fas fa-user"></i><span> </span>{{ auth()->user()->name }}</h3>
        </div>
        <ul>
            <li>
                <a href="#" class="active">
                    <span class="icon"><i class="fas fa-home"></i></span>
                    <span class="item">Home</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="icon"><i class="fas fa-desktop"></i></span>
                    <span class="item">My Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="icon"><i class="fas fa-user-friends"></i></span>
                    <span class="item">Users</span>
                </a>
            </li>
           
            @if(isset($user))
            <form method="POST" action="{{ route('profile', ['id' => $user->id]) }}">
                @csrf
                <button type="submit" style="background: none; border: none; padding: 0; margin: 0; cursor: pointer;">
                    <li>
                        <a href="#"><i class="la la-user"></i>
                            <span> Profile </span> <span class="menu-arrow"></span>
                        </a>
                    </li>
                </button>
            </form>
            
            @endif
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
        <!-- Add more sidebar links as needed -->
    </div>
<div class="container">
   
    <div class="row">
        <div class="col-md-8">
           
                            
                        
            <table class="table">
                
                <thead>
                    
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" class="btn btn-primary">Edit</a>
                                <form action="{{ url('/admin/users/' . $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<!-- Include any JavaScript files here -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>