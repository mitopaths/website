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
                    <li class="breadcrumb-item active" aria-current="page">Register</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>Register</h2>
            
            <div class="alert alert-danger" role="alert" id="error-register">
                Unable to register. Please try again in a few moments.
            </div>
            
            <form id="form-register">
                <div class="form-group row">
                    <label for="input-email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="input-email" placeholder="Email" required>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Please use your official, institutional email address.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="input-password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="input-password" placeholder="Password" required>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Your password sould be 8-20 characters long, containing both letters and numbers.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="input-affiliation" class="col-sm-2 col-form-label">Affiliation</label>
                    <div class="col-sm-10">
                        <input type="text" name="affiliation" class="form-control" id="input-affiliation" placeholder="Affiliation" required>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Your institution's name.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="terms" id="input-check" required>
                            <label class="form-check-label" for="input-check">
                                I have read and accepted <a href="/legal">terms and conditions</a>.
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </div>
            </form>
            
            <div id="thank-you">
                <h3>Thank you!</h3>
                <p>Thank you for registering. You can now access the <a href="/login">login page</a>.</p>
            </div>
        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('scripts'); ?>
        <?php $this->view('script', ['url' => '/public/js/register.js']); ?>
    </body>
</html>