<!DOCTYPE html>
<html>
<head>
    <title>Moja Aplikacija - @yield('title')</title>
    
    <style>
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }
      
      body {
        display: flex;
        flex-direction: column;
        font-family: sans-serif;
        min-height: 100vh;
      }

      header, footer {
        background-color: lightgray;
        display: flex;
        gap: 16px;
        height: 60px;
      }

      main {
        flex-grow: 1;
        padding: 20px;
      }

      nav {
        align-items: center;
        display: flex;
        justify-content: center;
        margin: auto;
      }

      nav > ul {
        align-items: center;
        display: flex;
        gap: 16px;
        list-style-type: none;
      }

      nav > ul li a {
        color: brown;
        text-decoration: none;
      }

      footer p {
        margin: auto;
      }

    </style>

    <!-- stack za dodatne CSS datoteke -->
    @stack('styles')
</head>
<body>
    <header>
        <nav>
          <ul>
            <li>
              <a href="{{ url('/pocetna') }}">Početna</a>
            </li>
            <li>
              <a href="{{ url('/onama') }}">O nama</a>
            </li>
            <li>
              <a href="{{ url('/kontakt') }}">Kontakt</a>
            </li>
          </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2024 Moja Tvrtka</p>
    </footer>
    
    <!-- stack za JavaScript -->
    @stack('scripts')
</body>
</html>