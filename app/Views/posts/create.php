<?php
\Core\View::render('parts/header.php', ['title' => 'Create Post']);
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 d-flex flex-md-column align-content-center align-self-center">
            <h1 class="display-4">Create Post Form</h1>
            <form method="POST" action="/posts/store">
                <div class="form-group">
                    <label for="postTitle">Title</label>
                    <input type="text"
                           class="form-control"
                           name="title"
                           id="postTitle"
                           placeholder="Post title"
                           value="<?php echo !empty($data['title']) ? $data['title'] : ''; ?>"
                    />
                    <?php if(!empty($title_error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $title_error; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="postContent">Content</label>
                    <textarea name="content" id="postContent" class="form-control" cols="30" rows="10"><?php echo !empty($data['content']) ? $data['content'] : ''; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create Post</button>
            </form>
        </div>
    </div>
</div>
<?php
\Core\View::render('parts/footer.php');
