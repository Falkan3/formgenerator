<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Survey;
use App\Question;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Survey::Create(['name' => 'default', 'step_titles' => json_encode([
            1 => 'Część 1: Pytania ogólne identyfikujące wydawców:',
            2 => 'Część 2: Pytania identyfikujące ogólne preferencje wydawców:',
            3 => 'Część 3: Pytania dotyczące kampanii pożyczkowych na przykładzie VIVUS:',
            4 => 'Część 4: Dane kontaktowe:'
        ])
        ]);
        Question::create(['survey_id' => 1, 'step' => 1, 'number' => 1, 'name' => 'pyt1', 'type' => 'radio', 'text' =>
            'Jak długo prowadzisz swojego najstarszego bloga/stronę/serwis?',
            'values' => json_encode([
                1 => 'mniej niż rok',
                2 => '1-3 lata',
                3 => 'Powyżej 3 lat'
            ]), 'rule' => 'required']);
        Question::create(['survey_id' => 1, 'step' => 1, 'number' => 2, 'name' => 'pyt2', 'type' => 'radio', 'text' =>
            'Ile blogów/stron/serwisów prowadzisz?',
            'values' => json_encode([
                1 => '1',
                2 => '2-5',
                3 => 'Powyżej 5'
            ]), 'rule' => 'required']);
        Question::create(['survey_id' => 1, 'step' => 1, 'number' => 3, 'name' => 'pyt3', 'type' => 'checkbox', 'text' =>
            'Jakiej kategorii działania w Internecie prowadzisz? (Zaznacz 3 najważniejsze)',
            'values' => json_encode([
                1 => 'blog',
                2 => 'serwis informacyjny',
                3 => 'lead generator',
                4 => 'porównywarka',
                5 => 'baza mailingowa',
                6 => 'dostawca technologii',
                'other' => 'inne'
            ]), 'rule' => 'required|max:3']);
        Question::create(['survey_id' => 1, 'step' => 1, 'number' => 4, 'name' => 'pyt4', 'type' => 'radio', 'text' =>
            'Ile średnio miesięcznie zarabiasz na blogu/stronie/serwisie?', 'values' => json_encode([
            1 => 'mniej niż 1500 zł',
            2 => '1500 - 5000 zł',
            3 => '5000 - 10 000 zł',
            4 => 'powyżej 10 000 zł'
        ]),
            'rule' => 'required']);

        //page 2

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 5, 'name' => 'pyt5', 'type' => 'checkbox', 'text' =>
            'Z jakiej formy generowania przychodu z bloga/strony/serwisu korzystasz regularnie? (Zaznacz 3 najważniejsze)', 'values' => json_encode([
            1 => 'sieci afiliacyjne',
            2 => 'programy partnerskie',
            3 => 'współpraca z agencjami/ sieciami reklamowymi',
            4 => 'reklamy sieci AdSense',
            5 => 'artykuły sponsorowane',
            6 => 'współpraca bezpośrednia z firmami/ markami',
            7 => 'sprzedaż własnych produktów/usług',
            'other' => 'inne'
        ]),
            'rule' => 'required|max:3']);

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 6, 'name' => 'pyt6', 'type' => 'radio', 'text' =>
            'Która z form zarobkowania na blogu/stronie/serwisie generuje najwyższe obroty?', 'values' => json_encode([
            1 => 'sieci afiliacyjne',
            2 => 'programy partnerskie',
            3 => 'współpraca z agencjami/ sieciami reklamowymi',
            4 => 'reklamy sieci AdSense',
            5 => 'artykuły sponsorowane',
            6 => 'współpraca bezpośrednia z firmami/ markami',
            7 => 'sprzedaż własnych produktów/usług',
            'other' => 'inne'
        ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 7, 'name' => 'pyt7', 'type' => 'checkbox', 'text' =>
            'Jakiego rodzaju kampanie wybierasz najczęściej? (Zaznacz 3 najważniejsze)', 'values' => json_encode([
            1 => 'produkty bankowe – kredyty gotówkowe',
            2 => 'produkty bankowe – inne',
            3 => 'produkty pozabankowe - pożyczki',
            4 => 'ubezpieczenia',
            5 => 'telekomunikacja',
            6 => 'energia',
            7 => 'rozrywka',
            8 => 'zdrowie i uroda',
            'other' => 'inne'
        ]),
            'rule' => 'required|max:3']);

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 8, 'name' => 'pyt8', 'type' => 'radio', 'text' =>
            'Jaki model rozliczeń preferujesz?', 'values' => json_encode([
            1 => 'CPS – cost per sale',
            2 => 'CPL – cost per lead - long form',
            3 => 'CPL – cost per lead - short form',
            4 => 'CPL + CPS',
            'other' => 'inny'
        ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 9, 'name' => 'pyt9', 'type' => 'radio', 'text' =>
            'Jaki format reklamowy generuje najwyższe obroty?', 'values' => json_encode([
            1 => 'link tekstowy',
            2 => 'mailing',
            3 => 'display',
            4 => 'video',
            'other' => 'inny'
        ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 10, 'name' => 'pyt10', 'type' => 'radio', 'text' =>
            'Jaki parametr po otrzymaniu walidacji, jest dla Ciebie najważniejszy, decydujący o ewentualnej kontynuacji współpracy?', 'values' => json_encode([
            1 => '% akceptowalności',
            2 => 'wartość faktury/rozliczenia',
            3 => 'eCPL/realna wartość przychodu na leadzie',
            4 => 'eCPC/realna wartość przychodu z kliknięcia',
            5 => 'eCPM/realna wartość przychodu z 1000 wyświetleń'
        ]),
            'rule' => 'required']);

        //page 2

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 11, 'name' => 'pyt11', 'type' => 'radio', 'text' =>
            'Czy  na swoim blogu/stronie/serwisie promujesz kampanie firm pożyczkowych?', 'values' => json_encode([
            1 => 'tak',
            'other' => 'nie (Co skłoniłoby Cię do promowania kampanii VIVUS?)'
        ]),
            'rule' => 'required']);

        //page 3

        Question::create(['survey_id' => 1, 'step' => 3, 'number' => 12, 'name' => 'pyt12', 'type' => 'checkbox', 'max_ticks' => 5, 'text' =>
            'Podaj 5 najchętniej wybieranych przez Ciebie reklamodawców z zakresu pożyczek', 'values' => json_encode([
                1 => 'Ferratum',
                2 => 'Filarum',
                3 => 'Hapi Pożyczki',
                4 => 'Kredito24',
                5 => 'NetCredit',
                6 => 'Provident',
                7 => 'Vivus',
                8 => 'Wonga',
                9 => 'Zaplo',
            ]),
                'rule' => 'required|min:5|max:5']);

        Question::create(['survey_id' => 1, 'step' => 3, 'number' => 13, 'name' => 'pyt13', 'type' => 'multiselect', 'text' =>
            'Co jest najważniejszym argumentem przy wyborze tych kampanii reklamowych, 
            (kryterium, po którym wybierasz kampanię, przy poszczególnych kryteriach wpisz wartości od 1 do 8,
             gdzie 1 –najważniejsze, 8 kryterium najmniej ważne)?',
            'values' => json_encode([
                1 => ['question' => 'terminowe wypłaty rozliczeń', 'answers' => [1, 2, 3, 4, 5, 6, 7, 8]],
                2 => ['question' => 'rozliczenia już po miesiącu od startu kampanii', 'answers' => [1, 2, 3, 4, 5, 6, 7, 8]],
                3 => ['question' => 'różnorodność materiałów reklamowych/graficznych', 'answers' => [1, 2, 3, 4, 5, 6, 7, 8]],
                4 => ['question' => 'model rozliczeń prosty i czytelny', 'answers' => [1, 2, 3, 4, 5, 6, 7, 8]],
                5 => ['question' => 'stawka', 'answers' => [1, 2, 3, 4, 5, 6, 7, 8]],
                6 => ['question' => 'stały model rozliczeń', 'answers' => [1, 2, 3, 4, 5, 6, 7, 8]],
                7 => ['question' => 'poprzednie rozliczenia', 'answers' => [1, 2, 3, 4, 5, 6, 7, 8]],
                8 => ['question' => 'znajomość reklamowanej marki', 'answers' => [1, 2, 3, 4, 5, 6, 7, 8]]
            ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 3, 'number' => 14, 'name' => 'pyt14', 'type' => 'text', 'text' =>
            'Czego Twoim zdaniem brakuje w obecnie funkcjonujących kampaniach firm VIVUS - co byś zmienił/ła?',
            'values' => [], 'rule' => 'required|min:1|max:50']);

        Question::create(['survey_id' => 1, 'step' => 3, 'number' => 15, 'name' => 'pyt15', 'type' => 'radio', 'text' =>
            'Jak postrzegasz obecnie dostępne kampanie VIVUS na tle konkurencyjnych firm pożyczkowych?',
            'values' => json_encode([
                1 => 'bardzo dobrze',
                2 => 'dobrze',
                3 => 'źle',
                4 => 'bardzo źle',
                5 => 'nie mam zdania'
            ]), 'rule' => 'required|min:1|max:50']);

        Question::create(['survey_id' => 1, 'step' => 3, 'number' => 16, 'name' => 'pyt16', 'type' => 'radio', 'text' =>
            'Jak postrzegasz obecna obsługę wydawców afiliacyjnych po stronie VIVUS?', 'values' => json_encode([
            1 => 'bardzo dobrze',
            2 => 'dobrze',
            3 => 'źle',
            4 => 'bardzo źle',
            5 => 'nie mam zdania'
        ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 3, 'number' => 17, 'name' => 'pyt17', 'type' => 'checkbox', 'text' =>
            'Co skłoniłoby Cię do promowania lub zwiększenia działań na rzecz kampanii VIVUS? (Zaznacz 3 najważniejsze)', 'values' => json_encode([
            1 => 'terminowe wypłaty rozliczeń',
            2 => 'rozliczenia już po miesiącu od startu kampanii',
            3 => 'różnorodność materiałów reklamowych/graficznych',
            4 => 'model rozliczeń prosty i czytelny',
            5 => 'stawka',
            6 => 'stały model rozliczeń',
            7 => 'poprzednie rozliczenia',
            8 => 'znajomość reklamowanej marki'
        ]), 'rule' => 'required|max:3']);

        Question::create(['survey_id' => 1, 'step' => 3, 'number' => 18, 'name' => 'pyt18', 'type' => 'radio', 'text' =>
            'Co jest dla Ciebie najważniejsze w  promocjach/ konkursach dedykowanych dla wydawców?', 'values' => json_encode([
            1 => 'nagroda rzeczowa',
            2 => 'nagroda finansowa',
            3 => 'forma konkursu',
            'other' => 'inne'
        ]),
            'rule' => 'required']);

        //page 4

        Question::create(['survey_id' => 1, 'step' => 4, 'number' => 19, 'name' => 'pyt19', 'type' => 'text', 'text' =>
            'Podaj swoje imię', 'values' => [], 'rule' => 'required|min:1|max:50']);

        Question::create(['survey_id' => 1, 'step' => 4, 'number' => 20, 'name' => 'pyt20', 'type' => 'text', 'text' =>
            'Podaj swoje nazwisko', 'values' => [], 'rule' => 'required|min:1|max:50']);

        Question::create(['survey_id' => 1, 'step' => 4, 'custom_id' => 'email', 'number' => 21, 'name' => 'pyt21', 'type' => 'text', 'text' =>
            'Podaj swój adres E-mail', 'values' => [], 'rule' => 'required|email|min:1|max:50']);

        Model::reguard();
    }
}
