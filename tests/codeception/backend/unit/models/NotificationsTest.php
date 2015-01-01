<?php

namespace tests\codeception\backend\unit\models;

use core\models\Administrator;
use core\models\Notification;
use Yii;
use tests\codeception\backend\unit\TestCase;
use Codeception\Specify;
use yii\db\Expression;

/**
 * Login form test
 */
class NotificationsTest extends TestCase
{
    use Specify;

    public function testNotifications()
    {
        \Yii::$app->db->createCommand()->insert('User', [
            'type' => 'Administrator',
            'firstname' => 'Cele',
            'lastname' => 'Born',
            'name' => 'Cele Born',
            'email' => 'cele.born@theshireemail.com',
            'password' => md5('test123'),
            'update_by' => 1,
            'create_by' => 1,
            'update_time' => new Expression('NOW()'),
            'create_time' => new Expression('NOW()'),
        ])->execute();
        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $this->specify('The contact has 0 notifications', function () use ($contactCeleborn) {
            $this->assertTrue($contactCeleborn->getNotifications()->count() == 0);
        });
    }

    public function testNotificationsAll()
    {
        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $initialNotifications = $contactCeleborn->getNotifications()->count();

        \Yii::$app->db->createCommand()->insert('Notification', [
            'name' => 'Notification 1',
            'description' => 'Description 1',
            'internal_type' => 'Administrator',
            'type' => 'info',
            'status' => 'active',
            'all' => 1,
            'update_by' => 1,
            'create_by' => 1,
            'update_time' => new Expression('NOW()'),
            'create_time' => new Expression('NOW()'),
        ])->execute();

        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $this->specify('The contact has 1 additional notification', function () use ($contactCeleborn, $initialNotifications) {
            $this->assertTrue($contactCeleborn->getNotifications()->count() == $initialNotifications + 1);
        });
    }

    public function testNotificationsAllWrongType()
    {
        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $initialNotifications = $contactCeleborn->getNotifications()->count();

        \Yii::$app->db->createCommand()->insert('Notification', [
            'name' => 'Notification 2',
            'description' => 'Description 2',
            'internal_type' => 'Contact',
            'type' => 'info',
            'status' => 'active',
            'all' => 1,
            'update_by' => 1,
            'create_by' => 1,
            'update_time' => new Expression('NOW()'),
            'create_time' => new Expression('NOW()'),
        ])->execute();

        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $this->specify('The contact has the same amount of notifications', function () use ($contactCeleborn, $initialNotifications) {
            $this->assertTrue($contactCeleborn->getNotifications()->count() == $initialNotifications);
        });
    }

    public function testNotificationsSpecific()
    {
        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $initialNotifications = $contactCeleborn->getNotifications()->count();

        \Yii::$app->db->createCommand()->insert('Notification', [
            'name' => 'Notification 3',
            'description' => 'Description 3',
            'internal_type' => 'Contact',
            'type' => 'info',
            'status' => 'active',
            'all' => 0,
            'update_by' => 1,
            'create_by' => 1,
            'update_time' => new Expression('NOW()'),
            'create_time' => new Expression('NOW()'),
        ])->execute();

        $notification = Notification::findOne(['name' => 'Notification 3']);

        \Yii::$app->db->createCommand()->insert('NotificationUser', [
            'Notification_id' => $notification->id,
            'User_id' => $contactCeleborn->id,
            'status' => 'active',
            'update_by' => 1,
            'create_by' => 1,
            'update_time' => new Expression('NOW()'),
            'create_time' => new Expression('NOW()'),
        ])->execute();

        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $this->specify('The contact has 1 additional notification', function () use ($contactCeleborn, $initialNotifications) {
            $this->assertEquals($contactCeleborn->getNotifications()->count(), $initialNotifications + 1);
        });
    }

    public function testNotificationsStartDate()
    {
        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $initialNotifications = $contactCeleborn->getNotifications()->count();

        \Yii::$app->db->createCommand()->insert('Notification', [
            'name' => 'Notification 4',
            'description' => 'Description 4',
            'internal_type' => 'Administrator',
            'start_date' => new Expression('CURDATE() - INTERVAL 1 DAY'),
            'type' => 'info',
            'status' => 'active',
            'all' => 1,
            'update_by' => 1,
            'create_by' => 1,
            'update_time' => new Expression('NOW()'),
            'create_time' => new Expression('NOW()'),
        ])->execute();

        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $this->specify('The contact has 1 additional notification', function () use ($contactCeleborn, $initialNotifications) {
            $this->assertEquals($contactCeleborn->getNotifications()->count(), $initialNotifications + 1);
        });
    }

    public function testNotificationsStartDateNotStarted()
    {
        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $initialNotifications = $contactCeleborn->getNotifications()->count();

        \Yii::$app->db->createCommand()->insert('Notification', [
            'name' => 'Notification 5',
            'description' => 'Description 5',
            'internal_type' => 'Administrator',
            'start_date' => new Expression('CURDATE() + INTERVAL 1 DAY'),
            'type' => 'info',
            'status' => 'active',
            'all' => 1,
            'update_by' => 1,
            'create_by' => 1,
            'update_time' => new Expression('NOW()'),
            'create_time' => new Expression('NOW()'),
        ])->execute();

        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $this->specify('The contact has the same amount of notifications', function () use ($contactCeleborn, $initialNotifications) {
            $this->assertEquals($contactCeleborn->getNotifications()->count(), $initialNotifications);
        });
    }

    public function testNotificationsEndDate()
    {
        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $initialNotifications = $contactCeleborn->getNotifications()->count();

        \Yii::$app->db->createCommand()->insert('Notification', [
            'name' => 'Notification 4',
            'description' => 'Description 4',
            'internal_type' => 'Administrator',
            'end_date' => new Expression('CURDATE() + INTERVAL 1 DAY'),
            'type' => 'info',
            'status' => 'active',
            'all' => 1,
            'update_by' => 1,
            'create_by' => 1,
            'update_time' => new Expression('NOW()'),
            'create_time' => new Expression('NOW()'),
        ])->execute();

        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $this->specify('The contact has 1 additional notification', function () use ($contactCeleborn, $initialNotifications) {
            $this->assertEquals($contactCeleborn->getNotifications()->count(), $initialNotifications + 1);
        });
    }

    public function testNotificationsEndDateExpired()
    {
        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $initialNotifications = $contactCeleborn->getNotifications()->count();

        \Yii::$app->db->createCommand()->insert('Notification', [
            'name' => 'Notification 4',
            'description' => 'Description 4',
            'internal_type' => 'Administrator',
            'end_date' => new Expression('CURDATE() - INTERVAL 1 DAY'),
            'type' => 'info',
            'status' => 'active',
            'all' => 1,
            'update_by' => 1,
            'create_by' => 1,
            'update_time' => new Expression('NOW()'),
            'create_time' => new Expression('NOW()'),
        ])->execute();

        $contactCeleborn = Administrator::findOne(['email' => 'cele.born@theshireemail.com']);
        $this->specify('The contact has the same amount of notifications', function () use ($contactCeleborn, $initialNotifications) {
            $this->assertEquals($contactCeleborn->getNotifications()->count(), $initialNotifications);
        });
    }

}
