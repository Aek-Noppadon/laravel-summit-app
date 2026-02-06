@php
    $databaseName = env('DB_DATABASE');
@endphp

<footer class="main-footer">
    <strong>Copyright &copy; 2026 Summit Web Applications</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Connection to</b> {{ $databaseName }}
    </div>
</footer>
