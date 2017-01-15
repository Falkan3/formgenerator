@extends($layout)
@section('title')
    Ankieta | ProperAd
@stop

@section('content')
    <?php /*
    @foreach($survey['questions'] as $item)
        {{print_r($item['attributes'])}}
    @endforeach
 */ ?>
    <?php $labelNumeration = 0; ?>
    @if ($errors->any())
        <div class="container">
            <div class="alert alert-danger">
                <strong>Błąd!</strong> {{ rtrim(implode('', $errors->all(':message, ')), ', ').'.' }}
            </div>
        </div>
    @endif
    <div class="content">
        <div class="container narrow backgrounded">
            <div class="row text-center">
                @if(isset($survey['step']) && $survey['step']==1)
                    <h3 class="no-margin">Ankieta <span class="highlight">dla wydawców</span></h3>
                    <h3 class="no-margin margin-bottom-medium"><span class="highlight big colored">organizowana we współpracy z</span>
                    </h3>
                @endif
                <img src="{{asset('images/pa/vivus.png')}}" class="center-block vivus-logo" alt="logo_vivus"/>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <section>
                        <h1><span class="text-bold text-center">Wypełnij formularz</span></h1>
                        @if(isset($survey['survey_step_title']))
                            <h2><span class="text-center">{{$survey['survey_step_title']}}</span></h2>
                        @endif
                        <h3>
                            <span class="highlight big colored">Strona {{$survey['step'] . '/' . $survey['last_step']}}</span>
                        </h3>

                        <div class="contact-form padding-medium">
                            {!! Form::open(['url' => ['survey/'.$survey['id'].'/step/'.$survey['step']], 'method' => 'post', 'id' => 'contact-form']) !!}

                            @foreach($survey['questions'] as $item)
                                <div class="container field-group">
                                    <div class="col-xs-10 col-sm-10 header-ext"><p>{{$item->text}}</p></div>

                                    @if($item->type == 'text')
                                        @if(isset($answers) && isset($answers[$item->name]))
                                            <?php $answer = $answers[$item->name]; ?>
                                        @else
                                            <?php $answer = ''; ?>
                                        @endif
                                        @if(isset($item['custom_id']))
                                            <?php $id = $item['custom_id']; ?>
                                        @else
                                            <?php $id = ''; ?>
                                        @endif
                                        <div class="col-xs-12">
                                            <div class="col-xs-2 col-sm-1 input-header"><p>{{$item->number}}</p></div>
                                            <a href="#" data-toggle="tooltip" data-placement="bottom"
                                               title="{{$item->text}}">{{Form::text($item->name, $answer, ['class' => "contact-form-field", 'placeholder' => 'Odpowiedź', 'required', 'id' => $id])}}</a>
                                        </div>
                                    @elseif($item->type == 'radio')
                                        <div class="col-xs-12 input-body">
                                            <div class="col-xs-2 col-sm-1 input-header"><p>{{$item->number}}</p></div>
                                            @foreach(json_decode($item->values) as $key=>$val)
                                                @if(isset($answers) && isset($answers[$item->name]) && $answers[$item->name] == $key)
                                                    <?php $answer = $answers[$item->name]; ?>
                                                @else
                                                    <?php $answer = 0; ?>
                                                @endif
                                                <div class="col-xs-12">
                                                    {{Form::radio($item->name, $key, $answer, ['id' => $labelNumeration, 'class' => "contact-form-field"])}}
                                                    {{Form::label($labelNumeration++, $val)}}
                                                    @if($key=="other")
                                                        @if(isset($answers[$item->name]) && $answers[$item->name] == 'other' && isset($answers['other_'.$item->name]))
                                                            <?php $answer = $answers['other_' . $item->name]; ?>
                                                        @else
                                                            <?php $answer = ''; ?>
                                                        @endif
                                                        {{Form::text($key . '_' . $item->name, $answer, ['class' => "contact-form-field", 'placeholder' => 'Odpowiedź'])}}
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($item->type == 'checkbox')
                                        <div class="col-xs-12 input-body">
                                            <div class="col-xs-2 col-sm-1 input-header"><p>{{$item->number}}</p></div>
                                            @foreach(json_decode($item->values, 1) as $key=>$val)
                                                @if(isset($answers) && isset($answers[$item->name][$key]))
                                                    <?php $answer = $answers[$item->name][$key]; ?>
                                                @else
                                                    <?php $answer = 0; ?>
                                                @endif
                                                <div class="col-xs-12">
                                                    {{Form::checkbox($item->name.'['.$key.']', 1, $answer, ['id' => $item->name.'['.$key.']', 'class' => "contact-form-field", 'min_ticks' => $item->min_ticks, 'max_ticks' => $item->max_ticks])}}
                                                    {{Form::label($item->name.'['.$key.']', $val)}}
                                                    @if($key=="other")
                                                        @if(isset($answers[$item->name]['other']) && $answers[$item->name]['other'] == '1' && isset($answers['other_'.$item->name]))
                                                            <?php $answer = $answers['other_' . $item->name]; ?>
                                                        @else
                                                            <?php $answer = ''; ?>
                                                        @endif
                                                        {{Form::text($key . '_' . $item->name, $answer, ['class' => "contact-form-field", 'placeholder' => 'Odpowiedź'])}}
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($item->type == 'select')
                                        <div class="col-xs-12 input-body">
                                            <div class="col-xs-2 col-sm-1 input-header"><p>{{$item->number}}</p></div>
                                            {{Form::select($item->name, [null=>'-']+json_decode($item->values, 1), null, ['class' => "contact-form-field", 'required'])}}
                                        </div>
                                    @elseif($item->type == 'multiselect')
                                        <div class="col-xs-12 input-body">
                                            <div class="col-xs-2 col-sm-1 input-header"><p>{{$item->number}}</p></div>
                                            @foreach(json_decode($item->values) as $key=>$val)
                                                @if(isset($answers) && isset($answers[$item->name][$key]))
                                                    <?php $answer = $answers[$item->name][$key]; ?>
                                                @else
                                                    <?php $answer = null; ?>
                                                @endif
                                                <div class="col-xs-12 input-body padding-small">
                                                    {{Form::select($item->name.'['.$key.']', [null=>'-']+$val->answers, $answer, ['class' => "contact-form-field", 'required'])}}
                                                    {{Form::label($item->name.'['.$key.']', $val->question)}}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            @if($survey['step']>1 && $survey['step']!=$survey['last_step'])
                                {{Form::submit('Dalej', ['class' => "btn btn-default shrinked-next"])}}
                                <a class="btn shrinked-back"
                                   href="{{url('survey/gen' . '/' . $survey['id'] . '/' . ($survey['step']-1))}}">Powrót</a>
                            @else
                                {{Form::submit('Dalej', ['class' => "btn btn-default"])}}
                            @endif
                            {!! Form::close() !!}
                        </div>
                    </section>
                </div>
            </div>


            <div class="row">
                <div class="col-xs-12">


                </div>
            </div>

        </div>
    </div>
