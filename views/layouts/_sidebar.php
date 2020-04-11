<?php

use yii\helpers\Url;
use app\assets\tools\SideNav;

$user = \Yii::$app->session['user'];
?>

<nav>
    <ul class="nav" id="mainNav">
        <?php SideNav::startMenuItem($user->canView("site/index")) ?>
        <?=
        SideNav::createMenuItem([
            'controller' => 'site',
            'action' => 'index',
            'label' => 'Dashboard',
            'icon' => 'lnr lnr-home'
        ])
        ?>
        <?php SideNav::endMenuItem() ?>

        <?php SideNav::startMenuItem($user->canView("user/my-profile")) ?>
        <?=
        SideNav::createMenuItem([
            'controller' => 'user',
            'action' => 'my-profile',
            'label' => 'My Profile',
            'icon' => 'lnr lnr-user',
            'params' => [
                'id' => Yii::$app->user->id
            ]
        ])
        ?>
        <?php SideNav::endMenuItem() ?>



        <?php SideNav::startMenuItem($user->canView("user/index")) ?>
        <?=
        SideNav::createMenuItem([
            'controller' => 'user',
            'action' => 'index',
            'label' => 'System Users',
            'icon' => 'lnr lnr-users'
        ])
        ?>
        <?php SideNav::endMenuItem() ?>


        <?php
        SideNav::startMenuItemsGroup([
            'label' => 'References',
            'groupId' => 'referenceItems',
            'visible' => $user->canViewAny([
                'time-unit/index',
                'salutation/index',
                'identity-type/index',
                'institution-type/index'
            ]),
            'icon' => 'glyphicon glyphicon-link'
        ]);
        ?>

        <?php SideNav::startMenuItem($user->canView("salutation/index")) ?>
        <?=
        SideNav::createMenuItem([
            'controller' => 'salutation',
            'action' => 'index',
            'label' => 'Saluation'
        ])
        ?>
        <?php SideNav::endMenuItem() ?>

        <?php SideNav::startMenuItem($user->canView("institution-type/index")) ?>
        <?=
        SideNav::createMenuItem([
            'controller' => 'institution-type',
            'action' => 'index',
            'label' => 'Institution Types'
        ])
        ?>
        <?php SideNav::endMenuItem() ?>
        <?php SideNav::endMenuItemsGroup() ?>


        <?php
        SideNav::startMenuItemsGroup([
            'label' => 'Configurations',
            'groupId' => 'configurationItems',
            'visible' => $user->canViewAny([
                'institution/index',
                'institution-structure/index',
                'salary-structure-version/index',
                'file-type/index'
            ]),
            'icon' => 'glyphicon glyphicon-wrench'
        ]);
        ?>

        <?php SideNav::startMenuItem($user->canView("institution/index")) ?>
        <?=
        SideNav::createMenuItem([
            'controller' => 'institution',
            'action' => 'index',
            'label' => 'Institution Setup'
        ])
        ?>
        <?php SideNav::endMenuItem() ?>

        <?php SideNav::startMenuItem($user->canView("institution-structure/index")) ?>
        <?=
        SideNav::createMenuItem([
            'controller' => 'institution-structure',
            'action' => 'index',
            'label' => 'Institution Structures'
        ])
        ?>
        <?php SideNav::endMenuItem() ?>

        <?php SideNav::startMenuItem($user->canView("file-type/index")) ?>
        <?=
        SideNav::createMenuItem([
            'controller' => 'file-type',
            'action' => 'index',
            'label' => 'File Types'
        ])
        ?>
        <?php SideNav::endMenuItem() ?>
        <?php SideNav::endMenuItemsGroup(); ?>


        <?php
        SideNav::startMenuItemsGroup([
            'label' => 'System Setup',
            'groupId' => 'systemSetupItems',
            'visible' => $user->canViewAny([
                'system-route/index',
                'user-group/index'
            ]),
            'icon' => 'glyphicon glyphicon-cog'
        ]);
        ?>

        <?php SideNav::startMenuItem($user->canView("system-route/index")) ?>
        <?=
        SideNav::createMenuItem([
            'controller' => 'system-route',
            'action' => 'index',
            'label' => 'System Routes'
        ])
        ?>
        <?php SideNav::endMenuItem() ?>



        <?php SideNav::startMenuItem($user->canView("user-group/index")) ?>
        <?=
        SideNav::createMenuItem([
            'controller' => 'user-group',
            'action' => 'index',
            'label' => 'User Groups'
        ])
        ?>
        <?php SideNav::endMenuItem() ?>

        <?php SideNav::endMenuItemsGroup() ?>
        <li><a href="<?= Url::to(['site/log-me-out']) ?>" class=""><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
    </ul>
</nav>

<script>

    $(document).ready(() => {

        const currentUrl = window.location.href;
        const currentProtocol = window.location.href.split(':')[0];
        const anchors = document.getElementById('mainNav').getElementsByTagName('a');

        for (let index = 0; index < anchors.length; index++) {

            const currentHref = anchors[index].href;

            if (currentHref === currentUrl) {
                anchors[index].classList.add('active');
                anchors[index].parentNode.parentNode.parentNode.classList.add('in');
                return;
                // anchors[index].parentNode.parentNode.parentNode.peviousSiblingclassList.add('active');
                //$('.collapse').addClass('in');
            }
        }
    });

</script>