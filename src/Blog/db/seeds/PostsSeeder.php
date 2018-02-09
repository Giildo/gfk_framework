<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class PostsSeeder extends AbstractSeed
{
    /**
     * Envoie des données à la DB
     */
    public function run()
    {
        $data = [];
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $date = $faker->unixTime('now');

            $data[] = [
                'name'       => $faker->catchPhrase,
                'slug'       => $faker->slug,
                'content'    => $faker->text(3000),
                'createdAt' => date('Y-m-d H:i:s', $date),
                'updatedAt' => date('Y-m-d H:i:s', $date)
            ];
        }

        $this->table('posts')
            ->insert($data)
            ->save();
    }
}
