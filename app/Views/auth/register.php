<?php
\Core\View::render('parts/header', ['title' => 'Create An Account']);
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 d-flex flex-md-column align-content-center align-self-center">
                <h1 class="display-4">Create An Account</h1>
                <form method="POST" action="/user/store">
                    <div class="form-group">
                        <label for="nickname">Nickname</label>
                        <input type="text"
                               class="form-control"
                               name="nickname"
                               id="nickname"
                               placeholder="Nickname"
                               value="<?php echo !empty($data['nickname']) ? $data['nickname'] : ''; ?>"
                               required
                        />
                        <?php if(!empty($nickname_error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $nickname_error; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text"
                               class="form-control"
                               name="first_name"
                               id="first_name"
                               placeholder="First Name"
                               value="<?php echo !empty($data['first_name']) ? $data['first_name'] : ''; ?>"
                               required
                        />
                        <?php if(!empty($first_name_error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $first_name_error; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text"
                               class="form-control"
                               name="last_name"
                               id="last_name"
                               placeholder="Last Name"
                               value="<?php echo !empty($data['last_name']) ? $data['last_name'] : ''; ?>"
                        />
                        <?php if(!empty($last_name_error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $last_name_error; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Birthdate</label>
                        <input type="date"
                               class="form-control"
                               name="birthdate"
                               id="birthdate"
                               value="<?php echo !empty($data['birthdate']) ? $data['birthdate'] : ''; ?>"
                               required
                        />
                        <?php if(!empty($birthdate_error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $birthdate_error; ?>
                            </div>
                        <?php endif; ?>
                    </div>
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
                    <button type="submit" class="btn btn-primary">Create An Account</button>
                </form>
            </div>
        </div>
    </div>
<?php
\Core\View::render('parts/footer');
