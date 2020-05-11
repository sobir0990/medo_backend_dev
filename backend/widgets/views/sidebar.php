<?php
/**
 * Created by PhpStorm.
 * User: OKS
 * Date: 12.10.2018
 * Time: 23:02
 * @var $user \common\models\User
 */

use yii\helpers\Html;
use yii\helpers\Url;

$menus = [
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
    'answer' => [
        'label' => 'Answer',
        'icon' => 'file',
        'url' => '/answer/index',
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
?>
<nav class="page-sidebar" data-pages="sidebar">
    <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
    <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
    <!-- BEGIN SIDEBAR MENU HEADER-->
    <div class="sidebar-header">
        <img src="<?= $this->getImageUrl('img/oks.svg') ?>" alt="logo" class="brand"
             data-src="<?= $this->getImageUrl('img/oks.svg') ?>"
             data-src-retina="<?= $this->getImageUrl('img/oks.svg') ?>" width="180" height="50">
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->
    <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
            <li class="m-t-30 ">
                <a href="<?= Url::home() ?>" class="detailed">
                    <span class="title">Dashboard</span>
                </a>
                <span class="icon-thumbnail"><i data-feather="shield"></i></span>
            </li>
            <?php foreach ($menus as $k => $menu): ?>
                <li>
                    <a href="<?= isset($menu['items']) && count($menu['items']) ? 'javascript:;' : Url::to($menu['url']) ?>" <?= isset($menu['items']) && count($menu['items']) ? ' class="detailed"' : '' ?>>
                        <span class="title"><?= __($menu['label']) ?></span>
                        <?php if (isset($menu['items']) && count($menu['items'])): ?>
                            <span class=" arrow"></span>
                        <?php endif; ?>
                    </a>
                    <span class="icon-thumbnail"><i data-feather="<?= $menu['icon'] ?>"></i></span>
                    <?php if (isset($menu['items']) && count($menu['items'])): ?>
                        <ul class="sub-menu">
                            <?php foreach ($menu['items'] as $item): ?>
                                <li class="">
                                    <a href="<?= Url::to($item['url']) ?>"><?= __($item['label']) ?></a>
                                    <span class="icon-thumbnail"></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
</nav>
