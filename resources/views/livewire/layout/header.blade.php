 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
         <li class="nav-item d-none d-sm-inline-block">
             <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-home"></i></a>
         </li>
         <li class="nav-item d-none d-sm-inline-block">

             <form method="POST" action="{{ route('logout') }}">
                 @csrf

                 <a href="{{ route('logout') }}" class="nav-link"
                     onclick="event.preventDefault(); this.closest('form').submit();">
                     <i class="fas fa-sign-out-alt"></i>
                 </a>
             </form>

         </li>
     </ul>


 </nav>
 <!-- /.navbar -->
