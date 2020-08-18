<?php

use yii\db\ActiveRecord;
use yii\data\Pagination;
use app\models\Member;

/** @var $members ActiveRecord[] */
/** @var $member Member */
/** @var $pagination Pagination */

?>

<div class="container">
    <div class="my-3">
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
                            <td><?=$member->nationality ?></td>
                            <td><?=$member->passport_number ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

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
            </div>
        <?php else: ?>
            <div class="text-center">There are no records to display.</div>
        <?php endif ?>
    </div>
</div>
