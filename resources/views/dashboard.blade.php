@extends('layouts.app')
@php
    use App\Models\Tag;
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\HomeController;

@endphp
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>



<div class="sidebar" style="padding-top: 0px">
    <div class="profile"
        style="background-image: url('{{ asset('assets/background1.jpg') }}'); background-size: cover; padding-top: 30px; margin-top: 0px; height: 160px;z-index:-1">
        <div style="z-index: 100">
            <img src="{{ asset('http://127.0.0.1:8000/storage/' . $adminData->profile_picture) }}" alt="Profile Photo"
                class="profile-img" style="width: 80px;height:80px;">
            <h2 style="font-size:20px;font-weight:700;color:rgb(236, 118, 22)">{{ auth()->user()->name }}</h2>
        </div>
    </div>
    <ul>
        <li><a href="#Home" id="HomeLink"><span class="icon"><i class="fas fa-home"></i></span>Home</a></li>
        <li>
            <a href="#Dashboard" id="DashboardLink">
                <span class="icon"><i class="fas fa-desktop"></i></span>
                <span class="item">My Dashboard</span>
            </a>
        </li>

        <li>
            <a href="#Expenses" id="ExpenseLink">
                <span class="icon"><i class='fas fa-file-invoice-dollar'></i></span>
                <span class="item">Expences</span>
            </a>
        </li>
        <li>
            <a href="#Category" id="categoryLink">
                <span class="icon"><i class="fa fa-list-alt"></i></span>
                <span class="item">Categories</span>
            </a>
        </li>
        <li>
            <a href="#Profile" id="profile-link">
                <span class="icon"><i class='fas fa-user-cog'></i></span>
                <span class="item">Profile</span>
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
            <div class="home" id="home">

                <div class="weather">
                    <p style="color: #ccc9ed" style="font-weight: 600">{{ $todayDate }}</p>

                    <h2>Hi, <span style="color: rgb(240, 115, 43);font-size:25px;">{{ auth()->user()->name }}</span>!</h2>
                    <h4>welcome Home!</h4>

                    @if (!empty($weatherData))
                        <p>The weather is
                            {{ $weatherData['weather'][0]['description'] }}, the temperature is:
                            {{ $weatherData['main']['temp'] }}°C and humidity is {{ $weatherData['main']['humidity'] }}%</p>
                    @else
                        <p>Aucune donnée météorologique disponible pour le moment.</p>
                    @endif
                </div>
                <ul class="cards">
                    @foreach ($budgets as $budget)
                        <li>
                            <img src="{{ asset('assets/dol.jpg') }}" alt="" class="dol"
                                style="width: 50px;border-radius:50%">
                            <span class="info">
                                <h3><span>$</span><span class="budget_card">{{ $budget->budget_initial }}</span></h3>
                                <p>Budget</p>
                            </span>
                        </li>

                        <li>
                            <img src="{{ asset('assets/balance.jpg') }}" alt="" class="dol"
                                style="width: 50px;border-radius:50%">
                            <span class="info">
                                <h3><span>$</span><span class="balance_card">{{ $budget->total_budget }}</span></h3>
                                <p>Remaining</p>
                            </span>
                        </li>
                    @endforeach
                </ul>

                <div style="display: flex;margin-left:60%;">
                    <button class="button-86" id="openForm">Add Budget</button>
                    <button class="button-87" id="openCategory">Add category</button>
                </div>
                <div id="popupForm1" class="popup">
                    <form name="cc" class="popup-content" method="POST" action="{{ route('save-budget') }}"
                        style="margin:0 auto;">
                        @csrf
                        <span class="close">&times;</span>
                        <h1 id="h1">Budget:</h1>

                        <label for="category">Budget Amount:</label><br>
                        <input type="number" id="category" name="category" min="0"><br><br>
                        <label for="duration">duration:</label><br>
                        <select id="duration" name="duration" style="width:400px">
                            <option value="week">Weekly</option>
                            <option value="month">Monthly</option>
                        </select><br><br>
                        <button id="btn-a" type="submit" class="button-55">Send</button>
                    </form>
                </div>
                <div>
                    @if ($errors->any())
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: '<ul style="list-decoration:none">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                                confirmButtonText: 'OK'
                            });
                        </script>
                    @endif
                </div>
                <div>
                    @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: '{{ session('success') }}',
                                confirmButtonText: 'OK'
                            });
                        </script>
                    @endif
                </div>
                <div id="popupForm2" class="popup">
                    <form method="POST" class="popup-content" action="{{ route('save-categorie') }}"
                        style="margin:0 auto;">
                        @csrf
                        <span class="close2">&times;</span>

                        <h1 id="h1">Categorie:</h1>

                        <label for="category">Categoty name:</label><br>
                        <input type="text" name="name"><br><br>
                        <label for="category">Categoty Amount:</label><br>
                        <input type="number" name="amount" id="lbl1" class="transport-input"
                            placeholder="Entrer le budget" style="margin-left:0px" min="0">

                        <!-- <div class="input-group-ffd">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <i id="food" class="fas fa-utensils"></i><label name="name">Food</label><input type="text" id="lbl2" name="amount" class="food-input" placeholder="Entrer le budget">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="input-group-vetment">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <i id="vetement" class="fas fa-tshirt"></i><label name="name">Vetement</label><input type="text" id="lbl3" name="amount" class="clothes-input" placeholder="Entrer le budget">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div> -->
                        <button type="submit" class="button-55" style="margin-left:75%">Save</button>

                    </form>
                </div>
            </div>

            <!-- Content -->


            <div class="balance-section">



                <!-- Section pour afficher les catégories -->
                <div class="categories-section" id="categories">
                    <h1 style="color: #0056b3">Your Category List:</h1>
                    <ul class="cards" style="display: flex; flex-wrap: wrap;margin:0 auto;">
                        @foreach ($categories->chunk(2) as $pair)
                            <ul class="pair" style="width: 40%;padding-left:0px;padding-right:50px;">
                                @foreach ($pair as $category)
                                    <div class="flou">
                                        <li style="width: 100%;">
                                            <img src="{{ asset('assets/cate.jpg') }}" alt="" class="dol"
                                                style="width: 50px;border-radius:30%">
                                            <span class="info">
                                                <h3><span
                                                        class="budget_card">Amount:<span>$</span>{{ $category->amount }}</span>
                                                </h3>
                                                <p>{{ $category->name }}</p>
                                                <button class="button-52 add-expense-button"
                                                    data-category="{{ $category->id }}" role="button">Add
                                                    Expenses</button>
                                            </span>
                                        </li>
                                    </div>

                                    <!-- Ajout du formulaire d'ajout de dépenses pour cette catégorie -->
                                    <div id="expenseForm{{ $category->id }}" class="expenseForm" style="display: none;">
                                        <form action="{{ route('expenses.store') }}" method="POST"
                                            class="popup-content" style="margin:0 auto;margin-bottom:80px;">
                                            @csrf
                                            <h1>Add Expense for {{ $category->name }}</h1>
                                            <input type="hidden" name="tag_id" value="{{ $category->id }}">
                                            <label for="description">Description:</label><br>
                                            <input type="text" id="description" name="description"><br><br>
                                            <label for="amount">Amount:</label><br>
                                            <input type="number" id="amount" name="amount" min="0"><br><br>
                                            <button type="submit"class="button-55">Add Expense</button>
                                        </form>
                                    </div>
                                    <!-- Liste des dépenses pour cette catégorie -->
                                    <ul class="expenses-list" id="expensesList{{ $category->id }}">
                                        @if ($category->expenses)
                                            @foreach ($category->expenses as $expense)
                                                <li>{{ $expense->description }}: ${{ $expense->amount }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                @endforeach
                            </ul>
                        @endforeach
                    </ul>
                </div>

                <!-- profile -->
                <div class="profile-container" id="profile-section" style="display: none;">
                    <h1 style="color: #cacee3">Your Profile:</h1>
                    <div class="profile-info">
                        <img src="{{ asset('storage/' . $adminData->profile_picture) }}" alt="Profile Photo"
                            class="profile-img">
                        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="profile_image">Choose a new profile picture:</label>
                                <input type="file" id="profile_image" name="photo"
                                    value="{{ $adminData->profile_image }}">
                            </div>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" value="{{ $adminData->name }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" value="{{ $adminData->email }}">
                            </div>
                            <!-- Ajoutez le champ pour la ville -->
                            <div class="form-group">
                                <label for="city">City:</label>
                                <input type="text" id="city" name="city" value="{{ $adminData->city }}">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Save changes">
                            </div>
                        </form>
                    </div>
                </div>
                <div id="expenses">
                    <h1 style="color: #0056b3">Your Expenses List:</h1>
                    <div id="ExpenseList" style="margin-top: 50px;">

                        @foreach ($categories as $category)
                            <div class="card" style="background: #f8c263">
                                <div class="card-header">{{ $category->name }}</div>
                                <div class="card-body">
                                    @foreach ($expensesByCategory[$category->id] as $expense)
                                        <div class="expense-item">
                                            <div class="description">{{ $expense->description }}</div>
                                            <div class="amount">${{ $expense->amount }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="dashboard">
                    <div style="width: 350px; height: 33n0px;">
                        <h1 style="color: #0056b3">Your Dashboard:</h1>
                        <canvas id="budgetPieChart"></canvas>
                    </div>
                    <div style="width: 290px; height: 400px; margin-top: 130px; margin-left: 50px;">
                        <canvas id="budgetVariationChart"></canvas>
                    </div>
                </div>
                


            </div>

        </div>
    </div>
@endsection
<style>
    /**/
    #dashboard {
        display: flex;
    }

    .chart-container {
        width: 50%;
        padding: 20px;
    }

    #dashboard h1 {
        margin-left: 50%;
        width: 100%;
    }

    .weather {
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-image: url('{{ asset('assets/background1.jpg') }}');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 20px;
    
    }

    .weather h4 {
        font-size: 24px;
        margin-bottom: 10px;

    }

    .weather p {
        font-size: 20px;
        margin-bottom: 8px;
        font-weight: 600;

    }

    .weather p:last-child {
        margin-bottom: 0;
        /* Supprime la marge en bas du dernier paragraphe */
    }

    .weather p::before {
        content: "\2022";
        /* Utilise un point comme bullet */
        display: inline-block;
        width: 10px;
        margin-right: 8px;
    }

    .weather p.empty {
        font-style: italic;
        color: #999;
    }


    /* Positionner le formulaire d'ajout de dépenses au premier plan */
    .expenseForm {
        position: absolute;
        width: 500px;

        border-radius: 5px;
        position: absolute;
        top: 70%;
        left: 30%;
        background-color: white;

        /* Modifier en fonction de votre conception */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        /* Modifier en fonction de votre conception */
    }



    /**/
    #ExpenseList {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }



    .card-header {
        padding: 10px;
        font-weight: bold;
        background-color: #f0f0f0;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .card-body {
        padding: 10px;
        background: transparent;
    }

    .expense-item {
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;

    }

    .expense-item .description {
        font-weight: bold;
    }

    .expense-item .amount {
        color: #555;
        font-size: 0.9em;
        font-weight: 700
    }

    /**/
    /* Styles pour le popup */
    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Fond semi-transparent */
        z-index: 9999;
        /* Assure que le popup apparaît au-dessus de tout */
        margin-bottom: 500px;
    }

    .popup-content {
        background-color: #fff;
        width: 300px;
        padding: 20px;
        border-radius: 5px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }

    /*profile css*/
    .profile-container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        background-color: #04317A;
        /* Couleur de fond légèrement plus claire */
    }

    .profile-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin: 0 auto 20px;
        display: block;
        border: 4px solid #fff;
        /* Ajout d'une bordure blanche */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        /* Ombre légère pour l'image */
    }

    .profile-info {
        text-align: center;
        color: white;
        /* Couleur du texte */
    }

    .profile-info p {
        margin-bottom: 15px;
        /* Espacement légèrement augmenté */
        font-size: 16px;
        /* Taille de police légèrement augmentée */
    }

    .form-group {
        margin-bottom: 20px;
        /* Espacement plus important entre les groupes de formulaire */
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        /* Espacement entre les libellés et les champs de formulaire */
        font-weight: bold;
        /* Texte en gras */
        color: white;
        /* Couleur bleue pour les libellés */
    }

    .form-group input[type="text"],
    .form-group input[type="email"] {
        width: 100%;
        padding: 12px;
        /* Rembourrage légèrement augmenté */
        border-radius: 5px;
        border: 1px solid #ced4da;
        /* Bordure légèrement plus claire */
        transition: border-color 0.3s;
        /* Transition en douceur pour le changement de couleur de la bordure */
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="email"]:focus {
        border-color: #007bff;
        /* Couleur de la bordure au focus */
        outline: none;
        /* Supprime la bordure de mise au point par défaut */
    }

    .form-group input[type="submit"] {
        background-color: #007bff;
        border: none;
        padding: 12px 24px;
        /* Rembourrage légèrement augmenté */
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
        /* Taille de police légèrement augmentée */
        transition: background-color 0.3s;
        /* Transition en douceur pour le changement de couleur de fond */
        color: blue;
        cursor: pointer;
    }

    .form-group input[type="submit"]:hover {
        background-color: white;
        /* Couleur de fond au survol */
    }

    /*end*/
    .button-52 {
        font-size: 14px;
        font-weight: 200;
        letter-spacing: 1px;
        padding: 13px 20px 13px;
        outline: 0;
        border: 1px solid black;
        cursor: pointer;
        position: relative;
        background-color: rgba(0, 0, 0, 0);
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        width: 80%;
        margin-left: 40px;
    }

    .button-52:after {
        content: "";
        background-color: #ffe54c;
        width: 100%;
        z-index: -1;
        position: absolute;
        height: 100%;
        top: 7px;
        left: 7px;
        transition: 0.2s;
    }

    .button-52:hover:after {
        top: 0px;
        left: 0px;
    }

    @media (min-width: 768px) {
        .button-52 {
            padding: 13px 50px 13px;
        }
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    /**/
    .close,
    .close2 {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close2:hover,
    .close:focus,
    .close2:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .popup-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 400px;
    }

    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .button-86,
    .button-87 {
        all: unset;
        width: 100px;
        height: 30px;
        font-size: 16px;
        background: transparent;
        border: none;
        position: relative;
        color: #f0f0f0;
        cursor: pointer;
        z-index: 1;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        margin-right: 20px;
    }

    .button-86::after,
    .button-87::after,
    .button-86::before,
    .button-87::before {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: -99999;
        transition: all .4s;
    }

    .button-86::before {
        transform: translate(0%, 0%);
        width: 100%;
        height: 100%;
        background: #1a4491;
        border-radius: 10px;
    }

    .button-87::before {
        transform: translate(0%, 0%);
        width: 100%;
        height: 100%;
        background: #f78504;
        border-radius: 10px;
    }

    .button-86::after,
    .button-87::after {
        transform: translate(10px, 10px);
        width: 35px;
        height: 35px;
        background: #ffffff15;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        border-radius: 50px;
    }

    .button-86:hover::before,
    .button-87:hover::before {
        transform: translate(5%, 20%);
        width: 110%;
        height: 110%;
    }

    .button-86:hover::after,
    .button-87:hover::after {
        border-radius: 10px;
        transform: translate(0, 0);
        width: 100%;
        height: 100%;
    }

    .button-86:active::after,
    .button-87:active::after {
        transition: 0s;
        transform: translate(0, 5%);
    }

    /**/
    .card {

        background-color: #cfe2f3;
        /* Blue clair */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: calc(33.33% - 20px);
        /* Pour afficher 3 cartes par ligne */
        padding: 30px;
        /* Augmentation de la taille de la carte */
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
    .button-55 {
        align-self: center;
        background-color: #cacee3;
        background-image: none;
        background-position: 0 90%;
        background-repeat: repeat no-repeat;
        background-size: 4px 3px;
        border-radius: 15px 225px 255px 15px 15px 255px 225px 15px;
        border-style: solid;
        border-width: 2px;
        box-shadow: rgba(0, 0, 0, .2) 15px 28px 25px -18px;
        box-sizing: border-box;
        color: #41403e;
        cursor: pointer;
        display: inline-block;
        font-family: Neucha, sans-serif;
        font-size: 1rem;
        line-height: 23px;
        outline: none;
        padding: .75rem;
        text-decoration: none;
        transition: all 235ms ease-in-out;
        border-bottom-left-radius: 15px 255px;
        border-bottom-right-radius: 225px 15px;
        border-top-left-radius: 255px 15px;
        border-top-right-radius: 15px 225px;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        margin-left: 80%;
    }

    .button-55:hover {
        box-shadow: rgba(0, 0, 0, .3) 2px 8px 8px -5px;
        transform: translate3d(0, 2px, 0);
        background: #10558d;

    }

    .button-55:focus {
        box-shadow: rgba(0, 0, 0, .3) 2px 8px 4px -6px;
    }

    .cadre1 {
        border: 2px solid black;
        /* Définir une bordure de 2 pixels solide noire */
        padding: 5px;
        /* Ajouter un espace de remplissage autour du contenu */
        display: inline-block;
        /* Permettre au cadre de s'ajuster à la taille du contenu */
        font-size: 24px;
        /* Augmenter la taille de la police */
        box-shadow: 3px 3px 5px rgb(5, 68, 104);
        width: 100px;
        padding-left: 40px;
        margin-left: 230px;
        position: relative;
        bottom: 60px;

    }

    .cadre {
        border: 2px solid black;
        /* Définir une bordure de 2 pixels solide noire */
        padding: 5px;
        /* Ajouter un espace de remplissage autour du contenu */
        display: inline-block;
        /* Permettre au cadre de s'ajuster à la taille du contenu */
        font-size: 24px;
        /* Augmenter la taille de la police */
        box-shadow: 3px 3px 5px rgb(5, 68, 104);
        width: 100px;
        padding-left: 40px;
        margin-left: 630px;
        position: relative;
        bottom: 195px;
    }

    #p1 {
        font-size: 30px;
        text-shadow: 2px 2px 5px rgb(5, 68, 104);
    }

    #p2 {
        font-size: 30px;
        text-shadow: 2px 2px 5px rgb(5, 68, 104);
        margin-left: 500px;
        position: relative;
        bottom: 130px;
    }

    #btn-a {}

    #h1 {
        margin-right: 660px;
    }

    /**/
    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        grid-gap: 1.5rem;
        padding: 2rem;


    }

    .container .cards li {
        padding: 1.8rem;
        background-color: rgb(161, 181, 216);
        border-radius: 5px;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease-in;
        margin-bottom: 20px;
    }

    .container .cards li:hover {
        transform: translateY(-10px);
    }

    .container .cards li .bx {
        width: 4.5rem;
        height: 4.5rem;
        border-radius: 10px;
        font-size: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .container .cards li:nth-child(1) .bx {
        background-color: var(--light-primary);
        color: var(--primary);
    }

    .container .cards li:nth-child(2) .bx {
        background-color: var(--light-warning);
        color: var(--warning);
    }

    .container .cards li:nth-child(3) .bx {
        background-color: var(--light-success);
        color: var(--success);
    }

    .container .cards li .info h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark);
    }

    .container .cards li .info p {
        color: var(--dark);
    }

    #duration {
        width: 65vh;
    }

    /**/
    table,
    td,
    th {
        border: 1px solid;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .save-btn {
        margin-top: 30px;
        background: rgb(5, 68, 104);
        color: white;
        width: 100px;
    }

    #add-new-category {
        margin-top: 20px;
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


    #transport {
        margin-right: 20px;
    }

    #food {
        margin-right: 20px;
    }

    #vetement {
        margin-right: 20px;
    }

    #lbl3 {
        margin-top: 20px;
        margin-left: 30px;
        width: 400px;
    }

    #lbl2 {
        margin-top: 20px;
        margin-left: 75px;
        width: 400px;

    }

    #lbl1 {
        margin-left: 40px;
        width: 400px;

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

    input[type="text"],
    select {
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

    .sidebar ul {
        list-style: none;
        margin-top: 50px;
        padding-left: 5px;
    }

    .sidebar ul li a {
        display: block;
        padding: 13px 0px;
        border-bottom: 1px solid #10558d;
        color: rgb(241, 237, 237);
        font-size: 17px;
        position: relative;
    }

    .sidebar ul li a .icon {
        color: #dee4ec;
        width: 30px;
        display: inline-block;
    }

    .sidebar ul li a:hover,
    .sidebar ul li a.active {
        color: #0c7db1;

        background: white;
        border-right: 2px solid rgb(5, 68, 104);
    }

    .wrapper .sidebar ul li a:hover .icon,
    .wrapper .sidebar ul li a.active .icon {
        color: #0c7db1;
    }

    .sidebar ul li a:hover:before,
    .sidebar ul li a.active:before {
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

    .budget-section {
        background: #666;
        height: 80px;
        display: flex;
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

    input[type="text"],
    input[type="number"] {
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Retrieve the Laravel budget data
    document.addEventListener('DOMContentLoaded', function() {
        // Your Laravel budget data
        var initialBudget = {!! $initialBudget !!}; // Assuming you pass the initial budget from the controller
        var totalBudget = {!! $totalBudget !!}; // Assuming you pass the total budget from the controller

        // Calculate the variation from the initial budget
        var variation = (totalBudget / initialBudget) * 100;

        // Remaining budget
        var remainingBudget = 100 - variation;

        // Get the canvas context
        var ctx = document.getElementById('budgetVariationChart').getContext('2d');

        // Create the donut chart
        var budgetVariationChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Expenses', 'Remaining Budget'],
                datasets: [{
                    data: [remainingBudget, variation],
                    backgroundColor: [
                        'rgba(23, 84, 226, 0.8)',
                        'rgba(180, 203, 164, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    datalabels: {
                        display: true,
                        color: '#fff',
                        formatter: (value, ctx) => {
                            return value.toFixed(2) + "%";
                        }
                    }
                }
            }
        });
    });
</script>

<script>
    // Retrieve the data from Laravel view
    document.addEventListener('DOMContentLoaded', function() {
        // Your JavaScript script to initialize the chart here
        var categories = {!! json_encode($categories) !!};

        // Initialize arrays for labels and data
        var labels = [];
        var data = [];

        // Fill the arrays with retrieved data
        categories.forEach(function(category) {
            labels.push(category.name);
            data.push(category.amount);
        });

        // Get the canvas context
        var ctx = document.getElementById('budgetPieChart').getContext('2d');

        // Create the pie chart
        var budgetPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                layout: {
                    padding: {
                        bottom: 30 // Add bottom padding for the labels
                    }
                },
                plugins: {
                    datalabels: {
                        display: true,
                        color: '#fff',
                        formatter: (value, ctx) => {
                            let sum = ctx.dataset._meta[0].total;
                            let percentage = (value * 100 / sum).toFixed(2) + "%";
                            return percentage;
                        }
                    }
                }
            }
        });

    });
