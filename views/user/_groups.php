<?php

use app\assets\tools\Tool;
use yii\helpers\Url;
?>

<style>
    ul{
        list-style: none
    }
    #available-groups li,
    #assigned-groups li,
    #available-users li,
    #assigned-users li{
        margin-top: 10px;
        margin-right: 10px;
        cursor: pointer; 
    }

    #available-groups li:hover,
    #assigned-groups li:hover{
        font-size: 1.2em;
        color: #00a0f0;
        border: 1px solid #00a0f0
    }
</style>


<div class="row">
    <div class="col-md-6">
        <h4>
            <span class="lnr lnr-users"></span>
            Available User Groups
        </h4>
        <input type="text" class="form-control search-box" id="inputSearchAvailableGroups" placeholder="Search..."/>
        <ul class="list-group srollable" id="available-groups">
            <?php foreach ($model->getFreeGroups() as $groupId => $groupName): ?>
                <li class="list-group-item" id="group-<?= $groupId ?>">
                    <?= $groupName ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-md-6">
        <h4>
            <span class="lnr lnr-users"></span>
            Assigned User Groups
        </h4>
        <input type="text" class="form-control search-box" id="inputSearchAssignedGroups" placeholder="Search..."/>
        <ul class="list-group srollable" id="assigned-groups">
            <?php foreach ($model->getGroups() as $membership): ?>
                <li class="list-group-item" id="group-<?= $membership->group_id ?>">
                    <?= $membership->getGroup()->name ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>



    function moveItem(item, sourceId, destId) {
        const sourceList = document.getElementById(sourceId);
        const destList = document.getElementById(destId);
        sourceList.removeChild(item);
        destList.insertBefore(item, destList.firstChild);
        const loader = `<span style='margin-right: 10px' id='loader-${item.id}'><?= Tool::getMinLoader(40, 40) ?></span>`;
        item.innerHTML = item.innerHTML + loader;

        const url = `<?= Url::to(['/user-group/update-membership', 'userId' => $model->id]) ?>&groupId=${item.id.replace('group-', '')}&command=${sourceId === 'available-groups' ? 'ADD' : 'REMOVE'}`;

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

    function loadDefaultPages() {
        const url = `<?= Url::to(['load-default-pages', 'id' => $model->id]) ?>`;
        $.ajax({
            url,
            success: (response) => {
                let responseBundle = JSON.parse(response);
                switch (responseBundle.type) {
                    case 1:
                        let defaultPages = responseBundle.defaultPages;
                        let pages = ``;
                        for (let [pageKey, pageName] of Object.entries(defaultPages)) {

                            let page = `
                                <li id='page-${pageKey}' class='list-group-item' onclick='selectPage(event)'>${pageName}</li>
                            `;
                            pages += page;
                        }
                        $('#default-routes-list').html(pages);
                        break;
                    case 0:
                        //Error handling
                        break;
                    default:
                }
            },
            error: (error) => {
                //Error handling
            }
        });
    }

    function selectPage(event) {
        loadDefaultPages();
        let id = event.target.id.replace('page-', '');
        const url = `<?= Url::to(['make-default-page', 'id' => $model->id]) ?>&routeId=${id}`;
        $.ajax({
            url,
            beforeSend: () => {
                $('#defaultPageLabel').html("<?= Tool::showLoader() ?>");
            },
            success: (response) => {
                $('.loader').hide();
                let responseBundle = JSON.parse(response);
                switch (responseBundle.type) {
                    case 1:
                        let systemRoute = responseBundle.systemRoute;
                        $('#defaultPageLabel').html(`<i class='glyphicon glyphicon-link'></i>&nbsp;&nbsp;${systemRoute.pretty_name}`);
                        loadDefaultPages();
                        break;
                    case 0:
                        //Error handling
                        break;
                }
            },
            error: (error) => {
                console.log(error);
            }
        });
    }

    $(document).ready(() => {

        const height = $('body').height() * 0.8;
        $('.srollable').height(height);
        $('.srollable').css('overflow-y', 'scroll');

        $('#inputSearchAvailableGroups').keyup(() => {
            let text = $('#inputSearchAvailableGroups').val();
            search(text, 'available-groups');
        });
        $('#inputSearchAssignedGroups').keyup(() => {
            let text = $('#inputSearchAssignedGroups').val();
            search(text, 'assigned-groups');
        });

        //Load Possible Default Pages
        loadDefaultPages();

        //Move List Item
        $('li').click((event) => {
            const item = event.target;
            item.style.border = "1px solid #00a0f0";
            const itemParent = item.parentNode;
            switch (itemParent.id) {
                case 'available-groups':
                    moveItem(item, itemParent.id, 'assigned-groups');
                    break;
                case 'assigned-groups':
                    moveItem(item, itemParent.id, 'available-groups');
                    break;
            }
        });

    });

</script>