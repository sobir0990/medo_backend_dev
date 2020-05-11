<?php

namespace backend\components;

use Yii;
use yii\caching\TagDependency;
use common\models\User;

class View extends \yii\web\View
{
	public $menus = [
        'category/index' => [
            'label' => 'Категория',
            'icon' => 'file',
            'url' => '/category/category/index',
        ],
        'banner/index' => [
            'label' => 'Banner',
            'icon' => 'file',
            'url' => '/banner/index',
        ],
		'post/create' => [
			'label' => 'Янгилик қўшиш',
			'icon' => 'file',
			'url' => '/post/create',
		],
		'post/index' => [
			'label' => 'Янгиликлар рўйхати',
			'icon' => 'file',
			'url' => '/post/index',
		],
		'encyclopedia/index' => [
			'label' => 'Энциклопедия',
			'icon' => 'file',
			'url' => '/encyclopedia/index',
		],
		[
			'label' => 'Модератор лентаси',
			'items' => [
				'company-moder' => [
					'label' => 'Компания',
					'icon' => 'file',
					'url' => '/company-moder/index',
				],
				'product-moder' => [
					'label' => 'Продукт',
					'icon' => 'file',
					'url' => '/product-moder/index',
				],
                'Эълонлар' => [
                    'label' => 'Эълонлар',
                    'icon' => 'file',
                    'url' => '/product-announcement/index',
                ],
				'post-moder' => [
					'label' => 'Пость',
					'icon' => 'file',
					'url' => '/post-moder/index',
				],
				'vacation-moder' => [
					'label' => 'Вакансия',
					'icon' => 'file',
					'url' => '/vacation-moder/index',
				],
				'resume' => [
					'label' => 'Резюме',
					'icon' => 'file',
					'url' => '/resume-moder/index',
				],
				'review' => [
					'label' => 'Отзывы',
					'icon' => 'file',
					'url' => '/review-moder/index',
				],
			],
		],
        'test' => [
            'label' => 'Тест Саволлар',
            'icon' => 'file',
            'url' => '/questionform/index',
        ],
        'announcement' => [
            'label' => 'Эълонлар',
            'icon' => 'file',
            'url' => '/announcement',
        ],
        'product' => [
            'label' => 'Товарлар',
            'icon' => 'file',
            'url' => '/product',
        ],
        'company' => [
            'label' => 'Компания',
            'icon' => 'file',
            'url' => '/company',
        ],

        'resume' => [
            'label' => 'Резюме',
            'icon' => 'file',
            'url' => '/resume',
        ],
        'vacation' => [
            'label' => 'Вакансия',
            'icon' => 'file',
            'url' => '/vacation',
        ],
		[
			'label' => 'Фойдаланувчилар',
			'items' => [
				'users' => [
					'label' => 'Врачлар',
					'icon' => 'file',
					'url' => '/profile/doctor',
				],
				'education' => [
					'label' => 'Фойдаланувчилар',
					'icon' => 'file',
					'url' => '/user/index',
				],
				'profile' => [
					'label' => 'Profile',
					'icon' => 'file',
					'url' => '/profile/index',
				],
			],
		],
		[
			'label' => 'Setting',
			'items' => [
				'settings' => [
					'label' => 'Settings',
					'icon' => 'file',
					'url' => '/settings',
				],
                'menu' => [
                    'label' => 'Меню',
                    'icon' => 'file',
                    'url' => '/menu/menu',
                ],
                'translations' => [
					'label' => 'Translations',
					'icon' => 'file',
					'url' => '/translation/source-message',
				],
				'moder-reason' => [
					'label' => 'Moder Reason',
					'icon' => 'file',
					'url' => '/moder-reason/',
				],
			],
		],
	];

	public function getMenu()
	{
		return $this->menus;
	}

	public function _user()
	{
		return $this->context->_user();
	}

	public function getMenuItems()
	{
		$menu = [];

		$FilterAccessControl = new FilterAccessControl;

		if ($user = $this->_user()) {
			$menu = Yii::$app->cache->getOrSet([User::CACHE_KEY_USER_MENU, 'user_id' => $user->id, 'language' => Yii::$app->language], function () use ($user, $FilterAccessControl) {
				$menu = $this->menus;

				foreach ($menu as $id => &$item) {
					if (empty($item)) continue;

					if (isset($item['items']) && !empty($item['items'])) {
						foreach ($item['items'] as $p => &$childItem) {
							if (!$this->_user()->canAccessToResource($childItem['url'], $FilterAccessControl->except)) {
								unset($menu[$id]['items'][$p]);
							}

							$childItem['label'] = __($childItem['label']);
						}

						if (count($menu[$id]['items']) == 0 && !$user->canAccessToResource($item['url'], $FilterAccessControl->except)) {
							unset($menu[$id]);
						}
					}

					$item['label'] = __($item['label']);

					if (!$user->canAccessToResource($item['url'], $FilterAccessControl->except) && (!isset($item['items']) || count($item['items']) == 0)) {
						unset($menu[$id]);
					}
				}

				return $menu;

			}, null, new TagDependency(['tags' => User::CACHE_KEY_USER_MENU]));
		}

		return $menu;
	}

	public function getImageUrl($name)
	{
		return $this->getAssetManager()->getBundle('\backend\assets\AppAsset')->baseUrl . '/' . $name;
	}
}
