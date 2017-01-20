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
                                    <?php $csv_index = 0; ?>
                                    @foreach($data['questions'] as $question)
                                        <?php $chartDataRaw = [] ?>
                                        @if(!empty($question['values']))
                                            <?php $values = json_decode($question['values'], 1) ?>
                                        @endif
                                        <?php /*print_r($values)*/ ?>
                                        <h3>[{{$question['number']}}] {!! $question['text'] !!} ({{$question['name']}}
                                            )</h3>

                                        <button class="btn btn-block showcsv" data-index="{{$csv_index}}"
                                                style="width: 200px;">Generate CSV
                                        </button>
                                        <div class="csv-container" data-index="{{$csv_index++}}" style="display: none;">
                                            @if($question['type']!='text')
                                                <p>
                                                    @if($question['type']==='multiselect')
                                                        <?php
                                                        //$multi_questions = [];
                                                        foreach($values as $item) {
                                                        //$multi_questions[] = $item['question'];
                                                        echo $item['question'].';';
                                                        }
                                                        ?>
                                                        {{'|'}}
                                                    @else
                                                        @foreach($values as $value)
                                                            {{$value.';'}}
                                                        @endforeach
                                                    @endif
                                                </p>
                                            @endif
                                            @foreach($data['answers'] as $key_a => $answer)
                                                @if($question['type'] === 'text')
                                                    {{$answer[$question['name']].';'}}
                                                    <?php $chartDataRaw[] = $answer[$question['name']] ?>
                                                @else
                                                    @if(isset($answer[$question['name']]))
                                                        <p>
                                                            @if(is_array($answer[$question['name']]))
                                                                @foreach($answer[$question['name']] as $t_key => $tick)
                                                                    @if($question['type']!='multiselect')
                                                                        {{$values[$t_key].';'}}
                                                                        <?php $chartDataRaw[] = $values[$t_key] ?>
                                                                    @elseif($question['type']==='multiselect')
                                                                        <?php /*
                                                                    {{$values[$t_key]['question']}}
                                                                    */ ?>
                                                                        {{($tick+1).';'}}
                                                                        <?php /*$chartDataRaw[($tick+1)] = $values[$t_key]['question']*/ ?>
                                                                    @else
                                                                        <?php print_r($values[$t_key]) ?>{{';'}}
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                {{$values[$answer[$question['name']]].';'}}
                                                                <?php $chartDataRaw[] = $values[$answer[$question['name']]] ?>
                                                            @endif
                                                        </p>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <?php
                                        $chartData = [];
                                        foreach($chartDataRaw as $key => $item) {
                                        if(isset($chartData[$item])) {
                                        $chartData[$item]++;
                                        }
                                        else {
                                        $chartData[$item] = 1;
                                        }

                                        }
                                        ?>
                                        @if(isset($chartData))
                                            <table class="table table-responsive table-striped">
                                                <thead>
                                                <tr>
                                                    @foreach($chartData as $key => $header)
                                                        <th>{{$key}}</th>
                                                    @endforeach
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    @foreach($chartData as $header)
                                                        <td>{{$header}}</td>
                                                    @endforeach
                                                </tr>
                                                </tbody>
                                            </table>
                                        @endif

                                    <!-- DONUT CHART -->
                                        <div class="box box-danger">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Donut Chart</h3>

                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool"
                                                            data-widget="collapse"><i
                                                                class="fa fa-minus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                                                        <i
                                                                class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                <div class="chartContainer">
                                                    <canvas class="piechart unused" style="height:150px"></canvas>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                        <script>
                                            //-------------
                                            //- PIE CHART -
                                            //-------------
                                            // Get context with jQuery - using jQuery's .get() method.
                                            var pieChartCanvasRaw = $('.piechart.unused:first');
                                            var pieChartCanvas = pieChartCanvasRaw.get(0).getContext("2d");
                                            var pieChart = new Chart(pieChartCanvas);
                                            var PieData = [
                                                    @foreach($chartData as $key => $item)
                                                    @if(is_numeric($item))
                                                    <?php $rand = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT) ?>
                                                {
                                                    value: {{$item}},
                                                    color: "{{$rand}}",
                                                    highlight: "#f56954",
                                                    label: "{{$key}}"
                                                },
                                                @endif
                                                @endforeach
                                            ];
                                            var pieOptions = {
                                                //Boolean - Whether we should show a stroke on each segment
                                                segmentShowStroke: true,
                                                //String - The colour of each segment stroke
                                                segmentStrokeColor: "#fff",
                                                //Number - The width of each segment stroke
                                                segmentStrokeWidth: 2,
                                                //Number - The percentage of the chart that we cut out of the middle
                                                percentageInnerCutout: 50, // This is 0 for Pie charts
                                                //Number - Amount of animation steps
                                                animationSteps: 100,
                                                //String - Animation easing effect
                                                animationEasing: "easeOutBounce",
                                                //Boolean - Whether we animate the rotation of the Doughnut
                                                animateRotate: true,
                                                //Boolean - Whether we animate scaling the Doughnut from the centre
                                                animateScale: false,
                                                //Boolean - whether to make the chart responsive to window resizing
                                                responsive: true,
                                                // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                                maintainAspectRatio: true,
                                                //String - A legend template
                                                legendTemplate: "&lt;ul class=&lt;%=name.toLowerCase()%&gt;-legend\&quot;&gt;&lt;% for (var i=0; i&lt;segments.length; i++){%&gt;&lt;li&gt;&lt;span style=\&quot;background-color:&lt;%=segments[i].fillColor%&gt;\&quot;&gt;&lt;/span&gt;&lt;%if(segments[i].label){%&gt;&lt;%=segments[i].label%&gt;&lt;%}%&gt;&lt;/li&gt;&lt;%}%&gt;&lt;/ul&gt;"
                                            };
                                            pieChart.Doughnut(PieData, pieOptions);
                                            pieChartCanvasRaw.removeClass('unused');
                                        </script>
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
    <script>
        $('button.showcsv').click(function (e) {
            var data = $('.csv-container[data-index="' + $(this).attr('data-index') + '"]');//.text().replace(/ /g,'');
            data.toggle();

            var $temp = $("<input>");
            $("body").append($temp);
            var text = "";
            var paragraphs = data.find('p');
            paragraphs.each(function () {
                text += $.trim($(this).text().replace(/\s{2,}/g, ' '));
            });
            $temp.val(text).select();
            document.execCommand("copy");
            $temp.remove();
        });
    </script>
@stop
