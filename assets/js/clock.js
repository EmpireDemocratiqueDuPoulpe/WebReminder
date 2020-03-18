/**
 * Clock will show and update a clock present on the page. This clock (dd/MM/yyyy - hh:mm:ss) is updated every seconds.
 *
 * @version     1.0
 * @type        {Object}
 * @namespace   Clock
 */
const Clock = {

    /** Properties of Clock
     *
     * @memberof    Clock
     * @property    {HTMLParagraphElement}  parentDOM           Container in which the date is written.
     * @property    {Number}                interval            Interval ID of the clock.
     * @property    {Number}                intervalTimeout     Timeout used by the interval.
     */
    parentDOM: document.querySelector("#date"),
    interval: null,
    intervalTimeout: 1000,

    /**
     * Start the clock
     *
     * @memberof    Clock
     * @function    start
     * @return      {void}
     * @example     Clock.start();
     */
    start: function() {

        this.updateClock();
        this.interval = setInterval(function () { Clock.updateClock(); }, Clock.intervalTimeout);
    },

    /**
     * Stop the clock
     *
     * @memberof    Clock
     * @function    stop
     * @return      {void}
     * @example     Clock.stop();
     */
    stop: function() {

        clearInterval(this.interval);
    },

    /**
     * Update the clock. Clock.start() start an interval on this function.
     *
     * @memberof    Clock
     * @function    updateClock
     * @return      {void}
     * @example     Clock.updateClock();
     */
    updateClock: function () {

        const currentDate = new Date();

        const day = this.pad(currentDate.getDate(), 2);
        const month = this.pad(currentDate.getMonth() + 1, 2);
        const year = this.pad(currentDate.getFullYear(), 2);
        const hour = this.pad(currentDate.getHours(), 2);
        const minutes = this.pad(currentDate.getMinutes(), 2);
        const seconds = this.pad(currentDate.getSeconds(), 2);

        this.parentDOM.innerHTML = day+"/"+month+"/"+year + " - " + hour+":"+minutes+":"+seconds;
    },

    /**
     * Add leading zeros to a number.
     *
     * @memberof    Clock
     * @function    pad
     * @param       {Number}    number      Number to pad
     * @param       {Number}    size        Number of leading zeros
     * @return      {Number}                Number with leading zeros
     * @example     Clock.pad(5, 3);
     */
    pad: function (number, size) {

        number = String(number);

        while (number.length < size) number = "0" + number;
        return number;
    }
};

/**
 * Start the script when the DOM is loaded.
 *
 * @function
 * @return      {void}
 */
window.onload = function () { Clock.start(); };