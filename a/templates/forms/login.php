<form action="/public/login.php" method="post">
    <h2>Login</h2>
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <button type="submit">Login</button>
    </div>
    <p>Don't have an account? <a href="/public/register.php">Register here</a>.</p>
</form>