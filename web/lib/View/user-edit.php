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
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item"><?= $user->getEmail() ?></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>
                <?= $user->getEmail() ?>
                <small class="text-muted">: edit</small>
            </h2>
            
            <form id="user-edit-form">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="id" value="<?= $user->getId() ?>">
                
                <div class="form-group row">
                    <label for="user-edit-form-id" class="col-sm-2 col-form-label">Identifier</label>
                    <div class="col-sm-10">
                        <input type="text" name="id" id="user-edit-form-id" class="form-control" value="<?= $user->getId() ?>" disabled="disabled">
                        <small class="form-text text-muted">Identifier of this user, cannot be changed.</small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="user-edit-form-email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" value="<?= $user->getEmail() ?>" id="user-edit-form-email" class="form-control" placeholder="Email address">
                        <small class="form-text text-muted">Institutional email address of this user.</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user-edit-form-password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="user-edit-form-password" placeholder="Password" value="">
                        <small class="form-text text-muted">
                            Leave empty to keep current password.
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user-edit-form-affiliation" class="col-sm-2 col-form-label">Affiliation</label>
                    <div class="col-sm-10">
                        <input type="text" name="affiliation" class="form-control" id="user-edit-form-affiliation" placeholder="Affiliation" value="<?= $user->getAffiliation() ?>">
                        <small class="form-text text-muted">
                            User's institution's name.
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user-edit-form-role" class="col-sm-2 col-form-label">Level</label>
                    <div class="col-sm-10">
                        <select name="role" id="user-edit-form-role" class="form-control">
                            <option value="simple" <?= ($user->getRole() === 'simple' ? 'selected' : '') ?>>Simple</option>
                            <option value="editor" <?= ($user->getRole() === 'editor' ? 'selected' : '') ?>>Editor</option>
                            <option value="admin" <?= ($user->getRole() === 'admin' ? 'selected' : '') ?>>Admin</option>
                        </select>
                        <small class="form-text text-muted">
                            Level of this user: simple, editor (can publish new data), admin (can publish data and manage other users).
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary btn-block">Save changes</button>
                    </div>
                </div>
            </form>
            
            <h3>Delete</h3>
            <form id="user-delete-form">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="id" value="<?= $user->getId() ?>">

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-danger btn-block">Delete user</button>
                        <small class="form-text text-muted"><strong>Warning:</strong> This operation cannot be undone.</small>
                    </div>
                </div>
            </form>
        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('widget/alert'); ?>
        
        <?php
        $this->view('scripts');
        $this->view('script', ['url' => '/public/js/alert.js']);
        $this->view('script', ['url' => '/public/js/ajax-search.js']);
        $this->view('script', ['url' => '/public/js/user-edit.js']);
        ?>
    </body>
</html>