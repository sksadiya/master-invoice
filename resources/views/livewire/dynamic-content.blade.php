<div>
    @if ($page === '/')
        <h1>Home Page</h1>
        <!-- Add home page content here -->
    @elseif ($page === 'settings')
        <h1>Settings Page</h1>
        <!-- Add settings page content here -->
    @else
        <h1>Page Not Found</h1>
    @endif
</div>
