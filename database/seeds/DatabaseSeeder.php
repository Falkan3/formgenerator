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
            4 => 'Część 3: Pytania dotyczące kampanii pożyczkowych na przykładzie VIVUS:'
        ])
        ]);
        Question::create(['survey_id' => 1, 'step' => 1, 'number' => 1, 'name' => 'pyt1', 'type' => 'text', 'text' =>
            'Jak długo prowadzisz swojego najstarszego bloga/stronę/serwis?',
            'values' => [], 'rule' => 'required|min:1|max:50']);
        Question::create(['survey_id' => 1, 'step' => 1, 'number' => 2, 'name' => 'pyt2', 'type' => 'text', 'text' =>
            'Ile blogów/stron/serwisów prowadzisz?',
            'values' => [], 'rule' => 'required|min:1|max:50']);
        Question::create(['survey_id' => 1, 'step' => 1, 'number' => 3, 'name' => 'pyt3', 'type' => 'checkbox', 'text' =>
            'Jakiej kategorii  blogi/strony/serwisy prowadzisz?',
            'values' => json_encode(['test1' => 1, 'test2' => 2]), 'rule' => 'required']);
        Question::create(['survey_id' => 1, 'step' => 1, 'number' => 4, 'name' => 'pyt4', 'type' => 'radio', 'text' =>
            'Po jakim czasie od założenia bloga/strony/serwisu, zacząłeś/aś zarabiać?', 'values' => json_encode([
            1 => 'eden',
            2 => 'dwa',
            3 => 'tri'
        ]),
            'rule' => 'required']);
        Question::create(['survey_id' => 1, 'step' => 1, 'number' => 5, 'name' => 'pyt5', 'type' => 'radio', 'text' =>
            'Co według Ciebie ma decydujący wpływ na to, że zarabiasz na blogu/stronie/serwisie?', 'values' => json_encode([
            1 => 'systematyczność w tworzeniu treści',
            2 => 'moje zaangażowanie w tworzeniu jakościowych treści',
            3 => 'cierpliwość',
            4 => 'wyróżnienie się na tle konkurencji',
            5 => 'wdrożenie nowych form zarabiania',
            'other' => 'inne'
        ]),
            'rule' => 'required']);
        Question::create(['survey_id' => 1, 'step' => 1, 'number' => 6, 'name' => 'pyt6', 'type' => 'radio', 'text' =>
            'Ile średnio miesięcznie zarabiasz na bloga/stronie/serwisie?', 'values' => json_encode([
            1 => 'mniej niż 50zł',
            2 => '1000 - 1500zł',
            3 => '1500 - 3000zł',
            4 => '3000 - 5000zł',
            5 => '5000 - 10 000zł',
            6 => '10 000 - 15 000zł',
            7 => 'powyżej 15 000zł'
        ]),
            'rule' => 'required']);

        //page 2

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 7, 'name' => 'pyt7', 'type' => 'checkbox', 'text' =>
            'Z jakiej formy generowania przychodu z bloga/strony/serwisu korzystasz regularnie?', 'values' => json_encode([
            1 => 'sieci afiliacyjne',
            2 => 'programy partnerskie',
            3 => 'współpraca z agencjami/markami',
            4 => 'artykuły sponsorowane',
            5 => 'reklamy',
            6 => 'sprzedaż własnych produktów/usług',
            'other' => 'inne'
        ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 8, 'name' => 'pyt8', 'type' => 'radio', 'text' =>
            'Która z form zarobkowania na bloga/stronie/serwisie jest dla Ciebie najbardziej skuteczna?', 'values' => json_encode([
            1 => 'sieci afiliacyjne',
            2 => 'programy partnerskie',
            3 => 'współpraca z agencjami/markami',
            4 => 'artykuły sponsorowane',
            5 => 'reklamy',
            6 => 'sprzedaż własnych produktów/usług',
            'other' => 'inne'
        ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 9, 'name' => 'pyt9', 'type' => 'checkbox', 'text' =>
            'Która z form zarobkowania na bloga/stronie/serwisie jest dla Ciebie najbardziej skuteczna?', 'values' => json_encode([
            1 => 'finanse',
            2 => 'ubezpieczenia',
            3 => 'produkty pozabankowe',
            4 => 'telekomunikacja',
            5 => 'energia',
            6 => 'rozrywka',
            7 => 'zdrowie i uroda'
        ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 10, 'name' => 'pyt10', 'type' => 'radio', 'text' =>
            'Jaki model rozliczeń preferujesz?', 'values' => json_encode([
            1 => 'CPL',
            2 => 'CPS',
            3 => 'CPA',
            4 => 'CPC',
            5 => 'CPM',
            6 => 'CPC + CPL',
            7 => 'CPC + CPM',
            'other' => 'inny'
        ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 11, 'name' => 'pyt11', 'type' => 'radio', 'text' =>
            'Czy preferujesz kampanie, w których co najmniej raz w miesiącu wymieniane są materiały reklamowe?', 'values' => json_encode([
            1 => 'tak',
            2 => 'nie',
        ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 12, 'name' => 'pyt12', 'type' => 'radio', 'text' =>
            'Z jakiego rodzaju formy reklamowej korzystasz najczęściej?', 'values' => json_encode([
            1 => 'link tekstowy',
            2 => 'mailing',
            3 => 'display',
            4 => 'video',
            'other' => 'innej'
        ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 13, 'name' => 'pyt13', 'type' => 'radio', 'text' =>
            'Czy preferujesz kampanie znanych marek ale z ustawionym limitem wysyłek?', 'values' => json_encode([
            1 => 'tak',
            2 => 'nie',
        ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 2, 'number' => 14, 'name' => 'pyt14', 'type' => 'radio', 'text' =>
            'Jaki parametr po otrzymaniu walidacji, jest dla Ciebie najważniejszy, decydujący o ewentualnej kontynuacji współpracy?', 'values' => json_encode([
            1 => '% akceptowalności',
            2 => 'wartość faktury/rozliczenia',
            3 => 'eCPL/realna wartość przychodu na leadzie'
        ]),
            'rule' => 'required']);

        //page 3

        Question::create(['survey_id' => 1, 'step' => 3, 'number' => 15, 'name' => 'pyt15', 'type' => 'radio', 'text' =>
            'Czy  na swoim blogu/stronie/serwisie promujesz kampanie firm pożyczkowych?', 'values' => json_encode([
            1 => 'tak',
            'other' => 'nie (uzasadnienie)'
        ]),
            'rule' => 'required']);

        //page 4

        Question::create(['survey_id' => 1, 'step' => 4, 'number' => 16, 'name' => 'pyt16', 'type' => 'text', 'text' =>
            'Podaj 5 najchętniej wybieranych przez Ciebie reklamodawców z zakresu pożyczek',
            'values' => [], 'rule' => 'required|min:1|max:50']);

        Question::create(['survey_id' => 1, 'step' => 4, 'number' => 17, 'name' => 'pyt17', 'type' => 'multiselect', 'text' =>
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

        Question::create(['survey_id' => 1, 'step' => 4, 'number' => 18, 'name' => 'pyt18', 'type' => 'text', 'text' =>
            'Czego Twoim zdaniem brakuje w obecnie funkcjonujących kampaniach firm pożyczkowych - co byś zmienił/ła?',
            'values' => [], 'rule' => 'required|min:1|max:50']);

        Question::create(['survey_id' => 1, 'step' => 4, 'number' => 19, 'name' => 'pyt19', 'type' => 'text', 'text' =>
            'Jak postrzegasz obecnie dostępne kampanie Vivus na tle konkurencyjnych firm pożyczkowych?',
            'values' => [], 'rule' => 'required|min:1|max:50']);

        Question::create(['survey_id' => 1, 'step' => 4, 'number' => 20, 'name' => 'pyt20', 'type' => 'radio', 'text' =>
            'Jak postrzegasz obecna obsługę wydawców afiliacyjnych po stronie Vivus?', 'values' => json_encode([
            1 => 'bardzo dobrze',
            2 => 'dobrze',
            3 => 'źle',
            4 => 'bardzo źle',
            5 => 'nie mam zdania',
        ]),
            'rule' => 'required']);

        Question::create(['survey_id' => 1, 'step' => 4, 'number' => 21, 'name' => 'pyt21', 'type' => 'text', 'text' =>
            'Co skłoniłoby Cię do promowania lub zwiększenia działań na rzecz kampanii Vivus?',
            'values' => [], 'rule' => 'required|min:1|max:50']);

        Question::create(['survey_id' => 1, 'step' => 4, 'number' => 22, 'name' => 'pyt22', 'type' => 'radio', 'text' =>
            'Co jest dla Ciebie najważniejsze w  promocjach/ konkursach dedykowanych dla wydawców?', 'values' => json_encode([
            1 => 'nagroda rzeczowa',
            2 => 'nagroda finansowa',
            3 => 'forma konkursu',
            'other' => 'inne'
        ]),
            'rule' => 'required']);

        Model::reguard();
    }
}
