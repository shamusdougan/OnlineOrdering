<?php
namespace app\console\controllers;

use yii\helpers\Console;
use yii\console\Controller;
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
class RbacController extends Controller
{
    /**
     * Initializes the RBAC authorization data.
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        //---------- RULES ----------//

        // add the rule
        $rule = new \app\rbac\rules\AuthorRule;
        $auth->add($rule);

        //---------- PERMISSIONS ----------//

        // add "useSettings" Permissions
        $useSettings = $auth->createPermission('useSettings');
        $useSettings->description = 'Allow user to modify system settings';
        $auth->add($useSettings);
        
        $appAdmin = $auth->createRole('admin');
        $auth->add($appAdmin);
        $auth->addchild($appAdmin, $useSettings);
        
        $auth->assign($appAdmin, 1);
        

        if ($auth) 
        {
            $this->stdout("\nRbac authorization data are installed successfully.\n", Console::FG_GREEN);
        }
    }
}