</script>
<script>
    /*document.getElementById("btn-a").addEventListener("click", function(event) {
        event.preventDefault();
        var budget = parseFloat(document.getElementById("category").value);
        var duration = document.getElementById("duration").value;
        // Afficher le budget initial dans l'élément HTML approprié 
        document.getElementById("budget-initial").textContent = "Le budget initial : " + budget;
    });*/
    /**/
    $(document).ready(function() {
        // Cette fonction sera appelée lorsque l'utilisateur clique sur le lien "Home" dans la barre latérale
        $("#categoryLink").click(function() {
            // Masquer les autres sections
            $('#home').hide();
            $('#profile-section').hide();
            // Afficher la section "Home"
            $('#categories').show();
            $('#budgetPieChart').hide();
            $('#dashboard').hide();
            $('#ExpenseList').hide();
            $('#expenses').hide();


        });
        $("#DashboardLink").click(function() {
            // Masquer les autres sections
            $('#home').hide();
            $('#profile-section').hide();
            // Afficher la section "Home"
            $('#categories').hide();
            $('#dashboard').show();
            $('#budgetPieChart').show();
            $('#ExpenseList').hide();
            $('#expenses').hide();


        });
        $("#HomeLink").click(function() {
            // Masquer les autres sections
            $('#categories').hide();
            $('#profile-section').hide();
            // Afficher la section "Home"
            $('#home').show();
            $('#budgetPieChart').hide();
            $('#dashboard').hide();
            $('#ExpenseList').hide();
            $('#expenses').hide();


        });
        $("#profile-link").click(function() {
            // Masquer les autres sections
            $('#categories').hide();
            // Afficher la section "Home"
            $('#home').hide();
            $('#budgetPieChart').hide();
            $('#dashboard').hide();
            $('#profile-section').show();
            $('#ExpenseList').hide();
            $('#expenses').hide();


        });
        $("#ExpenseLink").click(function() {
            // Masquer les autres sections
            $('#categories').hide();
            // Afficher la section "Home"
            $('#home').hide();
            $('#budgetPieChart').hide();
            $('#dashboard').hide();
            $('#profile-section').hide();
            $('#ExpenseList').show();
            $('#expenses').show();


        });

    });
    document.addEventListener('DOMContentLoaded', function() {
        // Masquer les autres sections sauf la section "Home"
        document.getElementById('categories').style.display = 'none';
        document.getElementById('budgetPieChart').style.display = 'none';
        document.getElementById('dashboard').style.display = 'none';
        // Afficher la section "Home"
        document.getElementById('home').style.display = 'block';
        document.getElementById('ExpenseList').style.display = 'none';
        document.getElementById('expenses').style.display = 'none';
    });

    /**/
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('openForm').addEventListener('click', function() {
            document.getElementById('popupForm1').style.display = 'block';
        });

        document.querySelector('.close').addEventListener('click', function() {
            document.getElementById('popupForm1').style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target == document.getElementById('popupForm1')) {
                document.getElementById('popupForm2').style.display = 'none';
            }
        });

        // Prevent the form from being submitted
        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault();

        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('openCategory').addEventListener('click', function() {
            document.getElementById('popupForm2').style.display = 'block';
        });

        document.querySelector('.close2').addEventListener('click', function() {
            document.getElementById('popupForm2').style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target == document.getElementById('popupForm2')) {
                document.getElementById('popupForm2').style.display = 'none';
            }
        });

        // Prevent the form from being submitted
        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault();

        });
    });
