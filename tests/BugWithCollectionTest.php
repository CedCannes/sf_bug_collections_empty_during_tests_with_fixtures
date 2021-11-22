<?php

namespace App\Tests;

use App\Entity\Board;
use App\Entity\Lane;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BugWithCollectionTest extends WebTestCase
{


    public function testBug()
    {

        $this->client = static::createClient();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();

        $files = [
            __DIR__.'/../fixtures/lane.yml',
            __DIR__.'/../fixtures/board.yml',
        ];

        $this->databaseTool->loadAliceFixture($files, false);

        // uncomment the line below and the test passes
//        static::getContainer()->get('doctrine')->getManager()->clear();

        // verify that the board is in the database and has the correct number of lanes
        $board = $this->getContainer()->get('doctrine')->getRepository(Board::class)->find(1);
        $lanes = $this->getContainer()->get('doctrine')->getRepository(Lane::class)->findBy(['board'=>$board]);
        self::assertCount(4,$lanes);

        // check through the collection
        self::assertCount(4,$board->getLanes(), 'The board should have 4 lanes');

    }


}
