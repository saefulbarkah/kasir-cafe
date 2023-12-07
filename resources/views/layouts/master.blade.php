<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.components.head')
</head>

<body>
    <div id="app" class="toggled">
        <div class="main-wrapper">
            @include('layouts.components.navbar')
            @hasrole('admin')
                @include('layouts.components.sidebar-admin')
            @endhasrole
            @hasrole('manager')
                @include('layouts.components.sidebar-manager')
            @endhasrole
            @hasrole('kasir')
                @include('layouts.components.sidebar-kasir')
            @endhasrole

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>@yield('title-page')</h1>
                    </div>

                    <div class="section-body">
                        @yield('content')
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Page Specific JS File -->
    @include('layouts.components.js')
</body>

</html>
