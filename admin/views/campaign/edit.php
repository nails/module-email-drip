<div class="group-email-drip campaign edit">
    <h2>Campaign Details &amp; Configurations</h2>
    <fieldset>
        <legend>
            Details
        </legend>
        <?php

        $aField = array(
            'key'      => 'label',
            'label'    => 'Segment',
            'required' => true,
            'default'  => !empty($campaign->segment_id) ? $campaign->segment_id : '',
            'class'    => 'select2'
        );
        echo form_field_dropdown($aField, array('Segment 1', 'Segment 2'));

        // --------------------------------------------------------------------------

        $aField = array(
            'key'         => 'label',
            'label'       => 'Label',
            'placeholder' => 'Define the campaign\'s label',
            'required'    => true,
            'default'     => !empty($campaign->label) ? $campaign->label : ''
        );
        echo form_field($aField);

        // --------------------------------------------------------------------------

        $aField = array(
            'key'         => 'description',
            'label'       => 'Description',
            'placeholder' => 'Give the campaign a description; let others know what the purpose of the campaign is',
            'default'     => !empty($campaign->description) ? $campaign->description : ''
        );
        echo form_field_textarea($aField);

        // --------------------------------------------------------------------------

        $aField = array(
            'key'     => 'is_active',
            'label'   => 'Active',
            'default' => !empty($campaign->is_active) ? $campaign->is_active : ''
        );
        echo form_field_boolean($aField);

        ?>
    </fieldset>
    <fieldset>
        <legend>Configurations</legend>
        <div class="configurations">
            Process this campaign at
            <div class="time-group">
                <select>
                    <option>00</option>
                    <option>01</option>
                    <option>02</option>
                </select>
                :
                <select>
                    <option>00</option>
                    <option>05</option>
                    <option>10</option>
                </select>
            </div>
            on
            <label>
                <input type="checkbox" checked="checked"> Monday
            </label>
            <label>
                <input type="checkbox" checked="checked"> Tuesday
            </label>
            <label>
                <input type="checkbox" checked="checked"> Wednesday
            </label>
            <label>
                <input type="checkbox" checked="checked"> Thursday
            </label>
            <label>
                <input type="checkbox" checked="checked"> Friday
            </label>
            <label>
                <input type="checkbox" checked="checked"> Saturday
            </label>
            <label>
                <input type="checkbox" checked="checked"> Sunday
            </label>
        </div>
    </fieldset>
    <h2>Emails</h2>
    <div id="emails" data-bind="foreach: emails">
        <fieldset class="email">
            <legend>
                Email #<span data-bind="text: $index"></span>
                <div class="controls pull-right">
                    <!-- ko if: $index() != 0 -->
                    <a href="#" data-bind="click: $root.moveUp">
                        <i class="fa fa-caret-up"></i>
                    </a>
                    <!-- /ko -->
                    <!-- ko if: ($index() + 1) != $root.emails().length -->
                    <a href="#" data-bind="click: $root.moveDown">
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <!-- /ko -->
                    <a href="#" data-bind="click: $root.removeEmail">
                        <i class="fa fa-times-circle"></i>
                    </a>
                </div>
            </legend>
            <div class="trigger">
                <span class="text text-send">Send</span>
                <span class="input input-interval">
                    <input type="number" data-bind="textInput: trigger_delay.interval">
                </span>
                <span class="input input-unit">
                    <select data-bind="
                        options: $root.intervalUnits,
                        optionsText: 'label',
                        optionsValue: 'id',
                        value: trigger_delay.unit"></select>
                </span>
                <span class="text text-after">after</span>
                <!-- ko if: $index() === 0 -->
                <span class="input input-event">
                    <select>
                        <option>Event X</option>
                        <option>Event Y</option>
                        <option>Event Z</option>
                    </select>
                </span>
                <!-- /ko -->
                <!-- ko if: $index() !== 0 -->
                <span class="input input-event">
                    <select disabled="disabled">
                        <option data-bind="html: 'Email #' + ($index() - 1)"></option>
                    </select>
                </span>
                <!-- /ko -->
                <button class="btn btn-primary btn-xs pull-right" data-bind="click: $root.toggleTemplate">
                    <!-- ko if: !showTemplate() -->
                        View Template
                        <i class="fa fa-chevron-down"></i>
                    <!-- /ko -->
                    <!-- ko if: showTemplate() -->
                        Hide Template
                        <i class="fa fa-chevron-up"></i>
                    <!-- /ko -->
                </button>
            </div>
            <div class="fields" data-bind="css: {show: showTemplate}">
                <div class="field text">
                    <label>
                        <span class="label">
                            Subject*
                        </span>
                        <span class="input">
                            <input type="text" name="label"  class="" placeholder="Define the email&#039;s subject" data-bind="textInput: subject" />
                        <span>
                    </label>
                </div>
                <div class="field textarea">
                    <label>
                        <span class="label">
                            Body*
                        </span>
                        <span class="input">
                            <textarea name="label" class="wysiwyg" placeholder="Define the email&#039;s body" data-bind="textInput: body_html" /></textarea>
                            <div class="shortcodes">
                                The following shortcodes are available for you to use:
                                <code>[:FIRST_NAME:]</code>
                                <code>[:LAST_NAME:]</code>
                                <code>[:EMAIL:]</code>
                                <code>[:BUSINESS_NAME:]</code>
                            </div>
                        <span>
                    </label>
                </div>
            </div>
        </fieldset>
    </div>
    <p class="text-center">
        <a href="#" class="btn btn-sm btn-warning btn-block" data-bind="click: addEmail">
            <i class="fa fa-plus"></i>
            Add Email
        </a>
    </p>
    <hr />
    <?=form_open()?>
    <button class="btn btn-primary">
        Save Changes
    </button>
    <?=form_close()?>
</div>
