<?php

namespace phpunit\functional\models;

use app\behaviors\LoggableBehavior;
use app\models\ActionLog;
use app\models\Track;
use PHPUnit\Framework\TestCase;

class TrackTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Track::deleteAll();
        ActionLog::deleteAll();
    }

    public function testSave(): void
    {
        $track = new Track();
        $track->track_number = 'test3';
        self::assertTrue($track->save());
    }

    public function testUnique(): void
    {
        $track = new Track();
        $track->track_number = 'test3';
        self::assertTrue($track->save());

        $track = new Track();
        $track->track_number = 'test3';
        self::assertFalse($track->save());
    }

    public function testWrongStatus(): void
    {
        $track = new Track();
        $track->track_number = 'test3';
        $track->status = 99;
        self::assertFalse($track->save());
    }
}