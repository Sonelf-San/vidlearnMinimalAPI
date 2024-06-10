<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Pages;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if (Pages::count()) {
            return;
        }

        // Page: id -> name -> content

        $pages = [
            1 => [
                'name' => 'Quote 1',
                'content' => "Tout le monde est un génie. Mais si on juge un poisson sur sa capacité à grimper à un arbre, il passera sa vie à croire qu'il est stupide."
            ],
            2 => [
                'name' => 'Quote 2',
                'content' => "Le succès est un chemin que la patience et le travail rendent accessible."
            ],
            3 => [
                'name' => 'Quote 3',
                'content' => "Tout obstacle renforce la détermination. Celui qui s'est fixé un but n'en change pas."
            ],
            4 => [
                'name' => 'Quote 1 Author',
                'content' => 'Albert Einstein'
            ],
            5 => [
                'name' => 'Quote 2 Author',
                'content' => 'Pierre Simon Ballanche'
            ],
            6 => [
                'name' => 'Quote 3 Author',
                'content' => 'Leonard De Vinci'
            ],
            7 => [
                'name' => 'About Home English',
                'content' => "Very often young graduates are disoriented and without a marker after obtaining their exam. Most of these young people have
                from the final year an idea of the competition they will present but usually see their past under the nose for lack of INFORMATIONS and
                PREPARATIONS. It is in order to overcome this problem that the EDUSEC site has been setup to provide you with as much information as possible
                to better manage the Post -GCE period. Thus we put at your disposal all available competition orders, old corrected subjects, offers of foreign
                scholarships... We also provide students of high schools and colleges the test of differents exams and institutions of the cameroon, tutorials for
                all classes...<br>
                Your future is getting ready right now !!!"
            ],
            8 => [
                'name' => 'About Home French',
                'content' => "Très souvent les jeunes bacheliers se trouvent désorientés et sans repère après l'obtention de leur examen. La plupart de ces
                jeunes ont dès la classe de terminale une idée du (des) concours qu'ils vont présenter mais les voient en général leur passé sous le nez faute
                d'INFORMATIONS ET DE PREPARATION. C'est dans l'optique de palier à ce problème que le site EDUSEC a été mis sur pieds pour vous fournir le plus
                d'informations possibles pour mieux gérer la période post BAC. Ainsi nous mettons à votre disposition tous les arrêtés de concours disponibles,
                les anciens sujets corrigés, les offres de bourses d'études étrangères... Nous mettons également à la disposition des élèves des lycées et
                collèges les épreuves des différents examens et des établissements du Cameroun, les fiches de TD pour toutes les classes...<br>
                Votre avenir se prépare dès maintenant !!!"
            ],
            9 => [
                'name' => 'Who are we',
                'content' => "Edusec est le produit des efforts d'un collectif d'étudiants de differentes universites, des grandes ecoles et des enseignants
                de lycées et colleges qui vous fournira des épreuves et les dernieres informations en qualité de bourses et de concours."
            ],
            10 => [
                'name' => 'Goals',
                'content' => "Faciliter l'acquisition des epreuves avec corrections par les apprenants afin d'accélérer le processus de compréhension par le
                biais des corrections détaillées fournies avec les sujets pour favoriser l'entrée en classe supérieure ayant réussi à cerner les notions des
                classes précédentes. en plus de cela, en tant qu'ainé académique nous avons pour obligation de vous founir aussi des epreuves types examens
                pour les élèves en classes d'examens et les épreuves des coucours d'entrée dans les grandes écoles et facultés du cameroun. Si vous avez des
                préoccupations à nous soumettre nous vous prions de nous retrouver sur facebook et vous serrez notifiez dans les temps."
            ],
            11 => [
                'name' => 'Content Quote 1',
                'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pulvinar luctus est eget congue.<br>consectetur adipiscing elit.
                Sed pulvinar luctus est eget congue."
            ],
            12 => [
                'name' => 'Content Quote 2',
                'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pulvinar luctus est eget congue.<br>consectetur adipiscing elit.
                Sed pulvinar luctus est eget congue."
            ],
            13 => [
                'name' => 'Content Quote 3',
                'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pulvinar luctus est eget congue.<br>consectetur adipiscing elit.
                Sed pulvinar luctus est eget congue."
            ],
            14 => [
                'name' => 'Content Quote Author 1',
                'content' => "Fleming"
            ],
            15 => [
                'name' => 'Content Quote Author 2',
                'content' => "John"
            ],
            16 => [
                'name' => 'Content Quote Author 3',
                'content' => "Fleming"
            ],
            17 => [
                'name' => 'Edusec Sections',
                'content' => "EDUSEC COMMUNITY | EDUSEC MASTER ACADEMY | EDUSEC IMMERSION"
            ],
            18 => [
                'name' => 'Phone',
                'content' => '+237 690 300 451'
            ],
            19 => [
                'name' => 'Email',
                'content' => 'contact@edusec.biz'
            ],
            20 => [
                'name' => 'Location',
                'content' => 'Cameroon'
            ],
            21 => [
                'name' => 'Working Hours',
                'content' => '8Am-4Pm'
            ],
            22 => [
                'name' => 'Footer About',
                'content' => "Nous sommes une équipe très dynamique et disponible pour répondre à vos differentes questions. Nous sommes disponble aussi
                bien sur whatsapp que sur facebook."
            ],
            23 => [
                'name' => 'Facebook',
                'content' => 'https://web.facebook.com/Edusec237'
            ],
            24 => [
                'name' => 'Twitter',
                'content' => 'https://twitter.com/Edusec1'
            ],
            25 => [
                'name' => 'Instagram',
                'content' => 'https://www.instagram.com/edusec_community/'
            ],
            26 => [
                'name' => 'Linkedin',
                'content' => 'cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio'
            ],
        ];

        foreach ($pages as $k=>$v) {
            Pages::create([
                'id' => $k,
                'name' => $v['name'],
                'content' => $v['content'],
            ]);
        }

        // {!! Page::find(14)->content !!}
    }
}
