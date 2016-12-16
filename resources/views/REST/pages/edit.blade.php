<?php use App\Photo; ?>

@extends('layouts.lte')
@section('title')
    Editing page
@stop

@section('content')
    <!-- Left side column. contains the logo and sidebar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Editing page</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="row">
                                {!! Form::open(['route' => array('page.update', $page['attributes']['id']), 'files' => true, 'method' => 'PUT']) !!}

                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        {{Form::label('name', 'Page description')}}
                                    </div>
                                    <div class="col-md-10">
                                        {{Form::text('name', $page['attributes']["name"], ['class' => "form-control", 'placeholder' => 'Name of your page'])}}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        {{Form::label('description', 'Page description')}}
                                    </div>
                                    <div class="col-md-10">
                                        {{Form::textarea('description', $page['attributes']["description"], ['class' => "form-control", 'placeholder' => 'Brief page description'])}}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        {{Form::label('layout', 'Page layout')}}
                                    </div>
                                    <div class="col-md-10">

                                        <select class="form-control" name="layout">
                                            @foreach($layouts as $key=>$layout)
                                                <option value="{{$key}}">{{$layout}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        {{Form::label('online', 'Make your page online?')}}
                                    </div>
                                    <div class="col-md-10">
                                        {{Form::checkbox('online', $page['attributes']["online"], $page['attributes']["online"])}}
                                    </div>
                                </div>

                                <div class="pull-right">
                                    {{Form::submit('Apply', ['class' => "btn btn-primary btn-sm btn-flat", 'style' => "margin: 15px;"])}}
                                </div>


                                {!! Form::close() !!}
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./box-body -->
                    <div class="box-footer">
                        <div class="row">

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
