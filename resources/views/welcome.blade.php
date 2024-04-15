<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WiseWalletPro</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"
        integrity="sha512-VEBjfxWUOyzl0bAwh4gdLEaQyDYPvLrZql3pw1ifgb6fhEvZl9iDDehwHZ+dsMzA0Jfww8Xt7COSZuJ/slxc4Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/ionicons@4.5.5/dist/ionicons.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url({{ asset('assets/video.gif') }});
            color: #fff;
            letter-spacing: 2px;
            font-weight: bold;

        }

        html {
            scroll-behavior: smooth;
        }

        nav {
            width: 100%;
            box-shadow: 0 3px 20px rgba(0, 0, 0, 0.4);
            display: flex;
            height: 80px;
            background-color: #a6bcf6;

        }

        .logo {
            padding: 2vh 2vw;
            text-align: right;
            margin: 0 0.7vw;
            color: rgb(245, 149, 70);


        }



        .nav-links {
            display: flex;
            list-style: none;
            width: 88vw;
            padding: 0 0.7vw;
            align-items: center;
            justify-content: space-evenly;
        }

        .nav-links li {
            position: relative;
        }

        .nav-links li a {
            text-decoration: none;
            font-size: 12px;
            margin: 0 0.7vw;
            text-transform: uppercase;
        }

        nav ul li a::after {
            content: "";
            width: 0;
            height: 3px;
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            transition: width 0.3s;
        }

        nav ul li a:hover::after {
            width: 55%;
        }

        .hamburger div {
            width: 30px;
            height: 2px;
            background: #fff;
            margin: 7px;
            transition: all 0.3s ease;
        }

        .hamburger {
            display: none;
        }

        @media screen and (max-width: 800px) {
            nav {
                position: fixed;
                z-index: 3;
                padding-top: 0vh;
            }

            .hamburger {
                display: block;
                position: absolute;
                cursor: pointer;
                right: 5%;
                top: 50%;
                transform: translate(-5%, -50%);
                z-index: 2;
                transition: all 0.6s ease;

            }

            .nav-links {
                background-color: #6c94e5;
                position: fixed;
                height: 100vh;
                width: 100%;
                flex-direction: column;
                clip-path: circle(150px at 90% -20%);
                -webkit-clip-path: circle(50px at 90% -20%);
                transition: all 1.5s ease-out;
                pointer-events: none;

            }

            .nav-links.open {
                clip-path: circle(1000px at 90% -10%);
                -webkit-clip-path: circle(1000px at 90% -10%);
                pointer-events: all;
            }

            .nav-links li {
                opacity: 0;
            }

            .nav-links li:nth-child(1) {
                transition: all 0.5s ease 0.2s;
            }

            .nav-links li:nth-child(2) {
                transition: all 0.5s ease 0.4s;
            }

            .nav-links li:nth-child(3) {
                transition: all 0.5s ease 0.6s;
            }

            .nav-links li:nth-child(4) {
                transition: all 0.5s ease 0.7s;
            }

            .nav-links li:nth-child(5) {
                transition: all 0.5s ease 0.8s;
            }

            .nav-links li:nth-child(6) {
                transition: all 0.5s ease 0.9s;
            }

            .nav-links li:nth-child(7) {
                transition: all 0.5s ease 1s;
            }

            li.fade {
                opacity: 1;
            }

            body {
                background-position: initial;
            }
        }

        .toggle .line-one {
            transform: rotate(-45deg) translate(-5px, 7px);
        }

        .toggle .line-two {
            transition: all 0.7s ease;
            width: 0;
        }

        .toggle .line-three {
            transform: rotate(45deg) translate(-5px, -7px);
        }

        .socialicons {
            position: absolute;
            right: 5%;
            bottom: 8%;
        }

        .socialicons img {
            width: 25px;
            display: block;
            margin: 25px 5px;
        }

        .container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 50px;
        }

        .content-container {
            padding: 20px;
            width: 45%;
            background: transparent;
        }

        .content-container h2 {
            color: #150a50;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .content-container p {
            font-size: 16px;
            line-height: 1.5;
            color: black;
        }

        footer {
            background-color: #13335b;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

        .getstarted {
            margin-left: 40%;
        }

        .button-49,
        .button-49:after {
            width: 150px;
            height: 76px;
            line-height: 78px;
            font-size: 20px;
            font-family: 'Bebas Neue', sans-serif;
            background: linear-gradient(45deg, transparent 5%, #4a73ec 5%);
            border: 0;
            color: #fff;
            letter-spacing: 3px;
            box-shadow: 6px 0px 0px #00E6F6;
            outline: transparent;
            position: relative;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        .button-49:after {
            --slice-0: inset(50% 50% 50% 50%);
            --slice-1: inset(80% -6px 0 0);
            --slice-2: inset(50% -6px 30% 0);
            --slice-3: inset(10% -6px 85% 0);
            --slice-4: inset(40% -6px 43% 0);
            --slice-5: inset(80% -6px 5% 0);
            content: 'ALTERNATE TEXT';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 3%, #00E6F6 3%, #00E6F6 5%, #FF013C 5%);
            text-shadow: -3px -3px 0px #F8F005, 3px 3px 0px #00E6F6;
            clip-path: var(--slice-0);
        }

        .button-49:hover:after {
            animation: 1s glitch;
            animation-timing-function: steps(2, end);
        }

        @keyframes glitch {
            0% {
                clip-path: var(--slice-1);
                transform: translate(-20px, -10px);
            }

            10% {
                clip-path: var(--slice-3);
                transform: translate(10px, 10px);
            }

            20% {
                clip-path: var(--slice-1);
                transform: translate(-10px, 10px);
            }

            30% {
                clip-path: var(--slice-3);
                transform: translate(0px, 5px);
            }

            40% {
                clip-path: var(--slice-2);
                transform: translate(-5px, 0px);
            }

            50% {
                clip-path: var(--slice-3);
                transform: translate(5px, 0px);
            }

            60% {
                clip-path: var(--slice-4);
                transform: translate(5px, 10px);
            }

            70% {
                clip-path: var(--slice-2);
                transform: translate(-10px, 10px);
            }

            80% {
                clip-path: var(--slice-5);
                transform: translate(20px, -10px);
            }

            90% {
                clip-path: var(--slice-1);
                transform: translate(-10px, 0px);
            }

            100% {
                clip-path: var(--slice-1);
                transform: translate(0);
            }
        }

        @media (min-width: 768px) {

            .button-49,
            .button-49:after {
                width: 200px;
                height: 86px;
                line-height: 88px;
            }
        }

        /**/
        .album .responsive-container-block {
            min-height: 75px;
            height: fit-content;
            width: 100%;
            padding-top: 10px;
            padding-right: 10px;
            padding-bottom: 10px;
            padding-left: 10px;
            display: flex;
            flex-wrap: wrap;
            margin-top: 0px;
            margin-right: auto;
            margin-bottom: 0px;
            margin-left: auto;
            justify-content: flex-start;
        }

        .album .responsive-container-block.bg {
            max-width: 1320px;
            margin: 0 0 0 0;
            justify-content: space-between;
        }

        .album .img {
            width: 100%;
            margin: 0 0 20px 0;
        }

        .album #i9rb {
            color: black;
        }

        .album #ir6i {
            color: black;
        }

        .album #ikz3b {
            color: black;
        }

        .album .responsive-container-block.img-cont {
            flex-direction: column;
            max-width: 33.3%;
            min-height: auto;
            margin: 0 0 0 0;
            height: 100%;
        }

        .album #ipix {
            color: black;
        }

        .album #ipzoh {
            color: black;
        }

        .album #ig5q8 {
            color: black;
        }

        .album #imtzl {
            color: black;
        }

        .album #i53es {
            color: black;
        }

        .album .img.img-big {
            height: 50%;
            margin: 0 0 16px 0;
        }

        @media (max-width: 1024px) {
            .album .img {
                margin: 0 0 18px 0;
            }
        }

        @media (max-width: 768px) {
            .album .img {
                max-width: 32.5%;
                margin: 0 0 0 0;
            }

            .album .responsive-container-block.bg {
                flex-direction: column;
            }

            .album .responsive-container-block.img-cont {
                max-width: 100%;
                flex-direction: row;
                justify-content: space-between;
            }

            .album .img.img-big {
                max-width: 49%;
                margin: 0 0 0 0;
            }
        }

        @media (max-width: 500px) {
            .album .img {
                max-width: 94%;
                margin: 0 0 25px 0;
            }

            .album .responsive-container-block.img-cont {
                flex-direction: column;
                align-items: center;
                padding: 10px 10px 10px 10px;
            }

            .album .img.img-big {
                max-width: 94%;
                margin: 0 0 25px 0;
            }

            .album .img.img-last {
                margin: 0 0 5px 0;
            }
        }

        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800&amp;display=swap');

        *,
        *:before,
        *:after {
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

        .wk-desk-1 {
            width: 8.333333%;
        }

        .wk-desk-2 {
            width: 16.666667%;
        }

        .wk-desk-3 {
            width: 25%;
        }

        .wk-desk-4 {
            width: 33.333333%;
        }

        .wk-desk-5 {
            width: 41.666667%;
        }

        .wk-desk-6 {
            width: 50%;
        }

        .wk-desk-7 {
            width: 58.333333%;
        }

        .wk-desk-8 {
            width: 66.666667%;
        }

        .wk-desk-9 {
            width: 75%;
        }

        .wk-desk-10 {
            width: 83.333333%;
        }

        .wk-desk-11 {
            width: 91.666667%;
        }

        .wk-desk-12 {
            width: 100%;
        }

        @media (max-width: 1024px) {
            .wk-ipadp-1 {
                width: 8.333333%;
            }

            .wk-ipadp-2 {
                width: 16.666667%;
            }

            .wk-ipadp-3 {
                width: 25%;
            }

            .wk-ipadp-4 {
                width: 33.333333%;
            }

            .wk-ipadp-5 {
                width: 41.666667%;
            }

            .wk-ipadp-6 {
                width: 50%;
            }

            .wk-ipadp-7 {
                width: 58.333333%;
            }

            .wk-ipadp-8 {
                width: 66.666667%;
            }

            .wk-ipadp-9 {
                width: 75%;
            }

            .wk-ipadp-10 {
                width: 83.333333%;
            }

            .wk-ipadp-11 {
                width: 91.666667%;
            }

            .wk-ipadp-12 {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .wk-tab-1 {
                width: 8.333333%;
            }

            .wk-tab-2 {
                width: 16.666667%;
            }

            .wk-tab-3 {
                width: 25%;
            }

            .wk-tab-4 {
                width: 33.333333%;
            }

            .wk-tab-5 {
                width: 41.666667%;
            }

            .wk-tab-6 {
                width: 50%;
            }

            .wk-tab-7 {
                width: 58.333333%;
            }

            .wk-tab-8 {
                width: 66.666667%;
            }

            .wk-tab-9 {
                width: 75%;
            }

            .wk-tab-10 {
                width: 83.333333%;
            }

            .wk-tab-11 {
                width: 91.666667%;
            }

            .wk-tab-12 {
                width: 100%;
            }
        }

        @media (max-width: 500px) {
            .wk-mobile-1 {
                width: 8.333333%;
            }

            .wk-mobile-2 {
                width: 16.666667%;
            }

            .wk-mobile-3 {
                width: 25%;
            }

            .wk-mobile-4 {
                width: 33.333333%;
            }

            .wk-mobile-5 {
                width: 41.666667%;
            }

            .wk-mobile-6 {
                width: 50%;
            }

            .wk-mobile-7 {
                width: 58.333333%;
            }

            .wk-mobile-8 {
                width: 66.666667%;
            }

            .wk-mobile-9 {
                width: 75%;
            }

            .wk-mobile-10 {
                width: 83.333333%;
            }

            .wk-mobile-11 {
                width: 91.666667%;
            }

            .wk-mobile-12 {
                width: 100%;
            }
        }

        .img {
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <nav>
        <div class="logo">
            <p style="font-weight: 700;font-size:18px">WiseWalletPro</p>
        </div>
        <div class="hamburger">
            <div class="line-one"></div>
            <div class="line-two"></div>
            <div class="line-three"></div>
        </div>
        <ul class="nav-links">
            <li><a href="#HowItWorks">How It Works</a></li>
            <li><a href="#Galerie">Galerie</a></li>
            <li><a href="#ContactUs">contact us</a></li>
            <li>
                @if (Route::has('login'))
                    <div class="nav__auth">
                        @auth
                            <a href="{{ url('/home') }}">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </li>

        </ul>
    </nav>
    <div class="container">
        <div class="content-container">
            <h2>Empower Your Finances with Smart Budgeting and Saving Optimization</h2>
            <p>Discover our features, optimize savings, and transform financial aspirations into reality with
                WiseWalletPro. We support you through every step of household budgeting and expense management.</p>
            <p>With our intuitive tools and personalized insights, you can gain full control over your finances and make
                informed decisions to achieve your financial goals.</p>
        </div>
        <div id="HowItWorks">
            <img src="{{ asset('assets/home.png') }}" alt="Home Image">
        </div>
    </div>
    <div>
        <div class="container" style="margin-top: 10%;margin-left:50px">
            <div class="content-container">
                <img src="{{ asset('assets/goodBudget.jpg') }}" alt="" style="width: 80%;height:80%">
            </div>
            <div class="content-container">
                <h1 style="color: #150a50">Become a Goodbudgeter</h1>
                <p>Embark on your journey to becoming a savvy budgeter with our intuitive WiseWalletPro app. Gain the
                    skills
                    and knowledge needed to take control of your finances and achieve your financial goals. Whether
                    you're
                    saving for a dream vacation, planning for retirement, or simply seeking to manage your day-to-day
                    expenses more
                    effectively, WiseWalletPro equips you with the tools and insights to succeed. With features designed
                    to
                    simplify budgeting, track expenses, and optimize savings, you'll develop the habits of a good
                    budgeter
                    in no time. Start your financial transformation today with WiseWalletPro</p>
            </div>
        </div>
        <div class="container" style="margin-left:50px">
            <div class="content-container" style="width:50%;margin-right:10%">
                <h1 style="color:#150a50">No more surprises</h1>
                <p>Experience financial peace of mind with WiseWalletPro's commitment to transparency
                    and clarity. Say goodbye to unwelcome financial surprises and unexpected expenses. Our comprehensive
                    budgeting tools and real-time expense tracking empower you to stay ahead of your finances, allowing
                    you
                    to anticipate and plan for upcoming expenses with confidence. With WiseWalletPro, you'll always know
                    where your money is going, ensuring no surprises catch you off guard. Take control of your financial
                    future and enjoy a stress-free approach to managing your money with WiseWalletPro.</p>
            </div>
            <div>
                <img src="{{ asset('assets/surprise.png') }}" alt=""
                    style="width: 80%;height:80%;margin-left:100px;">
            </div>
        </div>
    </div>

    <div id="Galerie" style="margin-top: 200px">
        <h1 style="color: #150a50">
            Gallery
        </h1>
        <div class="album">
            <div class="responsive-container-block bg">
                <div class="responsive-container-block img-cont">
                    <img class="img" src="assets/cap1.png">
                    <img class="img" src="assets/Cap11.png">
                    <img class="img img-last" src="assets/Cap12.png">
                </div>
                <div class="responsive-container-block img-cont">
                    <img class="img img-big" src="assets/Cap2.png">
                    <img class="img img-big img-last" src="assets/Cap3.png">
                    <img class="img" src="assets/start.gif">
                </div>
                <div class="responsive-container-block img-cont">
                    <img class="img" src="assets/Cap4.png">
                    <img class="img" src="assets/cap41.png">
                    <img class="img" src="assets/Cap5.png">
                </div>
            </div>
        </div>

    </div>
    <div class="getstarted">
        <h2 style="color: #150a50;font-size:28px;font-weight:700">Get Started Now</h2>
        @if (Route::has('register'))
            <button class="button-49" role="button"><a href="{{ route('register') }}"
                    style="text-decoration: none;color:#fff;margin:0 auto">Register</a></button>
        @endif
    </div>
    <footer id="ContactUs">
        <p>&copy; {{ date('Y') }} WiseWalletPro. Tous droits réservés.</p>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var images = document.querySelectorAll(".img");
            images.forEach(function(img, index) {
                setTimeout(function() {
                    img.classList.add("show");
                }, 200 * index); // Adjust timing as needed
            });
        });
    </script>
    <script>
        const hamburger = document.querySelector(".hamburger");
        const navLinks = document.querySelector(".nav-links");
        const links = document.querySelectorAll(".nav-links li");

        hamburger.addEventListener("click", () => {
            navLinks.classList.toggle("open");
            links.forEach((link) => {
                link.classList.toggle("fade");
            });
            hamburger.classList.toggle("toggle");
        });
    </script>
</body>

</html>
