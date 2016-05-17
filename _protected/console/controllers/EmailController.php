<?php
namespace app\console\controllers;

use yii\helpers\Console;
use yii\console\Controller;
use app\models\EmailQueue;
use Yii;

/**
 * Creates base rbac authorization data for our application.
 * -----------------------------------------------------------------------------
 * Creates 6 roles:
 *
 * - theCreator : you, developer of this site (super admin)
 * - admin      : your direct clients, administrators of this site
 * - editor     : editor of this site
 * - support    : support staff
 * - premium    : premium member of this site
 * - member     : user of this site who has registered his account and can log in
 *
 * Creates 7 permissions:
 *
 * - usePremiumContent  : allows premium members to use premium content
 * - createArticle      : allows editor+ roles to create articles
 * - updateOwnArticle   : allows editor+ roles to update own articles
 * - updateArticle      : allows admin+ roles to update all articles
 * - deleteArticle      : allows admin+ roles to delete articles
 * - adminArticle       : allows admin+ roles to manage articles
 * - manageUsers        : allows admin+ roles to manage users (CRUD plus role assignment)
 *
 * Creates 1 rule:
 *
 * - AuthorRule : allows editor+ roles to update their own content
 */
class EmailController extends Controller
{
    /**
     * Initializes the RBAC authorization data.
     */
    public function actionFlush()
    {
		$this->stdout("Flushing Emails from the Queue\n");
		$this->stdout("Starting Send Now\n");
       	$emails = EmailQueue::find()->All();
		foreach($emails as $emailMessage)
			{
			$this->stdout("Send email, Subject: ".$emailMessage->subject."\n");
			$result = $emailMessage->send();
			if($result)
				{
				$this->stdout($result);	
				}
			}
       
      
       return 0;
    }
}