<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Mitopaths</title>
        
        <?php $this->view('head'); ?>
    </head>
    
    <body>
        <header>
            <?php $this->view('navbar'); ?>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">mitopatHs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Login</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>Login</h2>
            <p>
                <small class="text-muted">To suggest a new pathway, to notify some issue, or to contact our team, please login and fill the dedicated form.</small>
            </p>
            
            <div class="alert alert-info" role="alert" id="error-login">
                Wrong email or password.
            </div>
            
            <form id="form-login">
                <div class="form-group row">
                    <label for="input-email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="input-email" placeholder="Email">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="input-password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="input-password" placeholder="Password">
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <p>Don't have an account? Click <a href="/register">here to register</a>.</p>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                </div>
            </form>
        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('scripts'); ?>
        <?php $this->view('script', ['url' => '/public/js/login.js']); ?>
    </body>
</html>
