@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

<style>
/* Custom styles for the user profile page */
@import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');

.card {
  
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 50%;
    margin: 0 auto;
    margin-top: 50px;
    background: #08203b;
    color:rgb(192, 199, 222);
   

}

.card-header {
    border-radius: 15px 15px 0 0;
    
}

.card-body {
    padding: 20px;
    margin-left:80px;

}

.form-group {
    margin-bottom: 20px;
    display: flex;
    flex-direction: row
}



.btn-primary {
    background-color: #7680ef;
    border-radius: 10%;
    width: 100px;
    height: 30px;
    margin-left: 450px;
    margin-top:50px;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.bg-primary {
    height:  30px;
    padding-left:35%;
    font-size: 28px;
    font-weight: 700;
    padding-top: 15px;
    margin-bottom: 50px;
}

.text-white {
    color: #fff !important;
}
.la{    display: flex;}

.la label{
    color: #e8eff4;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px; 
    margin-right: 50px;       
}
.la p{
margin-top: 0px;
margin-bottom: 20px;}
.updateform{
    margin-top: 50px;
}
.profile-photo{
    margin: 0 auto;
    margin-left: 250px;
    width:200px;
    margin-bottom: 50px;
    border-radius: 50%;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.updateform{
    
   font-size: 18px;
   font-weight: 700;
   color:rgb(97, 193, 245);
}
.updateform label{
    margin-right: 20px;
}
.updateform input{
    height: 24px;
   
  
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
        .sidebar ul{
            list-style: none;
            padding-left:0px; 
            margin-top:80px;
          
        }
        .sidebar ul li a{
    display: block;
    padding: 13px 30px;
    border-bottom: 1px solid #10558d;
    color: rgb(241, 237, 237);
    font-size: 18px;
    position: relative;
    
}
.sidebar ul li{
   
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

<div class="container">
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
                <a href="{{route('admin.profile')}}">
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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Admin Profile</div>
                <div class="la">
                   
                    <img src="{{ asset('http://127.0.0.1:8000/storage/' . $adminData->profile_picture) }}" alt="Profile Photo" class="profile-photo">
                   
                </div>
                <div class="card-body">
                     <!-- Profile photo section -->
                     
                    <div class="la">
                        <label for="name">Name:</label>
                            <p>{{ $adminData->name }}</p>

                      
                    
                    </div>

                    <div class="la">
                        <label for="email">Email:</label>
                        <p>{{ $adminData->email }}</p>

                    
                            
                        
                    </div>

                   

                    <!-- Profile update form -->
                    <div class="updateform">
                        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">New Name:</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $adminData->name }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">New Email:</label>

                            
                                <input id="email" type="email" class="form-control" name="email" value="{{ $adminData->email }}" required>
                           
                        </div>

                        <div class="">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">New Photo:</label>

                           
                                <input id="photo" type="file" class="form-control" name="photo">
                           
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
