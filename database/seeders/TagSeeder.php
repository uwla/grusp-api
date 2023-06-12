<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // alguams tags básicas aqui...
        // obviamente, mais tags podem ser adicionadas
        $tags = [
            'cultura' => [
                'artes visuais', 'pintura', 'gastronomia', 'desenho', 'teatro',
                'fotografia',
            ],
            // from https://www5.usp.br/institucional/escolas-faculdades-e-institutos/
            'campus' => [
                'Bauru', 'Lorena', 'Piracicaba', 'Pirassununga',
                'Ribeirão Preto', 'Santos', 'São Carlos', 'São Paulo'
            ],
            'departamento' => [
                'EACH', 'ECA', 'EE', 'EEFE', 'FAU', 'FCF', 'FD', 'FE', 'FEA',
                'FFLCH', 'FM', 'FMVZ', 'FO', 'FSP', 'IAG', 'IB', 'ICB', 'IEA',
                'IEB', 'IEE', 'IF', 'IGc', 'IME', 'IMT', 'IO', 'IP', 'IQ', 'IRI',
                'POLI',
            ],
            'esportes' => [
                'basket', 'box', 'calistenia', 'capoeira', 'cheer', 'corrida',
                'escalada', 'futebol', 'ginástica', 'handebol', 'jiu jitsu',
                'judô', 'muay thai', 'natação', 'remo', 'tênis', 'volei', 'yoga'
            ],
            'estudos' => [
                'astronomia', 'computação', 'economia', 'literatura',
                'matemática', 'negócios', 'sociologia',
            ],
            'idioma' => [
                'coreano', 'espanhol', 'francês', 'inglês', 'japonẽs', 'português',
            ],
            'dança' => [
                'axé', 'forró', 'zouk', 'samba',
            ],
            'lazer' => [
                'filmes', 'jogos', 'tabuleiro', 'xadrez', 'video games',
            ],
            'religião' => [
                'cristianismo', 'espiritismo', 'budismo',
            ],
        ];

        $nested = Arr::flatten($tags);
        $parent = array_keys($tags);

        // não  faz  sentido  adicionar  aos  grupos  algumas  tags  tais   como
        // departamento ou campus, pois estas são tags usadas  para  categorizar
        // outras tags e não para categorizar grupos. Portanto, essas tags terão
        // um namespace diferente
        Tag::createMany($parent, 'tag');
        Tag::createMany($nested, 'grupo');

        foreach($tags as $parent => $children)
        {
            $tag = Tag::findByName($parent, 'tag');
            Tag::addTagTo($tag, Tag::findByName($children, 'grupo'));
        }

        // por fim, crie as permissões para as tags
        Tag::createCrudPermissions();
    }
}
