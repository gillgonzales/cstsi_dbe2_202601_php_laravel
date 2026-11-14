<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Produto;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ProdutoMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         try {

            $createdAt = Carbon::now()->toDateTimeString();
            $modelProdutoIds = Produto::doesntHave('medias')->pluck('id')->random(5);
            $modelType = Produto::class;
            $mediaLinks = [
                    'https://www.youtube.com/watch?v=QAfTYrDhdHE',
                    'https://www.youtube.com/watch?v=5s-_SnVl-1g',
                    'https://www.youtube.com/watch?v=127ng7botO4',
                    'https://www.youtube.com/watch?v=veSLRzmOfAI',
                    'https://www.youtube.com/watch?v=sBIkA95t1wM'
                ];

            $medias = $modelProdutoIds->map(function($prodId, $index)
                    use ($modelType,$createdAt,$mediaLinks)
                    {
                        return [
                            'mediable_id'  =>  $prodId,
                            'mediable_type'=>  $modelType,
                            'source'    =>  $mediaLinks[$index],
                            'type'      =>  'video',
                            'created_at'=>  $createdAt,
                            'updated_at'=>  $createdAt
                        ];
                    }
                )->toArray();

            Media::insert($medias)
                ? Log::channel('stderr')->info("Vídeos cadastrados!")
                : throw new Exception("Erro ao criar medias!");

        } catch(Exception $error) {
            Log::debug($error->getMessage());
            Log::channel('stderr')->error($error->getMessage());
        }
    }
}