</script>



{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fonction pour afficher ou masquer le formulaire d'ajout de dépenses lorsqu'un utilisateur clique sur le bouton "Add Expenses"
        document.querySelectorAll('.add-expense-button').forEach(button => {
            button.addEventListener('click', () => {
                const categoryId = button.getAttribute('data-category');
                const expenseForm = document.getElementById(`expenseForm${categoryId}`);
                if (expenseForm) {
                    // Si le formulaire est déjà affiché, le masquer ; sinon, l'afficher
                    if (expenseForm.style.display === 'block') {
                        expenseForm.style.display = 'none';
                    } else {
                        expenseForm.style.display = 'block';
                    }
                }
            });
        });
    });
</script> --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const expenseButtons = document.querySelectorAll('.add-expense-button');
        const expenseForms = document.querySelectorAll('.expenseForm');
        const categoriesSection = document.getElementById('categories');

        // Function to show expense form with higher z-index and blur background
        function showExpenseForm(categoryId) {
            const expenseForm = document.getElementById(`expenseForm${categoryId}`);
            expenseForm.style.display = 'block';
            expenseForm.style.zIndex = '1';
            categoriesSection.classList.add('blur-background');
        }

        // Function to hide expense forms and remove blur effect
        function hideExpenseForms() {
            expenseForms.forEach(form => {
                form.style.display = 'none';
            });
            categoriesSection.classList.remove('blur-background');
        }

        // Event listener for clicking on Add Expenses buttons
        expenseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-category');
                hideExpenseForms();
                showExpenseForm(categoryId);
            });
        });

        // Event listener for clicking outside of expense forms to hide them
        document.addEventListener('click', function(event) {
            if (!event.target.matches('.add-expense-button') && !event.target.closest('.expenseForm')) {
                hideExpenseForms();
            }
        });
    });
