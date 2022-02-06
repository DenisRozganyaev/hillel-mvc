<?php
\Core\View::render('parts/header', ['title' => 'Login']);
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 d-flex flex-md-column align-content-center align-self-center">
                <h1 class="display-4">Login Page</h1>
                <?php if(!empty($_SESSION['errors']['login']['common'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['errors']['login']['common']; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="/auth">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email"
                               class="form-control"
                               name="email"
                               id="email"
                               placeholder="email@email.com"
                               value="<?php echo !empty($data['email']) ? $data['email'] : ''; ?>"
                               required
                        />
                        <?php if(!empty($email_error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $email_error; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password"
                               class="form-control"
                               name="password"
                               id="password"
                               value="<?php echo !empty($data['password']) ? $data['password'] : ''; ?>"
                               required
                        />
                        <?php if(!empty($password_error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $password_error; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Authorize</button>
                </form>
            </div>
            <div class="col-sm-4">
                <a class="btn btn-info" href="/registration">Create an account</a>
            </div>
        </div>
    </div>
<?php
\Core\View::render('parts/footer');