@stop

<?php /*
    <?php echo app()->getLocale(); ?>
    <a href="{{url('test')}}">AAA</a>

 <div class="col-sm-4 col-xs-12">
                        <div id="tile10" class="tile">

                            <div class="carousel slide" data-ride="carousel">
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <h3 class="tilecaption"><i class="fa fa-child fa-4x"></i></h3>
                                    </div>
                                    <div class="item">
                                        <h3 class="tilecaption">Customize your tiles</h3>
                                    </div>
                                    <div class="item">
                                        <h3 class="tilecaption">Text, Icons, Images</h3>
                                    </div>
                                    <div class="item">
                                        <h3 class="tilecaption">Combine them and create your metro style</h3>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

    <div class="col-sm-2 col-xs-4">
                <div id="tile8" class="tile">

                    <div class="carousel slide" data-ride="carousel">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="http://handsontek.net/demoimages/tiles/music.png" class="img-responsive"/>
                            </div>
                            <div class="item">
                                <img src="http://handsontek.net/demoimages/tiles/music2.png" class="img-responsive"/>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-2 col-xs-4">
                <div id="tile9" class="tile">

                    <div class="carousel slide" data-ride="carousel">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="http://handsontek.net/demoimages/tiles/calendar.png" class="img-responsive"/>
                            </div>
                            <div class="item">
                                <img src="http://handsontek.net/demoimages/tiles/calendar2.png" class="img-responsive"/>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
 */