</script> --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const expenseButtons = document.querySelectorAll('.add-expense-button');
        const expenseForms = document.querySelectorAll('.expenseForm');

        // Function to show expense form in the foreground without blur
        function showExpenseForm(categoryId) {
            const expenseForm = document.getElementById(`expenseForm${categoryId}`);
            expenseForm.style.display = 'block';
            expenseForm.style.zIndex = '100';

            // Appliquer le flou aux éléments autres que le formulaire d'ajout de dépenses
            document.querySelectorAll('.flou:not(.expenseForm)').forEach(element => {
                element.style.filter = 'blur(3px)';
            });
        }

        // Function to hide expense forms
        function hideExpenseForms() {
            expenseForms.forEach(form => {
                form.style.display = 'none';
                // Réinitialiser le filtre de flou
                document.querySelectorAll('.flou:not(.expenseForm)').forEach(element => {
                    element.style.filter = 'none';
                });
            });
        }

        // Event listener for clicking on Add Expenses buttons
        expenseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-category');
                hideExpenseForms(); // Masquer tous les formulaires avant d'afficher celui-ci
                showExpenseForm(categoryId);
            });
        });

        // Event listener for clicking outside of expense forms to hide them
        document.addEventListener('click', function(event) {
            // Vérifier si l'élément cliqué n'est ni le bouton "Ajouter des dépenses" ni à l'intérieur du formulaire
            if (!event.target.matches('.add-expense-button') && !event.target.closest('.expenseForm')) {
                hideExpenseForms(); // Masquer le formulaire
            }
        });
    });
</script>




<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Gérer le clic sur le lien "Profile"
        $('#profile-link').click(function(event) {
            event.preventDefault(); // Empêche le lien de suivre le lien par défaut
            $('#profile-section').toggle(); // Affiche ou masque la section profil
        });


        $('.form-group input[type="submit"').click(function(event) {

            $('#save-popup').fadeIn(); // Affiche le popup d'enregistrement
        });

        // Gérer le clic sur le bouton de fermeture du popup
        $('.close').click(function() {
            $('#save-popup').fadeOut(); // Masque le popup d'enregistrement
            $('#profile-section').toggle(); // Affiche ou masque la section profil
        });
        /*Gérer le clic sur le bouton "OK"
        $('#ok-button').click(function() {
            $('#save-popup').fadeOut(); // Masque le popup d'enregistrement
            $('#profile-section').toggle(); // Affiche ou masque la section profil
        });*/

    });
</script> -->
