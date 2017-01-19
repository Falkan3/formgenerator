<?php use App\Photo; ?>

@extends('layouts.lte')
@section('title')
    Dashboard | index
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
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3> {{count(Photo::where('user_id', Auth::user()->id)->withTrashed()->get())}}</h3>

                            <p>Photos uploaded by you</p>
                        </div>
                        <div class="icon">
                            <i class="ion"></i>
                        </div>
                        <a href="#" class="small-box-footer">View recent <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{$lastweek}}</h3>

                            <p>Photos uploaded this week</p>
                        </div>
                        <div class="icon">
                            <i class="ion"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>xx</h3>

                            <p>Results this week</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{url('survey/index')}}" class="small-box-footer">Survey results <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

            </div>
            <!-- /.row -->


            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Gallery</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-box-tool dropdown-toggle"
                                            data-toggle="dropdown">
                                        <i class="fa fa-wrench"></i></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{route('photo.create')}}">Upload a photo</a></li>
                                    </ul>
                                </div>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 images">
                                    @if(count($photos)==0)
                                        <p>No photos in your gallery.</p>
                                    @else
                                        @foreach($photos as $photo)
                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <a href="{{url('photo') . "/" . $photo['id']}}"><img
                                                            src="{{URL::asset($photo['attributes']['location'])}}"
                                                            alt="{{$photo['title']}}"/></a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./box-body -->
                        <div class="box-footer">
                            <div class="row text-center">
                                <ul class="pagination pagination-sm">
                                    @if(app('request')->input('offset')>=6)
                                        <li>
                                            <a href="{{url('home/previous')."?offset=".(app('request')->input('offset')-6)}}">&laquo;</a>
                                        </li>
                                    @endif
                                    @for($i=1;$i<=ceil($photocount/6);$i++)
                                        <li><a href="{{url('home/next')."?offset=".(($i-1)*6)}}">{{$i}}</a></li>
                                    @endfor
                                    @if($photocount>6 && app('request')->input('offset')<ceil($photocount/6))
                                        <li>
                                            <a href="{{url('home/next')."?offset=".(app('request')->input('offset')+6)}}">&raquo;</a>
                                        </li>
                                    @endif
                                </ul>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Pages</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-box-tool dropdown-toggle"
                                            data-toggle="dropdown">
                                        <i class="fa fa-wrench"></i></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{route('page.create')}}">New page</a></li>
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
                                    @if(count($pages)==0)
                                        <p>No pages created.</p>
                                    @else
                                        @foreach($pages as $page)
                                            <p>{{$page['id']}}. <a href="{{route('page.show', $page->id)}}">{{$page->name}}</a></p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./box-body -->
                        <div class="box-footer">
                            <div class="row text-center">
                                <ul class="pagination pagination-sm">
                                    @if(app('request')->input('offset')>=6)
                                        <li>
                                            <a href="{{url('home/previous')."?offset=".(app('request')->input('offset')-6)}}">&laquo;</a>
                                        </li>
                                    @endif
                                    @for($i=1;$i<=ceil(count($pages)/6);$i++)
                                        <li><a href="{{url('home/next')."?offset=".(($i-1)*6)}}">{{$i}}</a></li>
                                    @endfor
                                    @if(count($pages)>6 && app('request')->input('offset')<ceil(count($pages)/6))
                                        <li>
                                            <a href="{{url('home/next')."?offset=".(app('request')->input('offset')+6)}}">&raquo;</a>
                                        </li>
                                    @endif
                                </ul>
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