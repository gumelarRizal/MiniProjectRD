<!DOCTYPE html>
<html lang="en">
<head>
    @include('Layouts.Partials.Head')
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
        <div class="navbar-bg"></div>
        @include('Layouts.Partials.Nav')
        @include('Layouts.Partials.Sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
            <div class="section-header">
                @yield('title')
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Form Validation</div>
                </div>
            </div>

            <div class="section-body">
                @yield('content')
            </div>
            </section>
        </div>
        @include('Layouts.Partials.Footer')
        </div>
    </div>
    @yield('modal')
    @include('Layouts.Partials.Scripts')
    </body>
</html>
