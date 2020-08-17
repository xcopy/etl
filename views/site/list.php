<div class="container">
    <div class="m-3">
        <?php foreach ($companies as $company): ?>
            <div class="card mb-3 border-secondary">
                <div class="card-body">
                    <h2 class="card-title"><?=$company->name ?></h2>
                    <p class="card-text">
                        <?=$company->registration_number ?> /
                        <?=$company->address ?> /
                        <?=$company->description ?>
                    </p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Dep.</th>
                                <th>Pos.</th>
                                <th>Full name</th>
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
                        <?php foreach ($company->members as $member): ?>
                            <tr>
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
            </div>
        <?php endforeach; ?>
    </div>
</div>
