<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anak Kost - Reinventing Living</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <section id="home">
        <div class="background"></div>
        <div class="overlay"></div>

        <div class="content">
            <nav class="nav">
                <a onclick="scrollToAbout()">ABOUT US</a>
                <a href="{{ route('login') }}">LOGIN</a>
            </nav>

            <div class="hero">
                <h1>ANAK KOST</h1>
                <p>LIVING MADE SIMPLER</p>
            </div>
        </div>
    </section>

    <section id="about" class="about-section">
        <div class="about-header">
            <a class="about-back" onclick="scrollToHome()">Home</a>
        </div>

        <div class="about-content">
            <p class="about-subtitle">A Kost managing Platform</p>
            <h2 class="about-title">ANAK KOST</h2>
            <div class="about-description">
                <p>We manage your Building needs</p>
                <p>easy living for you</p>
            </div>
        </div>

        <div class="about-footer">
            <p>Contact</p>
            <p>@ANAKKOST</p>
        </div>
    </section>

    <button class="scroll-top" id="scrollTop" onclick="scrollToHome()">
        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M23.245 20l-11.245-14.374-11.219 14.374-.781-.619 12-15.381 12 15.391-.755.609z"/></svg>
    </button>

    <script>
        let suppressAboutAnimation = false;
        let scrollingToHome = false;
        let animationHasPlayed = false;
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Home' || e.key === 'ArrowUp') {
                suppressAboutAnimation = true;
                scrollingToHome = true;
                setTimeout(function() { 
                    suppressAboutAnimation = false; 
                    scrollingToHome = false;
                }, 3000);
            }
        });

        function smoothScroll(target, duration = 1800) {
            const targetElement = document.getElementById(target);
            const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
            const startPosition = window.pageYOffset;
            const distance = targetPosition - startPosition;
            let startTime = null;

            function animation(currentTime) {
                if (startTime === null) startTime = currentTime;
                const timeElapsed = currentTime - startTime;
                const run = easeInOutCubic(timeElapsed, startPosition, distance, duration);
                window.scrollTo(0, run);
                if (timeElapsed < duration) requestAnimationFrame(animation);
            }

            function easeInOutCubic(t, b, c, d) {
                t /= d / 2;
                if (t < 1) return c / 2 * t * t * t + b;
                t -= 2;
                return c / 2 * (t * t * t + 2) + b;
            }

            requestAnimationFrame(animation);
        }

        function scrollToAbout() {
            const aboutSection = document.getElementById('about');
            aboutSection.classList.remove('visible');
            smoothScroll('about');
            setTimeout(() => {
                if (!animationHasPlayed) {
                    aboutSection.classList.add('visible');
                    animationHasPlayed = true;
                }
            }, 800);
        }

        function scrollToHome() {
            suppressAboutAnimation = true;
            scrollingToHome = true;
            smoothScroll('home');
            setTimeout(function() { 
                suppressAboutAnimation = false;
                scrollingToHome = false;
            }, 3000);
        }

        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            const scrollTop = document.getElementById('scrollTop');
            const aboutSection = document.getElementById('about');
            const aboutRect = aboutSection.getBoundingClientRect();
            const currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollingToHome || suppressAboutAnimation) {
                if (scrollTop && aboutRect.top < window.innerHeight / 2) {
                    scrollTop.classList.add('visible');
                } else if (scrollTop) {
                    scrollTop.classList.remove('visible');
                }
                lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
                return;
            }
            
            if (aboutRect.top < window.innerHeight * 0.7) {
                if (!animationHasPlayed) {
                    aboutSection.classList.add('visible');
                    animationHasPlayed = true;
                } else if (!aboutSection.classList.contains('visible')) {
                    aboutSection.classList.add('visible');
                    aboutSection.style.animation = 'none';
                }
            }
            
            if (scrollTop && aboutRect.top < window.innerHeight / 2) {
                scrollTop.classList.add('visible');
            } else if (scrollTop) {
                scrollTop.classList.remove('visible');
            }
            
            lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
        });
    </script>
</body>
</html>
