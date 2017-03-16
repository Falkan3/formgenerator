@extends('layouts.lte')
@section('title')
    Dashboard | Survey results
@stop

@section('content')
    <!-- Left side column. contains the logo and sidebar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('lte.includes.navpanel')

    <!-- Main content -->
        <section class="content">

            @if($errors->any())
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert</h4>
                    {{$errors->first()}}
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Survey {{$data['name']}} pages</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-box-tool dropdown-toggle"
                                            data-toggle="dropdown">
                                        <i class="fa fa-wrench"></i></button>
                                    <ul class="dropdown-menu" role="menu">
                                    </ul>
                                </div>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @foreach($data['step_titles'] as $key => $step)
                                        <p><a href="{{url('survey/show/'.$data['id'].'/'.$key)}}">{{$step}}</a></p>
                                    @endforeach
                                    <p><a href="{{url('survey/allresults/'.$data['id'])}}">Show all results of this survey</a></p>

                                    <h3>Users that took the survey</h3>
                                    <p>All: {{count($data['users'])}}, completed: {{$data['users_completed_survey']}}</p>
                                    <table class="table table-responsive table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Imię</th>
                                            <th>E-mail</th>
                                            <th>Krok</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['users'] as $user)
                                            <tr>
                                                <td>{{$user['imie']}}</td>
                                                <td>{{$user['email']}}</td>
                                                <td>{{$user['max_step']}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./box-body -->
                        <div class="box-footer">
                            <div class="row text-center">
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->

    <!-- Control Sidebar -->
@stop
