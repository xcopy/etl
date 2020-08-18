<?php

use yii\db\ActiveRecord;
use yii\data\Pagination;
use yii\web\View;
use yii\helpers\Url;
use app\models\Member;

/** @var $companies array */
/** @var $departments array */
/** @var $positions array */
/** @var $countries array */
/** @var $members ActiveRecord[] */
/** @var $member Member */
/** @var $pagination Pagination */
/** @var $this View */

?>

<div class="container">
    <div class="my-3">
        <form method="get" action="<?=Url::to('list') ?>">
            <div class="row">
                <div class="col-md-5">
                    <?=$this->render('_select', [
                        'key' => 'company_id',
                        'options' => $companies
                    ]) ?>
                </div>
                <div class="col-md-5">
                    <?=$this->render('_select', [
                        'key' => 'department_id',
                        'options' => $departments
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <a href="<?=Url::to('list') ?>" class="btn btn-link btn-block">Reset</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <?=$this->render('_select', [
                        'key' => 'position_id',
                        'options' => $positions
                    ]) ?>
                </div>
                <div class="col-md-5">
                    <?=$this->render('_select', [
                        'key' => 'country_id',
                        'options' => $countries
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">Select</button>
                </div>
            </div>
        </form>

        <?php if (count($members)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Company</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Name</th>
                            <th>Role</th>
                            <!--
                            <th>Gender</th>
                            -->
                            <th>Birth date</th>
                            <th>Nationality</th>
                            <th>Pass. No.</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($members as $i => $member): ?>
                        <tr>
                            <td><?=$member->primaryKey ?></td>
                            <td><?=$member->company->name ?></td>
                            <td><?=$member->department ? $member->department->name : '' ?></td>
                            <td><?=$member->position ? $member->position->name : '' ?></td>
                            <td><?=$member->full_name ?></td>
                            <td><?=$member->role ?></td>
                            <!--
                            <td><?=$member->gender ?></td>
                            -->
                            <td><?=$member->birthDateText ?></td>
                            <td><?=$member->country->name ?></td>
                            <td><?=$member->passport_number ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if ($pagination->pageCount > 1): ?>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php if (isset($pagination->links[Pagination::LINK_FIRST])): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?=$pagination->links[Pagination::LINK_FIRST] ?>" title="First">&laquo;</a>
                                </li>
                            <?php endif ?>
                            <?php if (isset($pagination->links[Pagination::LINK_PREV])): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?=$pagination->links[Pagination::LINK_PREV] ?>">Prev</a>
                                </li>
                            <?php endif ?>
                            <li class="page-item active">
                                <a class="page-link" href="#"><?=$pagination->page + 1 ?></a>
                            </li>
                            <?php if (isset($pagination->links[Pagination::LINK_NEXT])): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?=$pagination->links[Pagination::LINK_NEXT] ?>">Next</a>
                                </li>
                            <?php endif ?>
                            <?php if (isset($pagination->links[Pagination::LINK_LAST])): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?=$pagination->links[Pagination::LINK_LAST] ?>" title="Last">&raquo;</a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </nav>
                <?php endif ?>
            </div>
        <?php else: ?>
            <div class="text-center">There are no records to display.</div>
        <?php endif ?>
    </div>
</div>
