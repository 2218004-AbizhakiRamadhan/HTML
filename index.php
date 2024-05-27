<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FLASH GYM</title>
    <style>
        /* CSS styling */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url(1.jpg) no-repeat center fixed;
            background-size: cover;
        }

        .navbar {
            background-color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #ccc;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .navbar ul li {
            display: inline;
            margin-right: 20px;
        }

        .navbar ul li a {
            text-decoration: none;
            color: #000;
        }

        .button {
            text-align: center;
            padding: 50px 0;
            background-position: center;
            color: #fff;
        }

        .location {
            text-align: center;
            padding: 50px 0;
            background-color: #f2f2f2;
        }

        .free-trial-btn,
        .join-now-btn {
            background-color: #535151;
            color: #fff;
            border: none;
            border-radius: 8%;
            opacity: 89%;
            padding: 20px 40px;
            font-size: 18px;
            margin-right: 10px;
            cursor: pointer;
        }

        /* Carousel styling */
        .carousel {
            width: 100%;
            overflow: hidden;
            position: relative;
            margin-top: 20px;
            text-align: center; 
        }

        .carousel-container {
            display: flex;
            justify-content: center; 
            transition: transform 0.5s ease;
            border-radius: 30px;
        }

        .carousel-item {
            flex: 0 0 auto;
            max-width: 50%;
            margin: 0 10px; 
        }

        .carousel-item img {
            max-width: 100%;
            height: auto; 
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            z-index: 1;
            border-radius: 50px;
        }

        .prev {
            left: 780px;
        }

        .next {
            right: 780px;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">FLASH GYM</div>
            <nav>
                <ul>
                    <li><a href="#">Contact Service</a></li>
                </ul>
            </nav>
        </div>
        <section class="location" id="locationSection">
            <h2>WELCOME TO FLASH GYM</h2>
        </section>
        
            <!-- Carousel -->
    <div class="carousel">
        <div class="carousel-container">
            <div class="carousel-item"><img src="isi1.jpg" alt="Image 1"></div>
            <div class="carousel-item"><img src="isi2.jpg" alt="Image 2"></div>
        </div>
        <button class="carousel-button prev" onclick="prevSlide()">&#10094;</button>
        <button class="carousel-button next" onclick="nextSlide()">&#10095;</button>
    </div>

        <div class="button">
            <a href="Login.php"><button class="free-trial-btn">LOGIN</button></a>
            <a href="Register.php"><button class="join-now-btn">JOIN NOW</button></a>
        </div>
    </header>

    <!-- DOM -->
    <script>
        // Mengubah transparansi latar belakang .location
        document.querySelector(".location").style.backgroundColor = "rgba(242, 242, 242, 0.5)";

        // Fungsi untuk navigasi carousel
        let slideIndex = 0;
        showSlide(slideIndex);

        function prevSlide() {
            showSlide(slideIndex -= 1);
        }

        function nextSlide() {
            showSlide(slideIndex += 1);
        }

        function showSlide(index) {
            const slides = document.querySelectorAll('.carousel-item');
            if (index >= slides.length) { slideIndex = 0; }
            if (index < 0) { slideIndex = slides.length - 1; }
            slides.forEach(slide => {
                slide.style.display = 'none';
            });
            slides[slideIndex].style.display = 'block';
        }
    </script>
</body>
</html>