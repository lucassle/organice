@if (session('login_notify'))
    <div class="alert alert-danger">
        <h3>Warning!</h3>
        <ul>
            <li>{{ session('login_notify') }}</li>
        </ul>
    </div>
@endif