@extends('layouts.app')
@php
    use App\Models\Tag;
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\HomeController;

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
        <form method="POST" action="{{ route('save-budget') }}">
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
            <div class="balance-section">
            <form name="cc"  method="POST" action="{{ route('save-budget') }}">
                @csrf
                <label for="category">Budget:</label><br>
                <input type="text" id="category" name="category"><br><br>
                <label for="duration">Durée:</label><br>
                <select id="duration" name="duration">
                    <option value="week">Une semaine</option>
                    <option value="month">Un mois</option>
                </select><br><br>
                <button id="btn-a" type="submit">Envoyer</button>
            </form>
            <form method="POST" action="{{ route('save-categorie') }}">
                @csrf
                    <h1 id="h1">Categorie:</h1>
                    <div class="input-group">
                    <i class="fas fa-tasks"></i><input type="text" name="name" value="Transport">
<input type="text" name="amount" id="lbl1" class="transport-input" placeholder="Entrer le budget">
                    </div>
                    <!-- <div class="input-group-ffd">
                    <i id="food" class="fas fa-utensils"></i><label name="name">Food</label><input type="text" id="lbl2" name="amount" class="food-input" placeholder="Entrer le budget">
                    </div>
                    <div class="input-group-vetment">
                    <i id="vetement" class="fas fa-tshirt"></i><label name="name">Vetement</label><input type="text" id="lbl3" name="amount" class="clothes-input" placeholder="Entrer le budget">
                    
                    </div> -->
                    <button type="submit" class="save-btn">Enregistrer</button>
                    
            </form>
                    <!-- Section pour afficher les catégories -->
                    <div class="categories-section">
    <h2>Catégories enregistrées:</h2>
    <div class="card-container">
        @foreach($categories as $category)
        <div class="card">
            <h3>{{ $category->name }}</h3>
            <p>Montant: {{ $category->amount }}</p>
            <button>Button</button>
        </div>
        @endforeach
    </div>
</div>


<!-- Section pour afficher les budgets -->
                    <div class="budget-section">
                        <h2>Budgets enregistrés:</h2>
                        
                                @foreach($budgets as $budget)
                                <p id="p1">Le budget initial :</p>
                                <span class="cadre1"> {{ $budget->budget_initial }}</span>
                                
                                <p id="p2">le reste:</p>
                                <span class="cadre">{{ $budget->total_budget }}</span>
                                @endforeach
                                
                            
                    </div>

                    

                </div>
            </div>
            
        </div> 
    </div>
    @endsection
    <style>
        .card-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.card {
    
    background-color: #cfe2f3; /* Blue clair */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: calc(33.33% - 20px); /* Pour afficher 3 cartes par ligne */
    padding: 30px; /* Augmentation de la taille de la carte */
}

.card h3 {
    margin-top: 0;
}

.card button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.card button:hover {
    background-color: #0056b3;
}

        /*--------------------------------------------------*/
        .cadre1{
        border: 2px solid black; /* Définir une bordure de 2 pixels solide noire */
        padding: 5px; /* Ajouter un espace de remplissage autour du contenu */
        display: inline-block; /* Permettre au cadre de s'ajuster à la taille du contenu */
        font-size: 24px; /* Augmenter la taille de la police */
        box-shadow: 3px 3px 5px rgb(5, 68, 104);
        width: 100px;
        padding-left: 40px;
        margin-left:230px;
        position:relative;
        bottom:60px;

        }
        .cadre {
        border: 2px solid black; /* Définir une bordure de 2 pixels solide noire */
        padding: 5px; /* Ajouter un espace de remplissage autour du contenu */
        display: inline-block; /* Permettre au cadre de s'ajuster à la taille du contenu */
        font-size: 24px; /* Augmenter la taille de la police */
        box-shadow: 3px 3px 5px rgb(5, 68, 104);
        width: 100px;
        padding-left: 40px;
        margin-left:630px;
        position:relative;
        bottom:195px;
        }
        #p1{
            font-size: 30px;
            text-shadow: 2px 2px 5px rgb(5, 68, 104) ;
        }
        #p2{
            font-size: 30px;
            text-shadow: 2px 2px 5px rgb(5, 68, 104) ;
            margin-left:500px;
            position:relative;
            bottom:130px;
        }
        #btn-a{
            background: rgb(5, 68, 104);
            color:white;
            width:100px;
        }
        #h1{
            margin-right:660px;
        }
        table, td, th {
        border: 1px solid;
        }

        table {
        width: 100%;
        border-collapse: collapse;
        }
        .save-btn{
            margin-top:30px;
            background: rgb(5, 68, 104);
            color:white;
            width:100px;
        }
        
#add-new-category{
    margin-top:20px;
}
.add-category-btn {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
    text-align: center;
}

.add-category-btn i {
    margin-right: 5px;
}

       
        #transport{
            margin-right:20px;
        }
        #food{
            margin-right:20px;
        }
        #vetement{
            margin-right:20px;
        }
        #lbl3{
            margin-top:20px;
            margin-left:30px;
            width:400px;}
          
        #lbl2{
            margin-top:20px;
            margin-left:75px;
            width:400px;
           
        }
        #lbl1{
           margin-left:40px;
            width:400px;
           
        }
        .input-group {
        display: flex;
        align-items: center;
    }
    .input-group i {
        margin-right: 10px;
    }
    .budget-input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 200px;
    }
       input[type="text"], select {
            width: 800px;
            height: 30px;
        }
        #btn1 {
        background-color: white;
        color: black;
        border: 2px solid #04AA6D;
        margin-top: 40px;
    
        margin-left: 700px;
        }
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
document.getElementById("btn-a").addEventListener("click", function(event) { 
    event.preventDefault(); 
    var budget = parseFloat(document.getElementById("category").value); 
    var duration = document.getElementById("duration").value; 
    // Afficher le budget initial dans l'élément HTML approprié 
    document.getElementById("budget-initial").textContent = "Le budget initial : " + budget; });
 </script>







        





   

