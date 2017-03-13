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
                            <h3 class="box-title">All results of survey {{$data['name']}}</h3>

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
                                    <button class="btn btn-block showcsv"
                                            style="width: 200px;">Copy CSV
                                    </button>

                                    <h3>Total questions answered: {{count($data['answers'])}}</h3>

                                    <div id="allresults-csv-container">
                                        @foreach($data['questions'] as $question)
                                            <p>
                                                {!! "[" . $question['question']['number'] . "] " . $question['question']['text'] . " (" . $question['question']['name'] . ")" !!}
                                                {{"*"}}
                                            </p>
                                            @if(!empty($question['question']['values']))
                                                <p>
                                                    @foreach($question['question']['values'] as $av_vals)
                                                        @if(is_array($av_vals))
                                                            {{$av_vals['question'] . ";"}}
                                                        @else
                                                            {{$av_vals . ";"}}
                                                        @endif
                                                    @endforeach
                                                    {{"*"}}
                                                </p>
                                            @endif
                                            <p>
                                                @foreach($question['answers']['vals'] as $answer)
                                                    @if($question['question']['type'] === 'checkbox')
                                                        @foreach($answer as $checkbox_key => $answer_lvl2)
                                                            {{$question['question']['values'][$checkbox_key] . ";"}}
                                                        @endforeach
                                                        {{"*"}}
                                                    @elseif($question['question']['type'] === 'radio')
                                                        {{$question['question']['values'][$answer] . ";"}}
                                                        {{"*"}}
                                                    @elseif($question['question']['type'] === 'multiselect')
                                                        @foreach($answer as $answer_lvl2)
                                                            {{$answer_lvl2 . ";"}}
                                                        @endforeach
                                                        {{"*"}}
                                                    @else
                                                        {{$answer . ";"}}
                                                        {{"*"}}
                                                    @endif
                                                @endforeach
                                            </p>
                                            <p>
                                                @if(isset($question['answers']['other']))
                                                    @foreach($question['answers']['other'] as $other)
                                                        {{$other.";"}}
                                                    @endforeach
                                                @endif
                                                {{"*"}}
                                            </p>
                                        @endforeach
                                    </div>

                                    <h3>All data</h3>
                                    <?php print_r($data['questions']) ?>


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
            var data = $('#allresults-csv-container');//.text().replace(/ /g,'');
            //data.toggle();

            var $temp = $("<textarea></textarea>");
            $temp.wrap("<span style='background: Highlight;'>");
            $("body").append($temp);
            var text = "";
            var paragraphs = data.find('p');
            paragraphs.each(function () {
                text += $.trim($(this).text().replace(/;\s{1,}/g, ';').replace(/\s{2,}/g, ' '));
            });
            text = text.replace(/\*/g, '\n');
            $temp.val(text).select();
            document.execCommand("copy");
            $temp.remove();
        });
    </script>
@stop
