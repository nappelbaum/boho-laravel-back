<form method="POST" action="" method="POST">
    @csrf
    <div class="form-group">
        <p>Login</p>
        <input class="form-control" name="email" type="email" required value="">
    </div>

    <div class="form-group">
        <p>Password</p>
        <input class="form-control" name="password" type="password" required>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit">Login</button>
    </div>
</form>