?>

<?php /*
                <div class="col-xs-12 col-sm-12 col-md-4 contact-form">
                    <div>
                        <h1><span class="text-bold">Wypełnij formularz</span></h1>

                        <div class="padding-medium">
                            {!! Form::open(['url' => '#', 'method' => 'post', 'id' => 'contact-form']) !!}
                            <div class="col-sm-10 center-block">
                                <a href="#" data-toggle="tooltip" data-placement="left"
                                   title="Wpisz poprawne imię">{{Form::text('imie', '', ['class' => "contact-form-field", 'placeholder' => 'Imię'])}}</a>
                            </div>

                            <div class="col-sm-10 center-block">
                                <a href="#" data-toggle="tooltip" data-placement="left"
                                   title="Wpisz poprawny numer telefonu">{{Form::text('telefon', '', ['class' => "contact-form-field", 'placeholder' => 'Numer telefonu'])}}</a>
                            </div>

                            <div class="col-sm-10 center-block">
                                {{Form::submit('CHCĘ SKORZYSTAĆ', ['class' => "btn"])}}
                            </div>

                            <div class="text-left padding-small">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-10 col-md-12 center-block">
                                        <div class="col-xs-1">{{Form::checkbox('agree1', 'agree1')}}</div>
                                        <div class="col-xs-10">{{Form::label('agree1', 'Zgoda na gromadzenie i przetwarzanie danych osobowych', ['class' => 'control-label small'])}}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-10 col-md-12 center-block">
                                        <div class="col-xs-1">{{Form::checkbox('agree2', 'agree1')}}</div>
                                        <div class="col-xs-10">{{Form::label('agree2', 'Zgoda na otrzymywanie informacji handlowych', ['class' => 'control-label small'])}}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-10 col-md-12 center-block">
                                        <div class="col-xs-1">{{Form::checkbox('agree3', 'agree1')}}</div>
                                        <div class="col-xs-10">{{Form::label('agree3', 'Zgoda na używanie telekomunikacyjnych urządzeń końcowych', ['class' => 'control-label small'])}}</div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}

                            <div class="row">
                                <div class="col-xs-12 col-sm-6 text-center">
                                    <a href="https://rachunkowosc.negocjujemypromocje.pl/polityka-prywatnosci"
                                       class="link left" target="_blank">Polityka prywatności</a>
                                </div>
                                <div class="col-xs-12 col-sm-6 text-center">
                                    <a href="https://rachunkowosc.negocjujemypromocje.pl/polityka-prywatnosci"
                                       class="link right" target="_blank">Polityka cookies</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
 */ ?>
