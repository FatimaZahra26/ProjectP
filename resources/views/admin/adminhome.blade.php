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



        h1 {
            margin-bottom: 30px;
            color: #333;
        }

        table {
            width: 100%;
            background-color: #fff;
            border-collapse: collapse;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 150px;
            margin-top: 50px;
        }

        th,
        td {
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

        .sidebar ul li a {
            display: block;
            padding: 13px 30px;
            border-bottom: 1px solid #10558d;
            color: rgb(241, 237, 237);
            font-size: 16px;
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

        .card {

            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 560px;
            margin: 0 auto;
            color: rgb(192, 199, 222);
            margin-top: 0px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background: rgb(5, 68, 104);

        }

        .card-header {
            border-radius: 15px 15px 0 0;

        }

        .card-body {
            padding: 20px;
            margin-left: 80px;

        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: row
        }



        .btn2-primary {


            margin-left: 300px;
            margin-top: 20px;

            animation: 1.5s ease infinite alternate running shimmer;
            background: linear-gradient(90deg, #FFE27D 0%, #64E3FF 30%, #9192FF 85%);
            background-size: 200% 100%;
            border: none;
            border-radius: 6px;
            box-shadow: -2px -2px 10px rgba(255, 227, 126, 0.5), 2px 2px 10px rgba(144, 148, 255, 0.5);
            color: #170F1E;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 670;
            line-height: 24px;
            overflow: hidden;
            padding: 12px 24px;
            position: relative;
            text-decoration: none;
            transition: 0.2s;

            svg {
                left: -20px;
                opacity: 0.5;
                position: absolute;
                top: -2px;
                transition: 0.5s cubic-bezier(.5, -0.5, .5, 1.5);
            }

            &:hover svg {
                opacity: 0.8;
                transform: translateX(50px) scale(1.5);
            }

            &:hover {
                transform: rotate(-3deg);
            }

            &:active {
                transform: scale(0.95) rotate(-3deg);
            }

        }

        @keyframes shimmer {
            to {
                background-size: 100% 100%;
                box-shadow: -2px -2px 6px rgba(255, 227, 126, 0.5), 2px 2px 6px rgba(144, 148, 255, 0.5);
            }
        }



        .bg-primary {
            height: 30px;
            padding-left: 35%;
            font-size: 20px;
            font-weight: 700;
            padding-top: 15px;
            margin-bottom: 50px;
        }

        .text-white {
            color: #fff !important;
        }

        .updateform {
            margin-top: 0px;
        }

        .updateform {

            font-size: 16px;
            font-weight: 700;
            color: rgb(234, 239, 242);
        }

        .updateform label {
            margin-right: 20px;
        }

        .updateform input {
            height: 24px;
            color: #5a7689
        }

        .card-item {
            width: 300px;
            padding: 15px;
            margin: 1.5rem;
            margin-top: 50px;
            margin-left: 5px;
            display: flex;
            border-radius: 10px;
            background-color: white;
            justify-content: space-between;
            box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.5);
        }

        .image {
            position: relative;
            width: 100px;
            bottom: 1.5rem;
            cursor: pointer;
            background-size: cover;
        }

        .image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            border-radius: 8px;
            background-size: cover;
            transition: all 0.2s linear;
        }

        .image:hover img {
            transform: translateY(-5px);
            box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.7);
        }

        .description ul {
            display: flex;
            list-style: none;
        }

        .description h2 {
            font-size: 24px;
        }

        .role {
            color: #e65b00;
            font-size: 12px;
        }

        .description ul li {
            font-size: 1.2rem;
            padding: 10px 17px 5px 0;
        }

        .description ul li a {
            text-decoration: none;
            color: purple;
        }

        .homeCards {
            display: flex;
            margin-top: 50px;
            margin-left: 90px;
        }

        .h1 {
            display: flex;

        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: block;
            border: 4px solid #fff;
            /* Ajout d'une bordure blanche */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Ombre légère pour l'image */
        }

        .table_buttons {
            display: flex;

        }

        #myChart {
            margin: 0 auto;
            width: 500px;
        }

        #chart-container {
            width: 800px;
            /* Définissez la largeur du conteneur */
            height: 400px;
            /* Définissez la hauteur du conteneur */
            margin: auto;
            /* Centrez le conteneur horizontalement */
        }

        .container {
            max-width: 850px;
            margin: 0 auto;
            padding: 20px;
            height: 1000px;
            background-color: #d5d5ec;
            /*background-image: url('assets/background.jpg');
            background-repeat: no-repeat;*/
            background-size: 100%;
            /* Ajout de cette ligne */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }



        .gif {
            width: 280px;
        }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="profile">
            <img src="{{ asset('http://127.0.0.1:8000/storage/' . $adminData->profile_picture) }}" alt="Profile Photo"
                class="profile-img">
            <h2 style="font-size:18px;font-weight:700">{{ auth()->user()->name }}</h2>
        </div>
        <ul>
            <li>
                <a href="#Home" class="active" id="homeLink">
                    <span class="icon"><i class="fas fa-home"></i></span>
                    <span class="item">Home</span>
                </a>
            </li>
            <li>
                <a href="#dashboard" id="dashboardLink">
                    <span class="icon"><i class="fas fa-desktop"></i></span>
                    <span class="item">My Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#Users" id="usersLink">
                    <span class="icon"><i class="fas fa-user-friends"></i></span>
                    <span class="item">Users</span>
                </a>
            </li>

            <li>
                <a href="#profile" id="profileLink">
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

        <!-- Add more sidebar links as needed -->
    </div>
    <div class="container">
        <div class="container-fluid">
            <div class="row">
              
                <div class="col-md-9" id="home" style="margin: 0 auto">
                    <div class="home">
                        <span style="color: #333;font-weight:700">{{ $todayDate }}</span>

                        <div class="h1">
                            <img src="{{ asset('assets/12.gif') }}" alt="Example GIF" class="gif">

                            <p style="font-weight: 500">Welcome back, <span
                                    style="color: #0056b3;font-size:20px;font-weight:700">{{ auth()->user()->name }}
                                </span></p>

                        </div>
                        <div class="homeCards">

                            <div class="card-item">
                                <div class="description">
                                    <h2> Users </h2>
                                    <span class="role"> total of users: {{ $totalUsers }} </span>
                                    <ul>

                                    </ul>
                                </div>
                                <div class="image">
                                    <!-- Replace the src with user image (iamge ratio => 1:1) -->
                                    <img src="{{ asset('assets/manicon.png') }}" alt="laa">
                                </div>
                            </div>
                            <div class="card-item">
                                <div class="description">
                                    <h2> Reports </h2>
                                    <span class="role"> <a href="{{ route('generateReport') }}"
                                            class="role">Generate User Report</a>
                                    </span>

                                </div>
                                <div class="image">
                                    <!-- Replace the src with user image (iamge ratio => 1:1) -->
                                    <img src="{{ asset('assets/reports.png') }}" alt="laa">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <table class="table" id="table" style="display: none">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                <td>
                                    @if (Auth::check() && Auth::user()->id == $user->id)
                                        <span class="text-success">Online</span>
                                    @else
                                        <span class="text-danger">Offline</span>
                                    @endif
                                </td>
                                <td class="table_buttons">
                                    <a href="{{ url('/admin/users/' . $user->id . '/edit') }}"
                                        class="btn btn-primary">Edit</a>
                                    <form action="{{ url('/admin/users/' . $user->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row justify-content-center">
                    <div class="" id="updateforme" style="display: none">
                        <div class="card" id="card">
                            <div class="card-header bg-primary text-white">Admin Profile</div>


                            <img src="{{ asset('http://127.0.0.1:8000/storage/' . $adminData->profile_picture) }}"
                                alt="Profile Photo" class="profile-img">


                            <div class="card-body">

                                <div class="updateform">
                                    <form method="POST" action="{{ route('admin.profile.update') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">New
                                                Name:</label>

                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control"
                                                    name="name" value="{{ $adminData->name }}" required autofocus>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">New
                                                Email:</label>


                                            <input id="email" type="email" class="form-control" name="email"
                                                value="{{ $adminData->email }}" required>

                                        </div>

                                        <div class="form-group row">
                                            <label for="photo" class="col-md-4 col-form-label text-md-right">New
                                                Photo:</label>


                                            <input id="photo" type="file" class="form-control"
                                                name="photo">

                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn2-primary">Update<svg width="79"
                                                        height="46" viewBox="0 0 79 46" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g filter="url(#filter0_f_618_1123)">
                                                            <path d="M42.9 2H76.5L34.5 44H2L42.9 2Z"
                                                                fill="url(#paint0_linear_618_1123)" />
                                                        </g>
                                                        <defs>
                                                            <filter id="filter0_f_618_1123" x="0" y="0" width="78.5"
                                                                height="46" filterUnits="userSpaceOnUse"
                                                                color-interpolation-filters="sRGB">
                                                                <feFlood flood-opacity="0"
                                                                    result="BackgroundImageFix" />
                                                                <feBlend mode="normal" in="SourceGraphic"
                                                                    in2="BackgroundImageFix" result="shape" />
                                                                <feGaussianBlur stdDeviation="1"
                                                                    result="effect1_foregroundBlur_618_1123" />
                                                            </filter>
                                                            <linearGradient id="paint0_linear_618_1123" x1="76.5"
                                                                y1="2.00002" x2="34.5" y2="44"
                                                                gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="white" stop-opacity="0.6" />
                                                                <stop offset="1" stop-color="white"
                                                                    stop-opacity="0.05" />
                                                            </linearGradient>
                                                        </defs>
                                                    </svg></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chart-container">

                    <!-- Créez un élément canvas où le graphique sera affiché -->
                    <canvas id="myChart" style="display: none">

                    </canvas>
                </div>

            </div>
        </div>
    </div>







    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        /**/
        var chartData = {!! json_encode($chartData) !!};

        // Créer un objet de configuration pour le graphique
        var options = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true // Commencez l'axe y à zéro
                }
            }
            // Vous pouvez ajouter d'autres options de configuration ici selon vos besoins
        };

        // Obtenez le contexte du canvas
        var ctx = document.getElementById('myChart').getContext('2d');

        // Créez le graphique en utilisant Chart.js
        var myChart = new Chart(ctx, {
            type: 'bar', // Utilisez un graphique à barres
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Nombre d\'utilisateurs',
                    data: chartData.data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            }, // Définissez les données du graphique
            options: options // Définissez les options du graphique
        });

        $(document).ready(function() {
            // Cette fonction sera appelée lorsque l'utilisateur clique sur le lien "Home" dans la barre latérale
            $("#homeLink").click(function() {
                // Masquer les autres sections
                $('#updateforme, #table, #myChart').hide();
                // Afficher la section "Home"
                $('#home').show();
                $('#sidebarCollapse').on('click', function() {
                    $('#sidebar').toggleClass('active');
                });

            });

            // Cette fonction sera appelée lorsque l'utilisateur clique sur le lien "Users" dans la barre latérale
            $("#usersLink").click(function() {
                // Masquer les autres sections
                $('#updateforme, #myChart').hide();
                // Afficher la section "Users"
                $('#table').show();
                var table = $('#table');
                table.width('100%'); // Rétablir la largeur par défaut
                $('#home').hide();
            });

            // Cette fonction sera appelée lorsque l'utilisateur clique sur le lien "Profile" dans la barre latérale
            $("#profileLink").click(function() {
                // Masquer les autres sections
                $('#table, #myChart').hide();
                // Afficher la section "Profile"
                $('#updateforme').show();
                $('#row').css('Top', '0px');
                $('#home').hide();
            });

            // Cette fonction sera appelée lorsque l'utilisateur clique sur le lien "My Dashboard" dans la barre latérale
            $("#dashboardLink").click(function() {
                // Masquer les autres sections
                $('#updateforme, #table, #home').hide();
                // Afficher la section "Dashboard"
                $('#myChart').show();
            });
        });
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
