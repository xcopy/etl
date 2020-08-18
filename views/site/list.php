<?php

use yii\db\ActiveRecord;
use app\models\Member;

/** @var $members ActiveRecord[] */
/** @var $member Member */
?>

<div class="container">
    <div class="my-3">
        <?php if (count($members)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
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
                            <td><?=$i + 1 ?></td>
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
            </div>
        <?php else: ?>
            <div class="text-center">There are no records to display.</div>
        <?php endif ?>
    </div>
</div>
