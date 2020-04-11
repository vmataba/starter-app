<?php

use app\assets\tools\Tool;
use yii\helpers\Url;
?>
<style>
    #available-routes li,
    #assigned-routes li,
    #available-users li,
    #assigned-users li{
        margin-top: 10px;
        margin-right: 10px;
        cursor: pointer; 
    }

    #available-routes li:hover,
    #assigned-routes li:hover,
    #available-users li:hover,
    #assigned-users li:hover{
        font-size: 1.2em;
        color: #00a0f0;
        border: 1px solid #00a0f0
    }
</style>

<div class="row">
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 style="font-weight: bold">Available Routes</h5>
                        <input type="text" class="form-control search-box" id="inputSearchAvailableRoutes" placeholder="Search..."/>
                        <ul class="list-group srollable" id="available-routes">
                            <?php foreach ($model->getFreeRoutes() as $routeId => $prettyName): ?>
                                <li id="route-<?= $routeId ?>" class="list-group-item item-name"><?= $prettyName ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5 style="font-weight: bold">Assigned Routes</h5>
                        <input type="text" class="form-control search-box" id="inputSearchAssignedRoutes" placeholder="Search..."/>
                        <ul class="list-group srollable" id="assigned-routes">
                            <?php foreach ($model->getRoutes() as $route): ?>
                                <li id="route-<?= $route->getRoute()->id ?>" class="list-group-item">
                                    <?= $route->getRoute()->pretty_name ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 style="font-weight: bold">Available Users</h5>
                        <input type="text" class="form-control search-box" id="inputSearchAvailableUsers" placeholder="Search..."/>
                        <ul class="list-group srollable" id="available-users">
                            <?php foreach ($model->getFreeUsers() as $userId => $userFullName): ?>
                                <li id="user-<?= $userId ?>" class="list-group-item item-name"><?= $userFullName ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5 style="font-weight: bold">Assigned Users</h5>
                        <input type="text" class="form-control search-box" id="inputSearchAssignedUsers" placeholder="Search..."/>
                        <ul class="list-group srollable" id="assigned-users">
                            <?php foreach ($model->getMembers() as $membership): ?>
                                <li id="user-<?= $membership->user_id ?>" class="list-group-item">
                                    <?= $membership->getUser()->getFullName() ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<script>
    $('#inputSearchAvailableRoutes').keyup(() => {
        let text = $('#inputSearchAvailableRoutes').val();
        search(text, 'available-routes');
    });
    $('#inputSearchAssignedRoutes').keyup(() => {
        let text = $('#inputSearchAssignedRoutes').val();
        search(text, 'assigned-routes');
    });
    $('#inputSearchAvailableUsers').keyup(() => {
        let text = $('#inputSearchAvailableUsers').val();
        search(text, 'available-users');
    });
    $('#inputSearchAssignedUsers').keyup(() => {
        let text = $('#inputSearchAssignedUsers').val();
        search(text, 'assigned-users');
    });

    function search(keyword, listId) {
        if (keyword.trim().length > 0) {
            $(`#${listId}`).children().each((index, routeItem) => {
                let prettyName = routeItem.innerHTML;
                if (!prettyName.toLowerCase().includes(keyword.toLowerCase())) {
                    routeItem.style.display = 'none';
                } else {
                    routeItem.style.display = 'list-item';
                }
            });
        } else {
            $(`#${listId}`).children().each((index, routeItem) => {
                if (routeItem.style.display === 'none') {
                    routeItem.style.display = 'list-item';
                }
            });
        }
    }

    function moveItem(item, sourceId, destId) {
        const sourceList = document.getElementById(sourceId);
        const destList = document.getElementById(destId);
        sourceList.removeChild(item);
        destList.insertBefore(item, destList.firstChild);
        const loader = `<span style='margin-right: 10px' id='loader-${item.id}'><?= Tool::getMinLoader(40, 40) ?></span>`;
        item.innerHTML = item.innerHTML + loader;
        //Routes Url
        let url = `<?= Url::to(['update-access', 'groupId' => $model->id]) ?>&routeId=${item.id.replace('route-', '')}&command=${sourceId === 'available-routes' ? 'ADD' : 'REMOVE'}`;
        //Membership url
        if (sourceId.includes('users')) {
            url = `<?= Url::to(['update-membership', 'groupId' => $model->id]) ?>&userId=${item.id.replace('user-', '')}&command=${sourceId === 'available-users' ? 'ADD' : 'REMOVE'}`;
        }
        $.ajax({
            url,
            success: (response) => {
                $(`#loader-${item.id}`).remove();
                let responseBundle = JSON.parse(response);
                console.log(responseBundle);
                switch (responseBundle.type) {
                    case 1:
                        //Success
                        break;
                    case 0:
                        //Error handling
                        break;
                }

            },
            error: (error) => {
                $(`#loader-${item.id}`).remove();
                //Error Handling
            }
        });
    }

    $(document).ready(() => {
        const height = $('body').height() * 0.8;
        $('.srollable').height(height);
        $('.srollable').css('overflow-y', 'scroll');
        $('#inputSearchRoutes').css('margin-left', $('li').css('margin-left'));

        //Move List Item
        $('li').click((event) => {
            const item = event.target;
            item.style.border = "1px solid #00a0f0";
            const itemParent = item.parentNode;
            switch (itemParent.id) {
                case 'available-routes':
                    moveItem(item, itemParent.id, 'assigned-routes');
                    break;
                case 'assigned-routes':
                    moveItem(item, itemParent.id, 'available-routes');
                    break;
                case 'available-users':
                    moveItem(item, itemParent.id, 'assigned-users');
                    break;
                case 'assigned-users':
                    moveItem(item, itemParent.id, 'available-users');
                    break;
            }
        });
    });
</script>

