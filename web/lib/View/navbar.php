<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">mitopatHs</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/#page-search">Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/my-account#suggest">Contribute</a>
            </li>
        </ul>
    
    
        <ul class="navbar-nav my-2 my-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="/#page-info">Info</a>
            </li>
            <?php if (\Mitopaths\Session::isAuthenticated()): ?>
            <li class="nav-item">
                <a class="nav-link" href="/my-account">Control Panel</a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="/login">Login</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
