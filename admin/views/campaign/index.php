<div class="group-email-drip campaign browse">
    <p>
        Browse all drip campaigns.
    </p>
    <?=adminHelper('loadSearch', $search)?>
    <?=adminHelper('loadPagination', $pagination)?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th class="label">Label</th>
                    <th class="boolean">Active</th>
                    <th class="datetime">Last Run</th>
                    <th class="datetime">Created</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if ($campaigns) {

                    foreach ($campaigns as $oCampaign) {

                        ?>
                        <tr>
                            <td class="label">
                                <?php

                                echo $oCampaign->label;
                                if (!empty($oCampaign->description)) {
                                    echo '<small>' . $oCampaign->description . '</small>';
                                }

                                ?>
                            </td>
                            <?=adminHelper('loadBoolCell', $oCampaign->is_active)?>
                            <?=adminHelper('loadDatetimeCell', $oCampaign->last_run)?>
                            <?=adminHelper('loadDatetimeCell', $oCampaign->created)?>
                            <td class="actions">
                                <?php

                                if (userHasPermission('admin:emaildrip:campaign:edit')) {
                                    echo anchor(
                                        'admin/emaildrip/campaign/edit/' . $oCampaign->id,
                                        lang('action_edit'),
                                        'class="btn btn-xs btn-primary"'
                                    );
                                }

                                if (userHasPermission('admin:emaildrip:campaign:delete')) {
                                    echo anchor(
                                        'admin/emaildrip/campaign/delete/' . $oCampaign->id,
                                        lang('action_delete'),
                                        'class="btn btn-xs btn-danger confirm" data-body="You cannot undo this action"'
                                    );
                                }

                                ?>
                            </td>
                        <tr>
                        <?php
                    }

                } else {

                    ?>
                    <tr>
                        <td colspan="5" class="no-data">
                            No Drip Campaigns Configured
                        </td>
                    </tr>
                    <?php
                }

                ?>
            </tbody>
        </table>
    </div>
    <?=adminHelper('loadPagination', $pagination)?>
</div>