<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{URL::asset('images/dist/user.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                @if (Auth::guest())
                    <p>Guest</p>
                @else
                    <p>{{Auth::user()->name}}</p>
                @endif
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <?php /*<li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>*/ ?>
                    <li><a href="{{url('home')}}"><i class="fa fa-circle-o"></i> Home</a></li>
                    <li><a href="{{url('photo/create')}}"><i class="fa fa-circle-o"></i> New Photo</a></li>
                    <li><a href="{{url('page/create')}}"><i class="fa fa-circle-o"></i> New Page</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Surveys</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('survey/index')}}"><i class="fa fa-circle-o"></i> Results</a></li>
                </ul>
            </li>
        </ul>

    </section>
    <!-- /.sidebar -->
</aside>