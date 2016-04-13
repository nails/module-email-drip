<div class="group-email-drip campaign edit">
    <h2>Campaign Details &amp; Configurations</h2>
    <?=form_open()?>
    <fieldset>
        <legend>
            Details
        </legend>
        <?php

        $aField = array(
            'key'      => 'segment',
            'label'    => 'Segment',
            'required' => true,
            'default'  => !empty($campaign->segment_id) ? $campaign->segment_id : '',
            'class'    => 'select2'
        );
        echo form_field_dropdown($aField, $segments);

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
                <select name="process[hour]">
                    <option value="00">00</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                </select>
                :
                <select name="process[min]">
                    <option value="00">00</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
                    <option value="49">49</option>
                    <option value="50">50</option>
                    <option value="51">51</option>
                    <option value="52">52</option>
                    <option value="53">53</option>
                    <option value="54">54</option>
                    <option value="55">55</option>
                    <option value="56">56</option>
                    <option value="57">57</option>
                    <option value="58">58</option>
                    <option value="59">59</option>
                </select>
            </div>
            on
            <label>
                <input type="checkbox" checked="checked" value="0" name="process[day][]"> Monday
            </label>
            <label>
                <input type="checkbox" checked="checked" value="1" name="process[day][]"> Tuesday
            </label>
            <label>
                <input type="checkbox" checked="checked" value="2" name="process[day][]"> Wednesday
            </label>
            <label>
                <input type="checkbox" checked="checked" value="3" name="process[day][]"> Thursday
            </label>
            <label>
                <input type="checkbox" checked="checked" value="4" name="process[day][]"> Friday
            </label>
            <label>
                <input type="checkbox" checked="checked" value="5" name="process[day][]"> Saturday
            </label>
            <label>
                <input type="checkbox" checked="checked" value="6" name="process[day][]"> Sunday
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
                                <a href="#available-shortcodes" class="fancybox btn btn-default btn-xs">
                                    View available shortcodes
                                </a>
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
    <button class="btn btn-primary">
        Save Changes
    </button>
    <?=form_close()?>
    <div id="available-shortcodes" style="display: none;">
        <table class="group-email-drip-shortcodes">
            <thead>
                <tr>
                    <th>Shortcode</th>
                    <th>Replaced With</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="code">
                        <code>{{user.id}}</code>
                    </td>
                    <td class="description">
                        The user's ID
                    </td>
                </tr>
                <tr>
                    <td class="code">
                        <code>{{user.title}}</code>
                    </td>
                    <td class="description">
                        The user's title
                    </td>
                </tr>
                <tr>
                    <td class="code">
                        <code>{{user.first_name}}</code>
                    </td>
                    <td class="description">
                        The user's first name
                    </td>
                </tr>
                <tr>
                    <td class="code">
                        <code>{{user.last_name}}</code>
                    </td>
                    <td class="description">
                        The user's last name
                    </td>
                </tr>
                <tr>
                    <td class="code">
                        <code>{{user.email}}</code>
                    </td>
                    <td class="description">
                        The user's email address
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>