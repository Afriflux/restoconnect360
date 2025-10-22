<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RestoConnect360 - Plateforme de Restauration Digitale</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            color: #1f2937;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #16a34a;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #6b7280;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: #16a34a;
        }
        
        .btn {
            background: #16a34a;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #15803d;
        }
        
        .hero {
            text-align: center;
            padding: 4rem 0;
        }
        
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #111827;
        }
        
        .hero p {
            font-size: 1.25rem;
            color: #6b7280;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .search-box {
            display: flex;
            max-width: 500px;
            margin: 0 auto;
            gap: 0;
        }
        
        .search-box input {
            flex: 1;
            padding: 1rem;
            border: 2px solid #d1d5db;
            border-radius: 0.5rem 0 0 0.5rem;
            font-size: 1rem;
            outline: none;
        }
        
        .search-box input:focus {
            border-color: #16a34a;
        }
        
        .search-box button {
            border-radius: 0 0.5rem 0.5rem 0;
            padding: 1rem 2rem;
        }
        
        .restaurants {
            padding: 4rem 0;
        }
        
        .restaurants h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 3rem;
            color: #111827;
        }
        
        .restaurant-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }
        
        .restaurant-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        
        .restaurant-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .restaurant-card .emoji {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .restaurant-card h3 {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #111827;
        }
        
        .restaurant-card .category {
            color: #6b7280;
            margin-bottom: 1rem;
        }
        
        .rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .rating .star {
            color: #fbbf24;
            font-size: 1.25rem;
        }
        
        .cta {
            background: #16a34a;
            color: white;
            text-align: center;
            padding: 4rem 0;
        }
        
        .cta h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .cta p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .footer {
            background: #111827;
            color: white;
            text-align: center;
            padding: 3rem 0;
        }
        
        .footer h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .footer p {
            color: #9ca3af;
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .nav-links {
                display: none;
            }
            
            .search-box {
                flex-direction: column;
            }
            
            .search-box input {
                border-radius: 0.5rem 0.5rem 0 0;
            }
            
            .search-box button {
                border-radius: 0 0 0.5rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div class="logo">RestoConnect360</div>
                <ul class="nav-links">
                    <li><a href="#accueil">Accueil</a></li>
                    <li><a href="#restaurants">Restaurants</a></li>
                    <li><a href="#commandes">Commandes</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <button class="btn">Connexion</button>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero" id="accueil">
            <div class="container">
                <h1>Découvrez les meilleurs restaurants</h1>
                <p>Commandez en ligne et profitez d'une livraison rapide dans toute la ville</p>
                <div class="search-box">
                    <input type="text" placeholder="Rechercher un restaurant...">
                    <button>Rechercher</button>
                </div>
            </div>
        </section>

        <section class="restaurants" id="restaurants">
            <div class="container">
                <h2>Nos restaurants partenaires</h2>
                <div class="restaurant-grid">
                    <div class="restaurant-card" onclick="showMenu('Le Gourmet')">
                        <div class="emoji">🍽️</div>
                        <h3>Restaurant Le Gourmet</h3>
                        <p class="category">Français</p>
                        <div class="rating">
                            <span class="star">★</span>
                            <span>4.8</span>
                        </div>
                        <button class="btn" style="width: 100%;">Voir le menu</button>
                    </div>
                    
                    <div class="restaurant-card" onclick="showMenu('Pizza Corner')">
                        <div class="emoji">🍕</div>
                        <h3>Pizza Corner</h3>
                        <p class="category">Italien</p>
                        <div class="rating">
                            <span class="star">★</span>
                            <span>4.6</span>
                        </div>
                        <button class="btn" style="width: 100%;">Voir le menu</button>
                    </div>
                    
                    <div class="restaurant-card" onclick="showMenu('Sushi Master')">
                        <div class="emoji">🍣</div>
                        <h3>Sushi Master</h3>
                        <p class="category">Japonais</p>
                        <div class="rating">
                            <span class="star">★</span>
                            <span>4.9</span>
                        </div>
                        <button class="btn" style="width: 100%;">Voir le menu</button>
                    </div>
                    
                    <div class="restaurant-card" onclick="showMenu('Burger King')">
                        <div class="emoji">🍔</div>
                        <h3>Burger King</h3>
                        <p class="category">Fast Food</p>
                        <div class="rating">
                            <span class="star">★</span>
                            <span>4.3</span>
                        </div>
                        <button class="btn" style="width: 100%;">Voir le menu</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta">
            <div class="container">
                <h2>Prêt à commander ?</h2>
                <p>Inscrivez-vous maintenant et profitez de réductions exclusives</p>
                <button class="btn" onclick="startOrder()">Commencer maintenant</button>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <h3>RestoConnect360</h3>
            <p>La plateforme de restauration digitale qui connecte restaurants et clients</p>
            <p style="margin-top: 1rem; font-size: 0.875rem;">© 2024 RestoConnect360. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        function showMenu(restaurantName) {
            alert(`Menu du ${restaurantName} - Fonctionnalité à venir !`);
        }
        
        function startOrder() {
            alert('Fonctionnalité de commande en ligne - Bientôt disponible !');
        }
        
        // Animation au scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.backdropFilter = 'blur(10px)';
            } else {
                header.style.background = 'white';
                header.style.backdropFilter = 'none';
            }
        });
        
        // Recherche
        document.querySelector('.search-box input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value;
                if (query.trim()) {
                    alert(`Recherche pour: "${query}" - Fonctionnalité à venir !`);
                }
            }
        });
        
        document.querySelector('.search-box button').addEventListener('click', function() {
            const query = document.querySelector('.search-box input').value;
            if (query.trim()) {
                alert(`Recherche pour: "${query}" - Fonctionnalité à venir !`);
            }
        });
    </script>
</body>
</html>
