<?php use App\Photo; ?>

@extends('layouts.lte')
@section('title')
    Viewing page
@stop

@section('content')
    <!-- Left side column. contains the logo and sidebar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('lte.includes.navpanel')

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$page['name']}}</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-box-tool dropdown-toggle"
                                            data-toggle="dropdown">
                                        <i class="fa fa-wrench"></i></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ route('page.edit', $page['id'])}}">Edit page</a></li>
                                        <li><a href="{{ route('page.show', $page['id']) }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('destroy-form').submit();">
                                            Remove page
                                        </a></li>

                                        {{ Form::open(array('id' => 'destroy-form', 'route' => array('page.destroy', $page['id']), 'method' => 'delete')) }}
                                        {{ Form::close() }}
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
                                    <p>Elements on page: 0</p>
                                    <p>Page layout: {{$page['layout']}}. {{$page->getLayout['attributes']['name']}}</p>
                                    <p>Created at: {{$page['created_at']}}</p>
                                    <p>Last updated at: {{$page['updated_at']}}</p>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./box-body -->
                    <div class="box-footer">

                        <div class="box-header">
                            <i class="fa fa-comments-o"></i>

                            <h3 class="box-title">Description</h3>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <p>{{$page['description']}}</p>
                            </div>
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
    <!-- /.content-wrapper -->

    <!-- Footer -->

    <!-- Control Sidebar -->
@stop
