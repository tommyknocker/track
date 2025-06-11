<?php

namespace api\Track;

use ApiTester;
use app\models\ActionLog;
use app\models\Track;
use app\models\User;
use Codeception\Test\Unit;
use Codeception\Util\HttpCode;
use yii\helpers\Json;

class ActionsTest extends Unit
{
    protected ?ApiTester $tester;
    protected ?Track $track1;
    protected ?Track $track2;
    protected ?User $user;

    public function _before(): void
    {
        Track::deleteAll();
        User::deleteAll();
        ActionLog::deleteAll();

        $track1 = new Track();
        $track1->track_number = 'test1';
        $track1->status = Track::STATUS_ID_NEW;
        $track1->save();
        $this->track1 = $track1;

        $track2 = new Track();
        $track2->track_number = 'test2';
        $track2->status = Track::STATUS_ID_COMPLETED;
        $track2->save();
        $this->track2 = $track2;

        $user = new User();
        $user->email = 'test@test.ru';
        $user->password = 'test123';
        $user->save();
        $this->user = $user;
    }

    public function testIndex(): void
    {
        $I = $this->tester;
        $I->sendGet('/track');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('test1');
        $I->seeResponseContains('test2');
        $response = Json::decode($I->grabResponse());
        $I->assertIsArray($response);
        $I->assertCount(2, $response);

        $I->sendGet('/track', ['status' => Track::STATUS_ID_COMPLETED]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->dontSeeResponseContains('test1');
        $I->seeResponseContains('test2');

        $response = Json::decode($I->grabResponse());
        $I->assertIsArray($response);
        $I->assertCount(1, $response);

    }

    public function testCreate(): void
    {
        $I = $this->tester;
        $data = [
            'track_number' => 'test3',
            'status' => Track::STATUS_ID_IN_PROGRESS,
        ];
        $I->amBearerAuthenticated($this->user->access_token);
        $I->sendPost('/track', $data);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->sendGet('/track');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('test3');
        $I->seeResponseContains('"status":' . Track::STATUS_ID_IN_PROGRESS);
    }

    public function testCreateDuplicate(): void
    {
        $I = $this->tester;
        $data = [
            'track_number' => 'test1',
        ];
        $I->amBearerAuthenticated($this->user->access_token);
        $I->sendPost('/track', $data);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('error');
    }

    public function testCreateWrongStatus(): void
    {
        $I = $this->tester;
        $data = [
            'track_number' => 'test3',
            'status' => 99
        ];
        $I->amBearerAuthenticated($this->user->access_token);
        $I->sendPost('/track', $data);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('error');
    }

    public function testGet(): void
    {
        $I = $this->tester;

        $I->sendGet('/track/' . $this->track1->id);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains($this->track1->track_number);
    }

    public function testUpdate(): void
    {
        $I = $this->tester;
        $I->amBearerAuthenticated($this->user->access_token);
        $data = [
            'track_number' => 'test3',
        ];
        $I->sendPatch('/track/' . $this->track1->id, $data);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendGet('/track');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('test3');
    }

    public function testDelete(): void
    {
        $I = $this->tester;
        $I->amBearerAuthenticated($this->user->access_token);
        $I->sendDelete('/track/' . $this->track1->id);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendGet('/track/' . $this->track1->id);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->dontSeeResponseContains($this->track1->track_number);
    }

    public function testChangeStatus(): void
    {
        $I = $this->tester;
        $I->amBearerAuthenticated($this->user->access_token);
        $id = [$this->track1->id, $this->track2->id];
        $status = Track::STATUS_ID_FAILED;
        $I->sendPost('/track/change-status', ['id' => $id, 'status' => $status]);

        $I->sendGet('/track', ['status' => Track::STATUS_ID_FAILED]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        codecept_debug($I->grabResponse());
        $I->seeResponseContains('test1');
        $I->seeResponseContains('test2');

        $response = Json::decode($I->grabResponse());
        $I->assertIsArray($response);
        $I->assertCount(2, $response);
    }
}