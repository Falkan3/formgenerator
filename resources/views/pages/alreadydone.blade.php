@extends($layout)
@section('title')
    Ankieta - zrobione! | ProperAd
@stop
@section('custom_meta')
    <meta http-equiv=REFRESH CONTENT=5;url=http://www.properad.pl>
@stop

@section('content')
    <div class="content">
        <div class="container backgrounded">
            <div class="row text-center">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <section>
                        <h1><span class="text-bold text-center highlight big colored">Dziękujemy za wypełnienie ankiety.</span></h1>
                        <h2><span class="text-center">Niebawem na podany adres mailowy wyślemy do Ciebie raport.</span></h2>
                        <?php /*<img src="{{asset('images/pa/vivus.png')}}" class="center-block vivus-logo" alt="logo_vivus"/> */ ?>
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