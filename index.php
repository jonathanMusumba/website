<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lubega Nursing Institute</title>
    <link rel="stylesheet" href="css/styles.css">
    
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5W<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const slides = document.querySelectorAll(".slide");
            const title = document.querySelector(".title");

            let currentSlide = 0;
            let currentColor = 0;

            setInterval(() => {
                // Change slide opacity
                slides[currentSlide].classList.remove("active");
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add("active");

                // Change title color
                const colors = ["#FFF", "#008000", "#800000"]; // White, Green, Maroon
                title.style.color = colors[currentColor];
                currentColor = (currentColor + 1) % colors.length;
            }, 5000);
        });
    </script>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-green shadow">
        <div class="container">
            <a class="navbar-brand" href="# "><img src="images/logo.png "></a>
            <button class="navbar-toggler " type="button " data-bs-toggle="collapse " data-bs-target="#navbarSupportedContent " aria-controls="navbarSupportedContent " aria-expanded="false " aria-label="Toggle navigation ">
            <span class="navbar-toggler-icon "></span>
          </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent ">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                    <li class="nav-item ">
                        <a class="nav-link active " aria-current="page " href="https://www.lubeganursinginstitute.com" target="_blank" rel="noopener noreferrer">Home</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link " href="Applications/Biodata.html">Apply</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link " href="login.html">Login Admin</a>
                    </li>
            </div>
        </div>
    </nav>
    <div class="slideshow">
        <div class="slide active">
            <img src="images/img1.jpg" alt="Slide 1">
        </div>
        <div class="slide">
            <img src="images/img2.JPG" alt="Slide 2">
        </div>
        <div class="slide">
            <img src="images/img4.JPG" alt="Slide 3">
        </div>
        <div class="slide">
            <img src="images/img5.JPG" alt="Slide 3">
        </div>
        <div class="slide">
            <img src="images/img6.JPG" alt="Slide 3">
        </div>
        <div class="slide">
            <img src="images/img7.JPG" alt="Slide 3">
        </div>
    </div>
    <div class="center">
        <div class="title">Enter to learn go forth to serve</div>
        <div class="btns">
            <a href="https://www.lubeganursinginstitute.com" target="_blank" rel="noopener noreferrer">
                <button>Learn More</button>
            </a>
            <a href="Applications/Biodata.html">
                <button>Apply Now</button>
            </a>
        </div>
    </div>

</body>

</html>