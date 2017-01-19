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
                            <h3 class="box-title">{{$data['step_title']}}</h3>

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
                                    <h3>Answer count for this step: {{count($data['answers'])}}</h3>
                                    @foreach($data['questions'] as $question)
                                        @if(!empty($question['values']))
                                            <?php $values = json_decode($question['values'], 1) ?>
                                        @endif
                                        <?php /*print_r($values)*/ ?>
                                        <h3>[{{$question['number']}}] {!! $question['text'] !!} ({{$question['name']}}
                                            )</h3>
                                        @foreach($data['answers'] as $key_a => $answer)
                                            @if($question['type'] === 'text')
                                                @if($question['type']==='text')
                                                    {{$answer[$question['name']].', '}}
                                                @endif
                                            @else
                                                @if(is_array($answer[$question['name']]))
                                                    {{'['}}
                                                    @foreach($answer[$question['name']] as $t_key => $tick)
                                                        @if($question['type']!='multiselect')
                                                            {{$values[$t_key].', '}}
                                                        @elseif($question['type']==='multiselect')
                                                            {{$values[$t_key]['question']}}
                                                            {{($tick+1).', '}}
                                                        @else
                                                            <?php print_r($values[$t_key]) ?>{{', '}}
                                                        @endif
                                                    @endforeach
                                                    {{']'}}
                                                @else
                                                    {{$values[$answer[$question['name']]].', '}}
                                                @endif
                                            @endif
                                        @endforeach
                                    @endforeach

                                    <h3>All answers</h3>
                                    <?php print_r($data['answers']) ?>
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