<?php /*
 <div class="container field-group">
                                <div class="col-xs-2 col-sm-1 input-header"><p>1</p></div>
                                <div class="col-xs-10 col-sm-11 header-ext"><p>Jak długo prowadzisz swojego najstarszego
                                        bloga/stronę/serwis?</p></div>
                                <div class="col-xs-12">
                                    <a href="#" data-toggle="tooltip" data-placement="bottom"
                                       title="Jak długo prowadzisz swojego najstarszego bloga/stronę/serwis?">{{Form::text('pyt1', '', ['class' => "contact-form-field", 'placeholder' => 'Odpowiedź'])}}</a>
                                </div>
                            </div>

                            <div class="container field-group">
                                <div class="col-xs-2 col-sm-1 input-header"><p>2</p></div>
                                <div class="col-xs-10 col-sm-11 header-ext"><p>Ile blogów/stron/serwisów prowadzisz?</p>
                                </div>
                                <div class="col-xs-12">
                                    <a href="#" data-toggle="tooltip" data-placement="bottom"
                                       title="Ile blogów/stron/serwisów prowadzisz?">{{Form::text('pyt2', '', ['class' => "contact-form-field", 'placeholder' => 'Odpowiedź'])}}</a>
                                </div>
                            </div>

                            <div class="container field-group">
                                <div class="col-xs-2 col-sm-1 input-header"><p>3</p></div>
                                <div class="col-xs-10 col-sm-11 header-ext"><p>Jakiej kategorii blogi/strony/serwisy
                                        prowadzisz?</p></div>
                                <div class="col-xs-12">
                                    <a href="#" data-toggle="tooltip" data-placement="bottom"
                                       title="Jakiej kategorii  blogi/strony/serwisy prowadzisz?">{{Form::text('pyt3', '', ['class' => "contact-form-field", 'placeholder' => 'Odpowiedź'])}}</a>
                                </div>
                            </div>

                            <div class="container field-group">
                                <div class="col-xs-2 col-sm-1 input-header"><p>4</p></div>
                                <div class="col-xs-10 col-sm-11 header-ext"><p>Po jakim czasie od założenia
                                        bloga/strony/serwisu, zacząłeś/aś zarabiać?</p></div>
                                <div class="col-xs-12 input-body">
                                    <div class="col-xs-12">
                                        {{Form::radio('pyt4', 'jeden', 0, ['class' => "contact-form-field"])}}
                                        {{Form::label('pyt4', 'Jeden')}}
                                    </div>
                                    <div class="col-xs-12">
                                        {{Form::radio('pyt4', 'dwa', 0, ['class' => "contact-form-field"])}}
                                        {{Form::label('pyt4', 'Dwa')}}
                                    </div>
                                </div>
                            </div>

                            <div class="container field-group">
                                <div class="col-xs-2 col-sm-1 input-header"><p>5</p></div>
                                <div class="col-xs-10 col-sm-11 header-ext"><p>Co według Ciebie ma decydujący wpływ na
                                        to, że zarabiasz na blogu/stronie/serwisie?</p></div>
                                <div class="col-xs-12 input-body">
                                    <div class="col-xs-12">
                                        {{Form::radio('pyt5', 'jeden', 0, ['class' => "contact-form-field"])}}
                                        {{Form::label('pyt5', 'Jeden')}}
                                    </div>
                                    <div class="col-xs-12">
                                        {{Form::radio('pyt5', 'dwa', 0, ['class' => "contact-form-field"])}}
                                        {{Form::label('pyt5', 'Dwa')}}
                                    </div>
                                </div>
                            </div>

                            <div class="container field-group">
                                <div class="col-xs-2 col-sm-1 input-header"><p>6</p></div>
                                <div class="col-xs-10 col-sm-11 header-ext"><p>Ile średnio miesięcznie zarabiasz na
                                        blogu/stronie/serwisie?</p></div>
                                <div class="col-xs-12 input-body">
                                    <div class="col-xs-12">
                                        {{Form::radio('pyt6', 'jeden', 0, ['class' => "contact-form-field"])}}
                                        {{Form::label('pyt6', 'Jeden')}}
                                    </div>
                                    <div class="col-xs-12">
                                        {{Form::radio('pyt6', 'dwa', 0, ['class' => "contact-form-field"])}}
                                        {{Form::label('pyt6', 'Dwa')}}
                                    </div>
                                </div>
                            </div>
                */
?>