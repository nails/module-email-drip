/* globals ko, console */
/* exported dripCampaignEdit*/
var dripCampaignEdit = function(emails) {

    /**
     * Avoid scope issues in callbacks and anonymous functions by referring to `this` as `base`
     * @type {Object}
     */
    var base = this;

    // --------------------------------------------------------------------------

    if (emails) {
        for (var i = emails.length - 1; i >= 0; i--) {
            emails[i].showTemplate = ko.observable(false);
        }
    }

    // --------------------------------------------------------------------------


    /**
     * The emails attached to this campaign
     * @type {observableArray}
     */
    base.emails = ko.observableArray(emails);

    // --------------------------------------------------------------------------

    /**
     * The interval units which the user can choose from
     * @type {Object}
     */
    base.intervalUnits = [
        {
            'id': 'DAY',
            'label': 'Days'
        },
        {
            'id': 'WEEK',
            'label': 'Weeks'
        },
        {
            'id': 'MONTH',
            'label': 'Months'
        },
        {
            'id': 'YEAR',
            'label': 'Years'
        }
    ];

    // --------------------------------------------------------------------------

    base.toggleTemplate = function()
    {
        this.showTemplate(!this.showTemplate());
    };

    // --------------------------------------------------------------------------

    base.addEmail = function()
    {
        var email = {
            'subject': '',
            'body_html': '',
            'body_text': '',
            'showTemplate': ko.observable(false),
            'trigger_event': '',
            'trigger_delay': {
                'interval': 1,
                'unit': 'DAY'
            }
        };

        base.emails.push(email);
    };

    // --------------------------------------------------------------------------

    base.removeEmail = function()
    {
        base.emails.remove(this);
    };

    // --------------------------------------------------------------------------

    base.moveUp = function()
    {
        base.warn('@todo: move email up the list');
    };

    // --------------------------------------------------------------------------

    base.moveDown = function()
    {
        base.warn('@todo: move email down the list');
    };

    // --------------------------------------------------------------------------

    /**
     * Write a log to the console
     * @param  {String} message The message to log
     * @param  {Mixed}  payload Any additional data to display in the console
     * @return {Void}
     */
    base.log = function(message, payload)
    {
        if (typeof(console.log) === 'function') {

            if (payload !== undefined) {

                console.log('EmailDrip Campaign:', message, payload);

            } else {

                console.log('EmailDrip Campaign:', message);
            }
        }
    };

    // --------------------------------------------------------------------------

    /**
     * Write a warning to the console
     * @param  {String} message The message to warn
     * @param  {Mixed}  payload Any additional data to display in the console
     * @return {Void}
     */
    base.warn = function(message, payload)
    {
        if (typeof(console.warn) === 'function') {

            if (payload !== undefined) {

                console.warn('EmailDrip Campaign:', message, payload);

            } else {

                console.warn('EmailDrip Campaign:', message);
            }
        }
    };
};
