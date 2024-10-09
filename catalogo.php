<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] !== 'Usuario') {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteka - Catálogo de Préstamos</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #000000;
            --secondary: #333333;
            --accent: #0077b6;
            --text: #333333;
            --background: #f5f5f5;
            --card-bg: #ffffff;
            --available: #2ecc71;
            --unavailable: #e74c3c;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        nav {
            background-color: var(--primary);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-links a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .loans-button {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background-color: var(--accent);
            color: #ffffff;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .loans-button:hover {
            transform: scale(1.1);
            background-color: var(--secondary);
        }

        .loans-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--primary);
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: bold;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        header {
            background-color: var(--primary);
            color: #ffffff;
            padding: 3rem 0;
            text-align: center;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .search-bar {
            display: flex;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-bar input {
            flex-grow: 1;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border: none;
            border-radius: 4px 0 0 4px;
            outline: none;
        }

        .search-bar button {
            background-color: var(--accent);
            color: #ffffff;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 0 4px 4px 0;
            transition: background-color 0.3s ease;
        }

        .search-bar button:hover {
            background-color: var(--secondary);
        }

        main {
            padding: 3rem 0;
            flex-grow: 1;
        }

        .filters {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .filter-btn {
            background-color: var(--card-bg);
            color: var(--text);
            border: 1px solid var(--secondary);
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .filter-btn:hover, .filter-btn.active {
            background-color: var(--secondary);
            color: #ffffff;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }

        .book-card {
            background-color: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .book-cover {
            height: 300px;
            background-color: var(--secondary);
            position: relative;
            overflow: hidden;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .book-card:hover .book-cover img {
            transform: scale(1.05);
        }

        .book-info {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .book-card h2 {
            font-family: 'Playfair Display', serif;
            color: var(--primary);
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .book-card:hover h2 {
            color: var(--accent);
        }

        .book-card .author {
            color: var(--text);
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .book-card .genre {
            color: var(--secondary);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .book-card .availability {
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.5rem;
            border-radius: 4px;
            display: inline-block;
            margin-top: auto;
            text-align: center;
            transition: all 0.3s ease;
        }

        .book-card .availability.available {
            color: #ffffff;
            background-color: var(--available);
        }

        .book-card .availability.unavailable {
            color: #ffffff;
            background-color: var(--unavailable);
        }

        .borrow-button {
            background-color: var(--accent);
            color: #ffffff;
            border: none;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            margin-top: 1rem;
        }

        .borrow-button:hover {
            background-color: var(--secondary);
        }

        .borrow-button:disabled {
            background-color: var(--unavailable);
            cursor: not-allowed;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination button {
            background-color: var(--accent);
            color: #ffffff;
            border: none;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            margin: 0 0.5rem;
        }

        .pagination button:hover {
            background-color: var(--secondary);
        }

        .pagination button:disabled {
            background-color: var(--unavailable);
            cursor: not-allowed;
        }

        footer {
            background-color: var(--primary);
            color: #ffffff;
            padding: 2rem 0;
            margin-top: auto;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-links {
            display: flex;
            gap: 1rem;
        }

        .footer-links a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--accent);
        }

        @media (max-width: 768px) {
            .nav-links a {
                display: none;
            }

            .book-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }

            .filters {
                flex-wrap: wrap;
            }

            .footer-content {
                flex-direction: column;
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 0.5rem;
            }

            .book-grid {
                gap: 1rem;
            }

            .book-cover {
                height: 200px;
            }

            .loans-button {
                bottom: 1rem;
                right: 1rem;
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="container">
            <a href="index.php" class="logo">Biblioteka</a>
            <div class="nav-links">
                <a href="#">Inicio</a>
                <a href="#">Catálogo</a>
                <a href="#">Mis Préstamos</a>
            </div>
        </div>
    </nav>

    <header>
        <div class="container">
            <h1>Descubre y pide prestado tu próxima lectura</h1>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Buscar por título, autor o género">
                <button id="searchButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="filters">
                <button class="filter-btn active" data-genre="all">Todos</button>
                <button class="filter-btn" data-genre="Ficción">Ficción</button>
                <button class="filter-btn" data-genre="No ficción">No ficción</button>
                <button class="filter-btn" data-genre="Ciencia Ficción">Ciencia Ficción</button>
                <button class="filter-btn" data-genre="Romance">Romance</button>
            </div>
            <div id="bookGrid" class="book-grid">
                <!-- Books will be dynamically inserted here -->
            </div>
            <div class="pagination">
                <button id="prevPage" disabled>Anterior</button>
                <button id="nextPage">Siguiente</button>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <p>&copy; 2024 Biblioteka. Todos los derechos reservados.</p>
                <div class="footer-links">
                    <a href="#">Términos de servicio</a>
                    <a href="#">Política de privacidad</a>
                    <a href="#">Contacto</a>
                </div>
            </div>
        </div>
    </footer>

    <button class="loans-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
        <span id="loansCount" class="loans-count">0</span>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookGrid = document.getElementById('bookGrid');
            const prevButton = document.getElementById('prevPage');
            const nextButton = document.getElementById('nextPage');
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');
            const filterButtons = document.querySelectorAll('.filter-btn');
            const loansCountElement = document.getElementById('loansCount');

            const booksPerPage = 12;
            let currentPage = 1;
            let currentFilter = 'all';
            let books = [];
            let borrowedBooks = [];

            // Fetch books data
            fetch('https://raw.githubusercontent.com/benoitvallon/100-best-books/master/books.json')
                .then(response => response.json())
                .then(data => {
                    books = data.map(book => ({
                        ...book,
                        genre: book.genre || 'No ficción', // Default genre if not provided
                        available: Math.random() < 0.8 // 80% chance of being available
                    }));
                    renderBooks();
                })
                .catch(error => console.error('Error fetching books:', error));

            function renderBooks() {
                const filteredBooks = books.filter(book => 
                    (currentFilter === 'all' || book.genre === currentFilter) &&
                    (searchInput.value === '' || 
                     book.title.toLowerCase().includes(searchInput.value.toLowerCase()) ||
                     book.author.toLowerCase().includes(searchInput.value.toLowerCase()) ||
                     book.genre.toLowerCase().includes(searchInput.value.toLowerCase()))
                );

                const startIndex = (currentPage - 1) * booksPerPage;
                const endIndex = startIndex + booksPerPage;
                const booksToShow = filteredBooks.slice(startIndex, endIndex);

                bookGrid.innerHTML = booksToShow.map(book => `
                    <article class="book-card">
                        <div class="book-cover">
                            <img src="${book.imageLink}" alt="Portada de ${book.title}">
                        </div>
                        <div class="book-info">
                            <h2>${book.title}</h2>
                            <p class="author">${book.author}</p>
                            <p class="genre">${book.genre}</p>
                            <p class="availability ${book.available ? 'available' : 'unavailable'}">
                                ${book.available ? 'Disponible' : 'No disponible'}
                            </p>
                            <button class="borrow-button" ${!book.available ? 'disabled' : ''} 
                                    onclick="borrowBook('${book.title}')">
                                Pedir prestado
                            </button>
                        </div>
                    </article>
                `).join('');

                updatePaginationButtons(filteredBooks.length);
            }

            function updatePaginationButtons(totalBooks) {
                prevButton.disabled = currentPage === 1;
                nextButton.disabled = currentPage >= Math.ceil(totalBooks / booksPerPage);
            }

            prevButton.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderBooks();
                }
            });

            nextButton.addEventListener('click', () => {
                if (currentPage < Math.ceil(books.length / booksPerPage)) {
                    currentPage++;
                    renderBooks();
                }
            });

            searchButton.addEventListener('click', () => {
                currentPage = 1;
                renderBooks();
            });

            searchInput.addEventListener('keyup', (event) => {
                if (event.key === 'Enter') {
                    currentPage = 1;
                    renderBooks();
                }
            });

            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    currentFilter = button.dataset.genre;
                    currentPage = 1;
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    renderBooks();
                });
            });

            window.borrowBook = function(title) {
                const book = books.find(b => b.title === title);
                if (book && book.available) {
                    book.available = false;
                    borrowedBooks.push(book);
                    loansCountElement.textContent = borrowedBooks.length;
                    renderBooks();
                }
            };
        });
    </script>
</body>
</html>