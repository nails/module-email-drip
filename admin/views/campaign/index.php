<div class="group-email-drip campaign browse">
    <p>
        Browse all drip campaigns.
    </p>
    <?php

        echo adminHelper('loadSearch', $search);
        echo adminHelper('loadPagination', $pagination);

    ?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th class="id">ID</th>
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

                        echo '<tr>';
                            echo '<td class="id">';
                                echo number_format($oCampaign->id);
                            echo '</td>';
                            echo '<td class="label">';
                                echo $oCampaign->label;
                                if (!empty($oCampaign->description)) {
                                    echo '<small>' . $oCampaign->description . '</small>';
                                }
                            echo '</td>';
                            echo adminHelper('loadBoolCell', $oCampaign->is_active);
                            echo adminHelper('loadDatetimeCell', $oCampaign->last_run);
                            echo adminHelper('loadDatetimeCell', $oCampaign->created);
                            echo '<td class="actions">';

                                if (userHasPermission('admin:emaildrip:campaign:edit')) {

                                    echo anchor(
                                        'admin/emaildrip/campaign/edit/' . $oCampaign->id,
                                        lang('action_edit'),
                                        'class="awesome small"'
                                    );
                                }

                                if (userHasPermission('admin:emaildrip:campaign:delete')) {

                                    echo anchor(
                                        'admin/emaildrip/campaign/delete/' . $oCampaign->id,
                                        lang('action_delete'),
                                        'class="awesome red small confirm" data-body="You cannot undo this action"'
                                    );
                                }

                            echo '</td>';
                        echo '<tr>';
                    }

                } else {

                    ?>
                    <tr>
                        <td colspan="6" class="no-data">
                            No Drip Campaigns Configured
                        </td>
                    </tr>
                    <?php
                }

                ?>
            </tbody>
        </table>
    </div>
    <?php

        echo adminHelper('loadPagination', $pagination);

    ?>
</div>