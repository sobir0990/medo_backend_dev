<?php
namespace common\components\rbac;

use common\models\User;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\rbac\Rule;

class DefaultRule extends Rule
{

	/**
	 * Executes the rule.
	 *
	 * @param string|int $user the user ID. This should be either an integer or a string representing
	 * the unique identifier of a user. See [[\yii\web\User::id]].
	 * @param Item $item the role or permission that this rule is associated with
	 * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
	 * @return bool a value indicating whether the rule permits the auth item it is associated with.
	 */
	public function execute($user, $item, $params)
	{
		$user = ArrayHelper::getValue($params, 'user', User::findOne($user));

		if ($user) {
			$role = $user->role;

			if ($item->name === 'admin') {
				return $role == User::ROLE_ADMIN;
			}
			elseif ($item->name === 'moder') {
				return $role == User::ROLE_ADMIN || $role == User::ROLE_MODER;
			}
			elseif ($item->name === 'user') {
				return $role == User::ROLE_ADMIN || $role == User::ROLE_MODER
					|| $role == User::ROLE_USER;
			}
		}

		return false;
	}
}